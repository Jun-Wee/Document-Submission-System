from PyPDF2 import PdfFileReader, PdfFileWriter
from pathlib import Path
import re

# Create pdf file reader object
pdf = PdfFileReader('sample.pdf')

# Extract Text Instructions
# Step 1: Grab Page(s)
page_1_object = pdf.getPage(0)

#Step 2: Extract Text
page_1_text = page_1_object.extractText()

# Merge text from all pages and save as txt file
with Path('sample.txt').open(mode='w') as output_file:
    text = ''
    for page in pdf.pages:
        text += page.extractText()
    output_file.write(text)

# Finding Information
information_pages = []
for page in pdf.pages:
    page_num = page['/StructParents'] # See Page Number
    page_text = page.extractText()

    if 'Information' in page_text: #page_text.find('Information') for index position of Information
        information_pages.append(page_num)

# Create PdfFileReader object
input_pdf = PdfFileReader('sample.pdf')

# Create PdfFileWriter object
pdf_writer = PdfFileWriter()

# Get text from Pages for Information
for page in information_pages:
    page_object = input_pdf.getPage(page)
    pdf_writer.addPage(page_object)

    # Find sample - Sentence and Page Number
pages_sentences = []
for page in pdf.pages:
    page_num = page['/StructParents'] # See Page Number
    page_text = page.extractText()

    if 'Information' in page_text:
        sentence_list = ['Page ' + str(page_num) + ' : ' + sentence.replace('\n', '') for sentence in re.split('\' |\? |\! ', page_text) if 'Information' in sentence][0]
        pages_sentences.append(sentence_list)

text = '\n'.join(pages_sentences)

# Save Page as PDF
with Path('information_pages.pdf').open(mode='wb') as output_file_2:
    pdf_writer.remove_links()
    print(pdf_writer.page_layout)
    pdf_writer.write(output_file_2)

# Save as text file
with Path ('information_sentences_pages.txt').open(mode ='w') as output_file_3:
    output_file_3.write(text)