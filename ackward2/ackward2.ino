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
// Set this to your Ethernet Card Mac Address
byte mac[] = { 0x90, 0xA2, 0xDA, 0x00, 0x23, 0x36 };

/* ******** NTP Server Settings ******** */
/* us.pool.ntp.org NTP server
   (Set to your time server of choice) */
IPAddress timeServer;

/* Set this to the offset (in seconds) to your local time
   This example is GMT - 4 */
const long timeZoneOffset = +28800L; 

/* Syncs to NTP server every 20 minutes */
unsigned int ntpSyncTime = 1200;       


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

void setup() {
   lcd.begin (16,2);
   lcd.setBacklight(HIGH);
  
   lcd.setBacklightPin(BACKLIGHT_PIN,POSITIVE);
   
   Serial.begin(9600);
  
   // Ethernet shield and NTP setup
   int i = 0;
   int DHCP = 0;
   DHCP = Ethernet.begin(mac);
   //Try to get dhcp settings 30 times before giving up
   while( DHCP == 0 && i < 30){
     delay(1000);
     DHCP = Ethernet.begin(mac);
     i++;
   }
   if(!DHCP){
    Serial.println("DHCP FAILED");
     for(;;); //Infinite loop because DHCP Failed
   }
  
  // print your local IP address:
  Serial.print("My IP address: ");
  for (byte thisByte = 0; thisByte < 4; thisByte++) {
    // print the value of each byte of the IP address:
    Serial.print(Ethernet.localIP()[thisByte], DEC);
    Serial.print(".");
  }
  Serial.println();

  DNSClient dns;
  dns.begin(Ethernet.dnsServerIP());
  dns.getHostByName("pool.ntp.org",timeServer);
  Serial.print("NTP IP from the pool: ");
  Serial.println(timeServer);
  
   //Try to get the date and time
   int trys=0;
   while(!getTimeAndDate() && trys<10) {
     trys++;
   }
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
 
  lcd.setCursor (0,1);
  if (month() < 10){
   lcd.print("0"); }
   lcd.print(month());
   lcd.print("/");
  if (day() < 10){
   lcd.print("0"); }
   lcd.print(day());
   lcd.print("/");
   lcd.print(year());
}

// Utility function for clock display: prints preceding colon and leading 0
void printDigits(int digits){
  Serial.print(":");
  if(digits < 10)
    Serial.print('0');
  Serial.print(digits);
}

// This is where all the magic happens...
void loop() {
    // Update the time via NTP server as often as the time you set at the top
    if(now()-ntpLastUpdate > ntpSyncTime) {
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
