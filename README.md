# McqsApp-laravel10
McqsApp-laravel10

APP DESCRIPTION

I have added my custom AuthController for authentication.
I added an Admin user by default via Seeder and set it as an admin.
Then, I created two middleware, one is for Admin and another is for Student.
So, admin can have its own Route group and Students has own.
There are now two areas, I mean two dashboard, after login,

Admin:
An Admin has access to create Questions, add Multiple answers to the question and choose
one of it is correct.
Admin also, can add Marks to every question he add.
The multiple answers can be added Dynamically, and also can be removed as well.
There is option for Admin to Edit & Delete Question with Answers.
Admin can see the Exam Results submited from the Students side.

Student:
A student after login, can go to Exam section.
If he agree for exam, he can start exam.
A list of Questions with multiple choises (answers) shows in front of him one by one.
One by One mean, that, a single question will appear to Submit and go to the Next question.
After finishing the Questionaire, he can see has result.

A file SQL has also been uploaded. you can find inside the project.

End..
