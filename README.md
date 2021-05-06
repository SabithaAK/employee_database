# employee_database

Using CSV file store all the data and import the CSV file data to database using Codeignite framework(PHP).
Steps
********************************
->create a database employee_details, and import tables.
-> Connect database from application/config/database.php
->change base_url from application/vonfig/config.php

Import CSV Data to Database
***************************

The following works are processed in this file.

Validates the uploaded file whether it is a valid .csv file.
The is_uploaded_file() function is checks whether the CSV file is uploaded via HTTP POST.
The fopen() function opens the CSV file in read-only mode.
The fgetcsv() function is used to parse the member’s data from the open CSV file. This function is called in the while loop to parse data from CSV file.
Change date format.
Members data are inserted into the database using PHP and MySQL.
At last, the user is redirected to the main page with importing status message.
