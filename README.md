Question-Paper-Generator
========================

**Anna University Examination Question Paper Generator**

This is a PHP Web application which facilitates generation of question papers as per Anna University Examination format.
It can be used by lecturers for preparing question papers for class tests, Unit Tests, Model Exams, final exams, etc. 

Features :
----------

- New users can signup and create an account. While creating account, the user needs to enter details such as college name 
and address which will appear in the header of the user's question papers.
- Existing users can login and create a new question paper. The user will be prompted to enter the name of examination,
subject code and name, semester, department, total marks and date. These details will be used while generating the question
paper.
- The examination format of Anna University contains two sections - PartA (2 marks questions) & PartB (16 marks questions).
- The users can enter new questions or select from older questions. The user's previous question papers are stored in the
backend. So for example, if a user has created a question paper for Unit Test - I for subject code CS1063 previously. And,
at the end of semester, he is creating a new question paper for Model Exam for the same subject, then the older questions 
will appear as autocomplete options in the input boxes. Also, the user may be teaching the same subjects every year, so in 
that case, he can view the past years questions and modify them as necessary.
- In Part-B section, the user has two options - he can enter a single 16 marks questions. Or in some cases, there might be
a need to enter two 8 marks questions. There is a feature in the app to add the subdivisions if necessary.
- Once the user has entered all the questions, the question paper will be generated. The user can download the question 
paper in Word (.doc) format or PDF format as required. Downloading the question paper in Word formart will enable the users
to make any minor changes like adding the college's logo image, watermark, etc.

Features that can be added in future :
--------------------------------------

- A feature for viewing the user's history of question papers - this will help the user to view all previously created
question papers for a subject. Currently, lecturers have paper-written question papers or soft-copy of question papers
stored in various pendrives, hard disks, etc. This app will serve as a single point for storage of all question papers
which the users can refer anytime they need.
- A feature for generating question banks for subject - Currently, we have Question Bank books for students which acts as
a reference for previous years questions. This feature would help to retrieve all the questions from all previous question
papers for each subject and generate a question bank. Lecturers can distribute this to students for reference.
