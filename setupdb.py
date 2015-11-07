import sqlite3
import os.path

if os.path.exists("./buerostatus.db"):
	print("'buerostatus.db' already exists. I don't want to overwrite anything, please rename/delete that and restart the script.")
else:
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
