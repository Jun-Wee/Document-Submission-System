from fastapi import FastAPI
from ast import For
import mysql.connector
from Questgen import main
from pprint import pprint
import sys
import json
import os


app = FastAPI()

#this will be the endpoint questiongen with 4 input parameters that are mentioned in the curly brackets
@app.get("/questiongen/{mainfolder}/{unitcode}/{student}/{filename}")
def questiongen(mainfolder: str, unitcode:str, student:str,filename: str ):
    #change this pathway to the directory thats one above the StuSubmissions folder
    os.chdir("C:\\xampp\\htdocs\\xampp\\softwareproj")

    #create file pathway to the extracted text file
    filepathway = ".\\"+mainfolder+"\\"+unitcode+"\\"+student+"\\"+filename
 
    with open(filepathway,encoding="utf8") as file:
        extraction = file.read().replace('\n', '')
        extraction = extraction.replace('\t',' ')

    #remove any \x or any other hexadecimal encoding 
    convert = "".join([x for x in extraction if ord(x) < 127])

    #create format for json object
    obj = ' "input_text":" '+convert + '"'
    jsonobj = '{' + obj + '}'

    #convert to json object
    payload = json.loads(jsonobj)
    file.close()
    qg = main.QGen()
    output = qg.predict_mcq(payload)

    #mysql connection
    mydb = mysql.connector.connect(
        host="documentsubmissionsystem.c2tnrfke8bpv.us-east-1.rds.amazonaws.com",
        user="admin",
        password="documentsubmissionsystem",
        database="documentsubmissionsystem"
    )

    mycursor = mydb.cursor()

    for i in range(5):
        sql = "INSERT INTO question (submissionId, questionNum, stuAnswer, answer, context, options, statement) VALUES (%s, %s, %s, %s, %s, %s, %s)"
        val = (100070, output['questions'][i]['id'], "", output['questions'][i]['answer'], output['questions']
            [i]['context'], (",".join(output['questions'][i]['options'])), output['questions'][i]['question_statement'])
        mycursor.execute(sql, val)

        mydb.commit()

        print(mycursor.rowcount, "record inserted.")

    mydb.close()

    #JSON object gets returned 
    return {"generation": output}

