#include <SPI.h>
#include <UIPEthernet.h>

// Enter a MAC address for your controller below.
// Newer Ethernet shields have a MAC address printed on a sticker on the shield
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
// if you don't want to use DNS (and reduce your sketch size)
// use the numeric IP instead of the name for the server:
//IPAddress server(74,125,232,128);  // numeric IP for Google (no DNS)
byte server[] = {192, 168, 1, 5};    // name address for Google (using DNS)

// Set the static IP address to use if the DHCP fails to assign
IPAddress ip(192, 168, 1, 145);

// Initialize the Ethernet client library
// with the IP address and port of the server
// that you want to connect to (port 80 is default for HTTP):
EthernetClient client;


boolean comma = false, start = false, nomore = false;
String eventTitle = "", eventTime = "";

void setup() {
  // Open serial communications and wait for port to open:
  Serial.begin(9600);

  // start the Ethernet connection:
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
    // try to congifure using IP address instead of DHCP:
    Ethernet.begin(mac, ip);
  }
  // give the Ethernet shield a second to initialize:
  delay(1000);
}

void konek(){
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

void disco(){
    Serial.println();
    Serial.print(eventTitle);
    Serial.print(", ");
    Serial.println(eventTime.toInt());
    Serial.println("disconnecting.");
    client.stop();

    while(true){}
}

void loop() {
  if (!nomore){
    Serial.println("connecting...");
  
    // if you get a connection, report back via serial:
    if (client.connect(server, 80)) {
      Serial.println("connected");
      // Make a HTTP request:
      client.println("GET /ackward/test.php HTTP/1.1");
      client.println("Host: 192.168.1.5");
      client.println("Connection: close");
      client.println();
    } else {
      // if you didn't get a connection to the server:
      Serial.print("connection failed: ");
    }
      nomore = true;
  }
  
  // if there are incoming bytes available
  // from the server, read them and print them:
  while (client.available()) {
    konek();
  }

  // if the server's disconnected, stop the client:
  if (!client.connected()) {
    disco();
  }
}
