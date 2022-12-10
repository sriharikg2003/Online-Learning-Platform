# from curses.ascii import ctrl
# import pandas as pd
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

# plt.subplot(1,3,1)
# a=['YOUR MARKS',"AVG",'MAX']
# val1=float(argv[1])
# val2=float(argv[2])
# val3=float(argv[3])
# arr = [val1,val3,val2]
# # print(a, arr)
# plt.bar(a,arr)

# plt.subplot(1,3,2)
# arr = np.array([float(argv[4]),float(argv[5])])
# plt.pie(arr)

# plt.subplot(1,3,3)
# print(argv[1])
# print(argv[2])
mail = []
marks = []
ctr=0
c=1
for i in argv[1]:
    if i == ',':
        mail+=[""]
        marks+=[""]
        c+=1
        
# for i in argv[1]:
#     if i==',' and ctr<c:
#         ctr+=1
#         continue
#     mail[ctr]+=i
ctr=0
for i in argv[2]:
    if i == ',' and ctr<c:
        ctr+=1
        continue
    marks[ctr]+=i
for i in range(c-1):
    s = marks[i]
    x = int(s)
    marks[i] = x

# print(mail)
# print(marks)
# x = np.array(mail)
# y = np.array(marks)
plt.subplot(1,3,1)
plt.tight_layout(pad=2.5)
# colors= np.random.rand(50)
plt.scatter(mail,marks,c="#003f5c")

plt.subplot(1,3,2)
x = ["MIN","AVG", "MAX"]
y = [float(argv[4]),float(argv[5]),float(argv[3])]
plt.bar(x,y, color=["#bc5090","#ff6361","#ffa600"])

q=[]
num=[]
c=1
z=[]
for i in argv[6]:
    if i == ',':
        q+=[""]
        num+=[""]
        c+=1
        z+=[0]
ctr=0
for i in argv[6]:
    if i == ',' and ctr<c:
        ctr+=1
        continue
    q[ctr]+=i
ctr=0
for i in argv[7]:
    if i == ',' and ctr<c:
        ctr+=1
        continue
    num[ctr]+=i
for i in range(c-1):
    s = num[i]
    x = int(s)
    num[i] = x
for i in range(ctr):
    z[i]=(i+1)
# q=np.array(q)
# num=np.array(num) 
 
plt.subplot(1,3,3)
plt.step(z,num)


# s = pd.Series([20, 8, 14])
# fi, ax = plt.subplots()
# s.plot.bar()
# fi.savefig('myplot.png')

plt.savefig('myplot.png')

# to open/create a new html file in the write mode
f = open('graphProf.html', 'w')
  
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
webbrowser.open('file:///'+os.path.realpath("graphProf.html"))



