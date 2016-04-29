import serial, requests, time

def get_status():
    read_string =  None
    values = []
    temps = []
    rawtemps = []
    with serial.Serial('/dev/ttyACM0', 9600, timeout=1) as ser:
      
        while len(values) < 10:
          try:
            read_string = ser.readline()
            # serial port gives bytes instead of string, so decode() it
            read_array = read_string.decode().split(':')
            # serial sync sometimes fails
            if len(read_array) != 3:
              continue
            values.append(int(read_array[0]))
            rawtemps.append(int(read_array[1]))
            temps.append(float(read_array[2]))
          except:
            continue

    values = sorted(values)
    rawtemps = sorted(rawtemps)
    temps = sorted(temps)
    return str(values[int(len(values)/2)]), str(rawtemps[int(len(rawtemps)/2)]), str(temps[int(len(temps)/2)]), 

val, rawtemp, temp = get_status()
requests.post('https://www.ifsr.de/buerostatus/input.php', data = {'ts': int(time.time()), 'val': val, 'rawtemp': rawtemp, 'temp': temp})
