int eingang = A0; // Lichtsensor ist am Analogport 0
int LED = 10;
int sensorWert = 0;

void setup() {
  Serial.begin(9600);
  pinMode (LED, OUTPUT);
}

void loop() {
  sensorWert = analogRead(eingang);

  Serial.print("Sensorwert = " );
  Serial.println(sensorWert);

  // Alles ueber 100 scheint gut auf Licht im Buero hinzuweisen.
  if (sensorWert > 100 ) {
    digitalWrite(LED, HIGH);
  } else {
    digitalWrite(LED, LOW);
  }

  delay (50);
}
