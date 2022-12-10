# from curses.ascii import ctrl
import pandas as pd
import matplotlib.pyplot as plt
import webbrowser
import os
import numpy as np
from sys import argv
# from sqlfile import a, arr
# print(a,arr)

# plt.bar(a,arr)

# import mysql.connector

# connection = mysql.connector.connect(host='localhost',database='classroom',user='root',password='')
# cursor = connection.cursor()
# cursor.execute("select * from graph order by id desc limit 1")
# record = cursor.fetchall()
# record=record[0]
# testid=record[1]
# studentemail=record[2]
# print(studentemail)
# cursor.execute('select marks_obtained from marksheet where stu_email="'+studentemail+'" and test_id='+str(testid))
# res= cursor.fetchall()
# res=res[0]
# cursor.execute('select MAX(marks_obtained),AVG(marks_obtained) from marksheet where test_id='+str(testid))
# stat= cursor.fetchall()

plt.subplot(1,3,1)
plt.tight_layout(pad=3.5)
a=['YOU',"AVG",'MAX']
val1=float(argv[1])
val2=float(argv[2])
val3=float(argv[3])
arr = [val1,val3,val2]
# print(a, arr)
plt.bar(a,arr, color=["#bc5090","#ff6361","#ffa600"])

plt.subplot(1,3,2)
arr = np.array([float(argv[4]),float(argv[5])])
label=["Correct","Incorrect"]
plt.pie(arr, labels=label, colors=["#003f5c", "#ff6361"])
# plt.pie(arr)

plt.subplot(1,3,3)
ques = [""]
score = [0]
ctr=0
z=[0]
for i in argv[6]:
    if i == ',':
        ques+=[""]
        score+=[0]
        z+=[0]
        
for i in argv[6]:
    if i==',':
        ctr+=1
        continue
    ques[ctr]+=i
ctr=0
for i in argv[7]:
    if i == ',':
        ctr+=1
        continue
    score[ctr]+=int(i)
for i in range(ctr):
    z[i]=(i+1)
# print(ques)
# print(score)
x = np.array(ques)
y = np.array(score)
z= np.array(z)
plt.stem(z,y,markerfmt='D',linefmt="#2f4b7c",basefmt="#2f4b7c")

# s = pd.Series([20, 8, 14])
# fi, ax = plt.subplots()
# s.plot.bar()
# fi.savefig('myplot.png')

plt.savefig('myplot.png')

# to open/create a new html file in the write mode
f = open('try2.html', 'w')
  
# the html code which will go in the file GFG.html
html_template = """
<html>
<head></head>
<body>
<img src="myplot.png">
</body>
</html>
"""
# writing the code into the file
f.write(html_template)
  
# close the file
f.close()
  
# 1st method how to open html files in chrome using
webbrowser.open('file:///'+os.path.realpath("try2.html"))



