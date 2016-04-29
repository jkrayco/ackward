#include <SPI.h>
#include <UIPEthernet.h>
#include <UIPUdp.h>
#include <Time.h>
#include <Wire.h>
#include <LCD.h>
#include <DNS.h>
#include <LiquidCrystal_I2C.h>

//LCD Settings
#define I2C_ADDR    0x3F // <<----- Add your address here.  Find it from I2C Scanner
#define BACKLIGHT_PIN     3
#define En_pin  2
#define Rw_pin  1
#define Rs_pin  0
#define D4_pin  4
#define D5_pin  5
#define D6_pin  6
#define D7_pin  7

LiquidCrystal_I2C lcd(I2C_ADDR,En_pin,Rw_pin,Rs_pin,D4_pin,D5_pin,D6_pin,D7_pin);

/* ******** Ethernet Card Settings ******** */
// Set this to your Ethernet Card Mac and IP Address
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
IPAddress ip(192, 168, 1, 145);

/* ******** Web Server Settings ******** */
byte server[] = {192, 168, 1, 5};

/* ******** NTP Server Settings ******** */
/* us.pool.ntp.org NTP server
   (Set to your time server of choice) */
IPAddress timeServer;

/* Set this to the offset (in seconds) to your local time
   This example is GMT - 4 */
const long timeZoneOffset = +28800L; 

/* Syncs to NTP server every 20 minutes */
unsigned int ntpSyncTime = 10;       //10 seconds for testing


/* ALTER THESE VARIABLES AT YOUR OWN RISK */
// local port to listen for UDP packets
unsigned int localPort = 8888;
// NTP time stamp is in the first 48 bytes of the message
const int NTP_PACKET_SIZE= 48;     
// Buffer to hold incoming and outgoing packets
byte packetBuffer[NTP_PACKET_SIZE]; 
// A UDP instance to let us send and receive packets over UDP
EthernetUDP Udp;                   
// Keeps track of how long ago we updated the NTP server
unsigned long ntpLastUpdate = 0;   
// Check last time clock displayed (Not in Production)
time_t prevDisplay = 0;           

// Do not alter this function, it is used by the system
unsigned long sendNTPpacket(IPAddress& address)
{
  memset(packetBuffer, 0, NTP_PACKET_SIZE);
  packetBuffer[0] = 0b11100011;
  packetBuffer[1] = 0;
  packetBuffer[2] = 6;
  packetBuffer[3] = 0xEC;
  packetBuffer[12]  = 49;
  packetBuffer[13]  = 0x4E;
  packetBuffer[14]  = 49;
  packetBuffer[15]  = 52;                 
  Udp.beginPacket(address, 123);
  Udp.write(packetBuffer,NTP_PACKET_SIZE);
  Udp.endPacket();
}

// Do not alter this function, it is used by the system
int getTimeAndDate() {
   int flag=0;
   Udp.begin(localPort);
   sendNTPpacket(timeServer);
   delay(1000);
   if (Udp.parsePacket()){
     Udp.read(packetBuffer,NTP_PACKET_SIZE);  // read the packet into the buffer
     unsigned long highWord, lowWord, epoch;
     highWord = word(packetBuffer[40], packetBuffer[41]);
     lowWord = word(packetBuffer[42], packetBuffer[43]); 
     epoch = highWord << 16 | lowWord;
     epoch = epoch - 2208988800 + timeZoneOffset;
     flag=1;
     setTime(epoch);
     ntpLastUpdate = now();
   }
   return flag;
}

// Clock display of the time and date (Basic)
void clockDisplay(){
  Serial.print(hour());
  printDigits(minute());
  printDigits(second());
  Serial.print(" ");
  Serial.print(day());
  Serial.print(" ");
  Serial.print(month());
  Serial.print(" ");
  Serial.print(year());
  Serial.println();
 
  lcd.setCursor (0,0);
  if (month() < 10){
   lcd.print("0"); }
   lcd.print(month());
   lcd.print("/");
  if (day() < 10){
   lcd.print("0"); }
   lcd.print(day());
   lcd.print("/");
   lcd.print(year());
 
 lcd.setCursor (0,1);
  if (hour() < 10){
    lcd.print("0"); }
  if (hour() > 12){
    lcd.print(hour()-12);}
  else {
    lcd.print(hour()); } 
    lcd.print(":");
  if (minute() < 10){
    lcd.print("0"); }
    lcd.print(minute());
    lcd.print(":");
  if (second() < 10){
    lcd.print("0"); }
    lcd.print(second());
   if (hour() > 12){
    lcd.print(" PM"); }
    else {
    lcd.print(" AM"); } 
}

// Utility function for clock display: prints preceding colon and leading 0
void printDigits(int digits){
  Serial.print(":");
  if(digits < 10)
    Serial.print('0');
  Serial.print(digits);
}

void checkEvent(){
  EthernetClient client;
  boolean comma = false, start = false;
  String eventTitle = "", eventTime = "";
  
  Serial.println("Updating...");
  
    // if you get a connection, report back via serial:
    if (client.connect(server, 80)) {
      Serial.println("Connected");
      // Make an HTTP request:
      client.println("GET /ackward/test.php HTTP/1.1");
      client.println("Host: 192.168.1.5");
      client.println("Connection: close");
      client.println();
    } else {
      // if you didn't get a connection to the server:
      Serial.print("Connection failed: ");
    }
   
  // if there are incoming bytes available
  // from the server, read them and print them:
  while (client.connected()){
    while (client.available()) {
      char c = client.read();
      if (c == '*')
        start = true;
      else if (start){
        if (c == ',')
          comma = true;
        else if (!comma)
          eventTitle += c;
        else
          eventTime += c;
      }  
    }
  }

  // if the server's disconnected, stop the client:
    Serial.println();
    Serial.print(eventTitle);
    Serial.print(", ");
    Serial.println(eventTime.toInt());
    client.stop();
}

void setup() {
  lcd.begin (16,2);
  
  lcd.setBacklightPin(BACKLIGHT_PIN,POSITIVE);
  lcd.setBacklight(HIGH);
   
  Serial.begin(9600);

  // Ethernet shield and NTP setup
  Ethernet.begin(mac, ip);
  
  delay(1000);
  
  //print your local IP address:
  Serial.print("My IP address: ");
  for (byte thisByte = 0; thisByte < 4; thisByte++) {
    // print the value of each byte of the IP address:
    Serial.print(Ethernet.localIP()[thisByte], DEC);
    Serial.print(".");
  }
  Serial.println();

  DNSClient dns;
  dns.begin(Ethernet.dnsServerIP());
  while(!dns.getHostByName("pool.ntp.org",timeServer));
  Serial.print("NTP IP from the pool: ");
  Serial.println(timeServer);
    
  //Try to get the date and time
  int trys=0;
  while(!getTimeAndDate() && trys<10) {
    trys++;
  }
}

// This is where all the magic happens...
void loop() {
    // Update the time via NTP server as often as the time you set at the top
    if(now()-ntpLastUpdate >= ntpSyncTime) {
      checkEvent();
      int trys=0;
      while(!getTimeAndDate() && trys<10){
        trys++;
      }
      if(trys<10){
        Serial.println("ntp server update success");
      }
      else{
        Serial.println("ntp server update failed");
      }
    }
  
    // Display the time if it has changed by more than a second.
    if( now() != prevDisplay){
      prevDisplay = now();
      clockDisplay(); 
    }
}
