int eingang = A0; // Lichtsensor ist am Analogport 0
int sensorWert = 0;

void setup() {
  Serial.begin(9600);
}

void loop() {
  sensorWert = analogRead(eingang);
  Serial.println(sensorWert);
  delay(50);
}

