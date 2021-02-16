#Libraries
import RPi.GPIO as GPIO
import time
import MySQLdb
from datetime import datetime

tijd = datetime.now()
gemeten_afstand = 0
kade_naam = ""
kade_vrij = True

database = MySQLdb.connect(
                    host="51.144.6.40",    # your host, usually localhost
                    user="wodran",         # your username
                    passwd="R1234-56!abc",  # your password
                    db="project2D")        # name of the data base

mycursor = database.cursor() 
#GPIO Mode (BOARD / BCM)
GPIO.setmode(GPIO.BCM)
 
#set GPIO Pins
GPIO_TRIGGER1 = 18
GPIO_TRIGGER2 = 17
GPIO_ECHO1 = 24
GPIO_ECHO2 = 27
 
#set GPIO direction (IN / OUT)
GPIO.setup(GPIO_TRIGGER1, GPIO.OUT)
GPIO.setup(GPIO_TRIGGER2, GPIO.OUT)
GPIO.setup(GPIO_ECHO1, GPIO.IN)
GPIO.setup(GPIO_ECHO2, GPIO.IN)

#set variabelen
teller1 = 0
teller2 = 0
kade_vrij1 = True
kade_vrij2 = True

def distance1():
    # set Trigger to HIGH
    GPIO.output(GPIO_TRIGGER1, True)
 
    # set Trigger after 0.01ms to LOW
    time.sleep(0.00001)
    GPIO.output(GPIO_TRIGGER1, False)
 
    StartTime1 = time.time()
    StopTime1 = time.time()
 
    # save StartTime
    while GPIO.input(GPIO_ECHO1) == 0:
        StartTime1 = time.time()
 
    # save time of arrival
    while GPIO.input(GPIO_ECHO1) == 1:
        StopTime1 = time.time()
 
    # time difference between start and arrival
    TimeElapsed1 = StopTime1 - StartTime1
    # multiply with the sonic speed (34300 cm/s)
    # and divide by 2, because there and back
    distance1 = (TimeElapsed1 * 34300) / 2
 
    return distance1

def distance2():
    # set Trigger to HIGH
    GPIO.output(GPIO_TRIGGER2, True)
 
    # set Trigger after 0.01ms to LOW
    time.sleep(0.00001)
    GPIO.output(GPIO_TRIGGER2, False)
 
    StartTime2 = time.time()
    StopTime2 = time.time()
 
    # save StartTime
    while GPIO.input(GPIO_ECHO2) == 0:
        StartTime2 = time.time()
 
    # save time of arrival
    while GPIO.input(GPIO_ECHO2) == 1:
        StopTime2 = time.time()
 
    # time difference between start and arrival
    TimeElapsed2 = StopTime2 - StartTime2
    # multiply with the sonic speed (34300 cm/s)
    # and divide by 2, because there and back
    distance2 = (TimeElapsed2 * 34300) / 2
 
    return distance2
 
if __name__ == '__main__':
    try:
        while True:
            dist1 = distance1()
            print ("Gemeten afstand sensor 1 = %.1f cm" % dist1)
            if dist1 < 100:
                teller1 = teller1 + 1
            else:
                teller1 = 0

            if teller1 > 10:
                kade_vrij1 = True
            else:
                kade_vrij1 = False

            kade_vrij = kade_vrij1
            gemeten_afstand = dist1
            kade_naam = "kade1"
            
            print (kade_naam)
            print (gemeten_afstand)
            print (kade_vrij)
            print (tijd)

            sql = "INSERT INTO sensordatas (kadeNaam, afstand, kadeVrij, tijdstip) VALUES (%s, %s, %s, %s)"
            val = (kade_naam, gemeten_afstand, kade_vrij, tijd)
            mycursor.execute(sql, val)
            database.commit()
            print(mycursor.rowcount, "Waardes toegevoegd!")
            time.sleep(1)

            dist2 = distance2()
            dist2 = dist2
            print ("Gemeten afstand sensor 3 = %.1f cm" % dist2)
            if dist2 < 100:
                teller2 = teller2 + 1
            else:
                teller2 = 0

            if teller2 > 10:
                kade_vrij2 = True
            else:
                kade_vrij2 = False

            kade_vrij = kade_vrij2
            gemeten_afstand = dist2
            kade_naam = "kade3"

            print (kade_naam)
            print (gemeten_afstand)
            print (kade_vrij)
            print (tijd)

            sql = "INSERT INTO sensordatas (kadeNaam, afstand, kadeVrij, tijdstip) VALUES (%s, %s, %s, %s)"
            val = (kade_naam, gemeten_afstand, kade_vrij, tijd)
            mycursor.execute(sql, val)
            database.commit()
            print(mycursor.rowcount, "Waardes toegevoegd!")
            time.sleep(5)
 
        # Reset by pressing CTRL + C
    except KeyboardInterrupt:
        print("Meting gestopt door User")
        database.close()
        GPIO.cleanup()