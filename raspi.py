import serial, requests, time, statistics

def get_status():
    read_string =  None
    values = []

    with serial.Serial('/dev/ttyACM0', 9600, timeout=1) as ser:
      
        while len(values) < 10:
          try:
            read_string = ser.readline()

            values.append(int(read_string))
          except:
            continue

    return str(int(statistics.median(values)))

requests.post('https://www.ifsr.de/buerostatus/input.php', data = {'ts': int(time.time()), 'val': get_status()})
