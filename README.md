# Project 5 Open Classrooms Application Developer - PHP/Symfony

## Required tools and versions

This project assumes that you are using laragon.
I used PHP 7.4.30, because it is the version I use in a company setting.

## Installation

Clone the files on your computer in your www laragon folder.
Use the composer install command to add the dependencies to the project.
Create an .env file in the root folder of your project.
Edit the SECRET line with the value of your choice.
use the sql file to create your database placeholder
go to src/lib/database and change the user and password to your liking, the default are root and root

## Start the application

In your browser, go to the following address once laragon is launched. <http://localhost/p5myblog/src/index.php>

## Granting Administrator privileges

Although a user is done through the website interface, however if you want to grant the user admin privileges,
it must be done in the user table in the database. This is done for security purposes.
To grant a user admin priveleges, set the roles value to <'ROLE_ADMIN','ROLE_USER'>

## libraries

jquery
tinymce
