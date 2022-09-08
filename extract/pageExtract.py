from PyPDF2 import PdfFileReader, PdfFileWriter
from pathlib import Path
import re

pdf_file_path = 'Software Design and Research Report.pdf'
file_base_name = pdf_file_path.replace('.pdf', '')

pdf= PdfFileReader(pdf_file_path)

pages = [5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60] #Pages 
pdfWriter = PdfFileWriter()

for page_num in pages:
    pdfWriter.addPage(pdf.getPage(page_num))

with open('{0}_subset.pdf'.format(file_base_name), 'wb') as f:
    pdfWriter.write(f)
    f.close()
