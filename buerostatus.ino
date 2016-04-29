#define aref_voltage 5
#define max_value 1024.0
#define lightPin 0
#define tempPin 1

int lightReading;
int tempReading;
 
void setup(void) {
  Serial.begin(9600);
}

void loop(void) {
  // temperature reading based on adafruit sample code
  // see https://learn.adafruit.com/tmp36-temperature-sensor/using-a-temp-sensor
  // verified with TMP36 datasheet
  // see http://www.analog.com/media/en/technical-documentation/data-sheets/TMP35_36_37.pdf
  tempReading = analogRead(tempPin);    
  // converting that reading to voltage, which is based off the reference voltage
  float voltage = (tempReading * aref_voltage) / max_value;
  // 0.5 V offset, 10mV per degree celsius
  // 25 C = 0.75 V
  float temperatureC = (voltage - 0.5) * 100;
  lightReading = analogRead(lightPin);
  Serial.print(lightReading);
  Serial.print(":");
  Serial.print(tempReading);
  Serial.print(":");
  Serial.println(temperatureC);
  
  delay(10);
}
