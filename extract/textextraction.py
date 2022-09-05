from PyPDF2 import PdfFileReader, PdfFileWriter
from pathlib import Path
import re



with open('sample.pdf', 'rb') as pdf_obj:
    pdf = PdfFileReader(pdf_obj)
    out = PdfFileWriter()
    for page in pdf.pages:
        page.scale(2, 2)
        out.addPage(page)
        out.remove_images()

    with open('sample_output.pdf', 'wb') as f: 
        out.write(f)
        