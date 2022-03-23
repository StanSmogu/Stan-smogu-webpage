ids=3

START=0xFA
STOP1=0x0D
STOP2=0x0A

from tkinter import *
import tkinter as tk
import serial
import time
import threading
import mysql.connector



global ser
global UART


UART=serial.Serial('/dev/ttyUSB0',9600,8,'N',1,0)


def insert_live(ozone,no2,co2,pm25,pm10, temp,wind_d,wind_s,wind_g,ozone_temperature,ozone_humidity,no2_temperature,no2_humidity):

    try:
        mydb = mysql.connector.connect(host="79.189.200.10",port="3400",user="meteo_zam",passwd="2&X(jX]l@R$0=]4",database="meteo_zam")
        mycursor=mydb.cursor()
        #print (database_live)
        sql = "INSERT INTO measure_live (ids,ozone,no2,co2,pm2_5, pm10,temperature,wind_direction,wind_speed,wind_gust,ozone_temperature,ozone_humidity,no2_temperature,no2_humidity) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
        val = (ids,ozone,no2,co2,pm25,pm10, temp,wind_d,wind_s,wind_g,ozone_temperature,ozone_humidity,no2_temperature,no2_humidity)
        mycursor.execute(sql, val)
        mydb.commit()

        print(mycursor.rowcount, " new live record inserted.")
    except mysql.connector.Error as e:
        print ("Error code:", e.errno)        # error number
        print ("SQLSTATE value:", e.sqlstate) # SQLSTATE value
        print ("Error message:", e.msg )      # error message
        print ("Error:", e)                # errno, sqlstate, msg values
        s = str(e)
        print ("Error:", s)                  # errno, sqlstate, msg values


def update_technical(error__vent,error_ozone_sensor,error_no2_sensor,heater,reserve):

    try:
        mydb = mysql.connector.connect(host="79.189.200.10",port="3400",user="meteo_zam",passwd="2&X(jX]l@R$0=]4",database="meteo_zam")
        mycursor=mydb.cursor()
        #print (database_live)
        sql = "UPDATE errors SET vent = %s,ozone=%s,no2=%s,heater=%s,reserve=%s  WHERE ids = %s"
        val = (error__vent,error_ozone_sensor,error_no2_sensor,heater,reserve,ids)
        mycursor.execute(sql, val)
        mydb.commit()

        print(mycursor.rowcount, " record updated.")
    except mysql.connector.Error as e:
        print ("Error code:", e.errno)        # error number
        print ("SQLSTATE value:", e.sqlstate) # SQLSTATE value
        print ("Error message:", e.msg )      # error message
        print ("Error:", e)                # errno, sqlstate, msg values
        s = str(e)
        print ("Error:", s)                  # errno, sqlstate, msg values

def delete_old():

    try:
        mydb = mysql.connector.connect(host="79.189.200.10",port="3400",user="meteo_zam",passwd="2&X(jX]l@R$0=]4",database="meteo_zam")
        mycursor=mydb.cursor()
        sql = "DELETE FROM measure_live WHERE ids = 3 AND measure_date < DATE_SUB(NOW(),INTERVAL 2 hour)"
        val = (ids)
        mycursor.execute(sql,val)
        mydb.commit()

        print(mycursor.rowcount, " record deleated.")
    except mysql.connector.Error as e:
        print ("Error code:", e.errno)        # error number
        print ("SQLSTATE value:", e.sqlstate) # SQLSTATE value
        print ("Error message:", e.msg )      # error message
        print ("Error:", e)                # errno, sqlstate, msg values
        s = str(e)
        print ("Error:", s)                  # errno, sqlstate, msg values

def measure():
    while (True):
        s=''
        c=0
        c=UART.inWaiting()
        data=[]
        
        if c:
            s=UART.read(c)
            print (s)
            for i in range (0,len(s)):
                data.append(chr(s[i]))
            if (len(data)==52):
                start=data[0]
                stop1=data[50]
                stop2=data[51]
                if (start==chr(START)):
                    if (stop1+stop2==chr(STOP1)+chr(STOP2)):
                        print ("Odebrano ramke")
                        ozone=data[1]+data[2]+data[3]+data[4]
                        ozone_temperature=data[5]+data[6]+data[7]
                        ozone_humidity=data[8]+data[9]
                        no2=data[10]+data[11]+data[12]+data[13]
                        no2_temperature=data[14]+data[15]+data[16]
                        no2_humidity=data[17]+data[18]
                        co2=data[19]+data[20]+data[21]+data[22]
                        pm25=data[23]+data[24]+data[25]+data[26]
                        pm10=data[27]+data[28]+data[29]+data[30]
                        temp=data[31]+data[32]+data[33]+'.'+data[34]
                        wind_d=data[35]
                        wind_s=data[36]+data[37]+data[38]
                        wind_g=data[39]+data[40]+data[41]
                        error__vent=data[42]
                        error_ozone_sensor=data[43]
                        error_no2_sensor=data[44]
                        heater=data[45]
                        reserve=data[46]
                        cr=data[47]+data[48]+data[49]
                        
                        insert_live(ozone,no2,co2,pm25,pm10,temp,wind_d,wind_s,wind_g,ozone_temperature,ozone_humidity,no2_temperature,no2_humidity)
                        update_technical(error__vent,error_ozone_sensor,error_no2_sensor,heater,reserve)
                        delete_old()
        time.sleep(1)


measure()
    

    
