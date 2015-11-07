import sqlite3
import os.path

if not os.path.exists("./server/buerostatus.db"):
	open("buerostatus.db", "w").close()
	with sqlite3.connect("buerostatus.db") as conn:
		cursor = conn.cursor()
		cursor.execute("CREATE TABLE buerostatus(id INTEGER PRIMARY KEY ASC, ts, val);")
		conn.commit()
		print("Successfully created 'buerostatus.db'.")
