import sqlite3
import requests
import time

import setupdb


with sqlite3.connect("buerostatus.db") as conn:
	cursor = conn.cursor()

	r = requests.get('http://raspi.local:1337/')
	
	if r.status_code == 200:
		timestamp = int(time.time())
		light_value = int(r.text)

		print("LIGHT: " + light_value + " AT: " + timestamp)

		conn.execute("INSERT INTO buerostatus (timestamp, value) VALUES (" + timestamp + ", " + value + ")")
		conn.commit()
