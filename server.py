import sqlite3
import requests
import time
import os.path
from bottle import route, run


@route("/input")
def input():
	with sqlite3.connect("buerostatus.db") as conn:
		cursor = conn.cursor()
		
		timestamp = int(time.time())
		light_value = int()

		print("LIGHT: " + light_value + " AT: " + timestamp)

		conn.execute("INSERT INTO buerostatus (timestamp, value) VALUES (" + timestamp + ", " + value + ")")
		conn.commit()


if not os.path.exists("./buerostatus.db"):
	setupDB()
run(host='localhost', port=1337, debug=True)


def setupDB():
	open("buerostatus.db", "w").close()
	with sqlite3.connect("buerostatus.db") as conn:
		cursor = conn.cursor()
		cursor.execute('''
			CREATE TABLE `buerostatus` (
				`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
				`timestamp`	INTEGER NOT NULL UNIQUE,
				`value`	INTEGER NOT NULL
			);'''
		)
		conn.commit()
		print("Successfully created 'buerostatus.db'.")
