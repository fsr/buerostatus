import serial
from bottle import route, run

@route('/')
def index():
	# Read ~5 values from the serial output
	# average them
	# return average

run(host='localhost', port=1337)
