import serial, time

# Read the value from the serial output

def get_status():
    s =  None

    with serial.Serial('/dev/ttyACM0', 9600, timeout=3) as ser:
      
        while s is None:
          try:
            s = ser.read(39)

            print(s)
          except:
            continue
  
    values = s.decode().split('\r\n')
    # print(values)
    
    total = 0
    n = 0

    for val in values:
        if len(val) == 3 and '\\' not in val:
            total += int(val)
            n += 1
    
    # print(total/n)
    return int(total/n)

get_status()
# Save value to local SQLite DB

# Upload value to Kaki

# Don't forget to run this script periodically (via cron every 10 minutes?)
