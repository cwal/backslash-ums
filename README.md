Backslash UMS
=
Backslash UMS is a User Management System built with the G\ micro-framework and Twitter Bootstrap. This User Management System has all the features necessary to quickly deploy web applications where users need to be able to login, register and manage their account.

##Installation
Upload the necessary files to your server. Create a database and import users.sql from the "schema" folder. Open settings.php from the "app" folder and specify the necessary settings. Customize to your needs!

##Creating Admin User
To create the admin user please register as a user would (with a valid email address), confirm and log in to your account. The modify the "is_admin" value from 0 to 1 in the "users" table of your database. Once this is done the first time you can manage all users from the "account" page when logged in as admin.

=

G\ Library
=

G\ (spelled G Backslash) is an elegant micro-framework that helps you to quickly build PHP web applications like never before. It applies a very sleek, intuitive and extensible MVC structure for your PHP apps. It does routing, themes, database handling (PDO) and route hooking.

G\ is all about making common core task of any modern PHP application a no brainer and give you all the tools to help you in this. G\ is not about making the actual coding job for you so if you want a framework that creates the database tables for you, handle login, sign-ups, validate forms, etc. G\ is not for you, **G\ is for developers who enjoy to code** and those developers doesn’t need that intrusive help.

##Documentation

Documentation can be found at [G\ documentation](http://gbackslash.com/docs "G\ website documentation") and is a work in progress so don't hesitate to ask if you don't understand something.
