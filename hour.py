ids=3

START=0xFA
STOP1=0x0D
STOP2=0x0A

from tkinter import *
import tkinter as tk
import threading
import mysql.connector



def insert_hour():

    try:
        mydb = mysql.connector.connect(host="79.189.200.10",port="3400",user="meteo_zam",passwd="2&X(jX]l@R$0=]4",database="meteo_zam")
        mycursor=mydb.cursor()
        #print (database_live)
        sql = "INSERT INTO measure_hour (ids,ozone,no2,co2,pm2_5,pm10,temperature,wind_direction,wind_speed,wind_gust,ozone_temperature,ozone_humidity,no2_temperature,no2_humidity) SELECT ids,round(avg(ozone),0),round(avg(no2),0),round(avg(co2),0),round(avg(pm2_5),0),round(avg(pm10),0),round(avg(temperature),1),round(avg(wind_direction),0),round(avg(wind_speed),0),round(avg(wind_gust),0),round(avg(ozone_temperature),1),round(avg(ozone_humidity),0),round(avg(no2_temperature),1),round(avg(no2_humidity),0) FROM meteo_zam.measure_live WHERE measure_date > DATE_SUB(NOW(),INTERVAL 1 hour) AND ids=3"
        
        mycursor.execute(sql)
        mydb.commit()

        print(mycursor.rowcount, " new hour record inserted.")
    except mysql.connector.Error as e:
        print ("Error code:", e.errno)        # error number
        print ("SQLSTATE value:", e.sqlstate) # SQLSTATE value
        print ("Error message:", e.msg )      # error message
        print ("Error:", e)                # errno, sqlstate, msg values
        s = str(e)
        print ("Error:", s)                  # errno, sqlstate, msg values

insert_hour()
