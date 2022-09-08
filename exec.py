
# !C:\Users\Yovinma Konara\AppData\Local\Programs\Python\Python37\python.exe
print("Content-Type: text/html\n\n")

print("testing")

import sys
#sys.path.append("C:\\xampp\\htdocs\\Yovinma\\softwareproj\\venv\\Lib\\site-packages")
sys.path.append("C:\\Users\\Yovinma Konara\\AppData\\Local\\Programs\\Python\\Python37\\Lib\\site-packages")


import nbformat
from nbconvert.preprocessors import ExecutePreprocessor
import json

filename = 'questiongen.ipynb'
with open(filename,encoding="utf8") as ff:
    nb_in = nbformat.read(ff, nbformat.NO_CONVERT)
    
ep = ExecutePreprocessor(timeout=600, kernel_name='python3')

nb_out = ep.preprocess(nb_in)
print(json.dumps(nb_out))