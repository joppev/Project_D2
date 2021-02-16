import requests
import os
import base64
import json
import time
import MySQLdb
from datetime import datetime
from datetime import timedelta
import RPi.GPIO as GPIO

#set GPIO
pinR = 23
pinG = 22
pinO = 25
pinM = 16
GPIO.setmode(GPIO.BCM)
GPIO.setup(pinR,GPIO.OUT) #Rood
GPIO.setup(pinG,GPIO.OUT) #Groen
GPIO.setup(pinO,GPIO.OUT) #Oranje
GPIO.setup(pinM,GPIO.OUT) #Moto

#set output to OFF
GPIO.output(pinR, GPIO.LOW)
GPIO.output(pinG, GPIO.LOW)
GPIO.output(pinO, GPIO.LOW)
GPIO.output(pinM, GPIO.HIGH)

#functie flikkerend licht
def blink(pin):
    teller = 0
    while teller < 20:
        GPIO.output(pin, 1)
        time.sleep(0.5)
        GPIO.output(pin, 0)
        time.sleep(0.5)
        teller = teller + 1

#functie slagboom
def motor(pin):
    teller = 0
    while teller < 1:
        GPIO.output(pin, 0)
        time.sleep(5)
        GPIO.output(pin, 1)
        time.sleep(1)
        teller = teller + 1


now = datetime.now()
now_plus_120 = now + timedelta(minutes = 120)
now_min_120 = now - timedelta(minutes = 120)

database = MySQLdb.connect(
                    host="51.144.6.40",    # your host, usually localhost
                    user="wodran",         # your username
                    passwd="R1234-56!abc",  # your password
                    db="project2D")        # name of the data base

mycursor = database.cursor() 
print ("database connected")

IMAGE_PATH = 'image.jpg'

def ocr(IMAGE_PATH):
    SECRET_KEY = 'sk_dc4bff00077db6ec8fe13ae8'
    with open(IMAGE_PATH, 'rb') as image_file:
            img_base64 = base64.b64encode(image_file.read())

    url = 'https://api.openalpr.com/v2/recognize_bytes?recognize_vehicle=1&country=be&secret_key=%s' % (SECRET_KEY)
    r = requests.post(url, data = img_base64)
    try:
        return(r.json()['results'][0]['plate'])

    except:
        print("Geen nummerplaat gevonden")
try:
    while True:
        GPIO.output(pinR,GPIO.LOW)
        GPIO.output(pinG,GPIO.LOW)
        os.system("sudo fswebcam image.jpg")
        fotonr = "image.jpg"
        uitkomstdef = ocr(fotonr)

        if uitkomstdef is None:
            uitkomstdef = "Geen nummerplaat in database toegevoegd"
            print (uitkomstdef)
            GPIO.output(pinR,GPIO.LOW)
            blink(pinO)
        else:
            print (uitkomstdef)
            sql_select_Query = "SELECT p.* FROM plannings p JOIN users u ON u.id = p.gebruikerID JOIN nummerplaats n ON u.bedrijfsID = n.bedrijfID WHERE n.plaatcombinatieZonderStreepjes = %s AND p.startTijd >= %s AND p.startTijd <= %s AND p.isAanwezig = False ORDER BY p.startTijd ASC LIMIT 1"
            mycursor.execute(sql_select_Query, (uitkomstdef, now_min_120, now_plus_120,))
            planninge = mycursor.fetchall()
            print("Totaal aantal planningen: ", mycursor.rowcount)
            if mycursor.rowcount == 1:
                sql = "INSERT INTO gescande_nummerplatens (plaatcombinatie, tijdstip) VALUES (%s, %s)"
                val = (uitkomstdef, now)
                mycursor.execute(sql, val)
                database.commit()
                print(mycursor.rowcount, "Nummerplaat toegevoegd!")
                sql_select_update = "UPDATE plannings SET isAanwezig = True WHERE id = %s"
                mycursor.execute(sql_select_update, (planninge[0][0],))
                database.commit()
                GPIO.output(pinG,GPIO.HIGH)
                print ("Planning updated")
                motor(pinM)
            else:
                GPIO.output(pinR,GPIO.HIGH)
        
        time.sleep(20)
        GPIO.output(pinR, GPIO.LOW)
        GPIO.output(pinG, GPIO.LOW)
        GPIO.output(pinO, GPIO.LOW)
        GPIO.output(pinM, GPIO.HIGH)

except KeyboardInterrupt:
    print("Meting gestopt door User")
    database.close()
    GPIO.cleanup()