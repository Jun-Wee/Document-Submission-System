import string
from fastapi import FastAPI

from ast import For
from Questgen import main
import json
import os

app = FastAPI()

@app.get("/questiongen/{filepathway}")
def about(filepathway: str):
    #change this pathway to the directory that has the StuSubmissions folder
    os.chdir("C:\\xampp\\htdocs\\xampp\\softwareproj")

    with open(".\\StuSubmission\\"+filepathway,encoding="utf8") as file:
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

    #payload = {
    #   "input_text": "The boom in technological advancements over the past 4 to 5 decades has led to an influx of electronic devices that helped to improve the lives of many. Technological breakthroughs such as microprocessors, light emitting diodes(LED), and lithium-ion batteries, they are almost to be found everywhere in our modern-day consumer electronics: TVs, speakers, displays, computers, lighting, and many more. In this information era, it is almost impossible for us to carry out our day-to-day routines without relying on consumer electronics. According to Ambaye(2020), the demand for rare earth materials has increased significantly over the years because of their extensive use[1], with the commonly sourced being praseodymium, cerium, lanthanum, neodymium, samarium, and gadolinium due to their abundance throughout the globe. This also led to an increase in areas around the world being converted to rare earth mining spots. Based on the ethical dilemmas and explanations stated above, the act of sourcing rare earth materials is unanimously viewed by various research as unethical corner cutting and improper disposal of rare earth sourcing all for the sake of meeting demands for a quick profit. The goal here is not to condemn the organizations that sourced rare earth materials, but to suggest alternatives that are somewhat more ethical that what they are currently doing so that they could produce lesser environmental and health impacts without affecting their business.", "max_questions": 10
    #}

    qg = main.QGen()
    output = qg.predict_mcq(payload)
    
    return {"generation": output}


