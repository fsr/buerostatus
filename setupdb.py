import sqlite3
import os.path

if not os.path.exists("./buerostatus.db"):
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
