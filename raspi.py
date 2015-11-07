import serial, requests

def get_status():
    read_string =  None
    values = []

    with serial.Serial('/dev/ttyACM0', 9600, timeout=1) as ser:
      
        while len(values) < 10:
          try:
            read_string = ser.readline()

            # print(read_string)
            values.append(read_string.decode().replace('\r\n', ''))
          except:
            continue
  
    # values = read_string.decode().split('\r\n')
    # print(values)
    
    total = 0
    n = 0

    for val in values:
        if len(val) == 3:
            total += int(val)
            n += 1
    
    # print(total/n)
    return str(int(total/n))

requests.post('http://www.ifsr.de/buerostatus/receive.php', data = {'status': get_status()})
# print(get_status())
