from asyncio.windows_events import NULL
from ctypes import sizeof
from itertools import count
import re
import mysql.connector
from Questgen import main
from fastapi import FastAPI
from pydantic import BaseModel
from transformers import pipeline
import tensorflow as tf


class ExtractedText(BaseModel):
    submissionId: str
    extractedText: str


app = FastAPI()

def utf_decoding(item):
    # remove any \x or any other hexadecimal encoding
    
    convert  = item.encode("iso-8859-1", "ignore")
    
    convert = "".join([x for x in item if ord(x) < 127])


    convert = re.sub('\s+', ' ', convert)

    convert = re.sub('-', '-', convert)
    #convert = "".join([x for x in convert if not x.isdigit()])
    
    payload = {
        "input_text": convert, "max_questions": 25
    }
    return payload

def upload(num_output, output,item):
    try:
          # mysql connection
        mydb = mysql.connector.connect(
            host="documentsubmissionsystem.c2tnrfke8bpv.us-east-1.rds.amazonaws.com",
            user="admin",
            password="documentsubmissionsystem",
            database="documentsubmissionsystem"
        )

        mycursor = mydb.cursor()

        for i in range(num_output):
            sql = "INSERT INTO question (submissionId, questionNum, stuAnswer, answer, context, options, statement) VALUES (%s, %s, %s, %s, %s, %s, %s)"
            val = (item.submissionId, output['questions'][i]['id'], "", output['questions'][i]['answer'], output['questions']
                [i]['context'], (",".join(output['questions'][i]['options'])), output['questions'][i]['question_statement'])
            mycursor.execute(sql, val)

            mydb.commit()

            print(mycursor.rowcount, "record inserted.")

        mydb.close()
        return 0
  
    except mysql.connector.Error as err:
    
        return err.errno


def questGen(item):
    payload = utf_decoding(item.extractedText)
    qg = main.QGen()
    output = qg.predict_mcq(payload)
    return output

@app.post("/question/")
async def create_item(item: ExtractedText):

    output = questGen(item) 
    num_output = len(output["questions"])

    if num_output > 5:
        num_output = 5

    outcome = upload(num_output,output, item) 

    if  outcome!= 0:
        return outcome
    else: 
        return output


@app.get("/")
def home():
    return {"Data": "Test"}