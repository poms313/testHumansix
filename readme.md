# Technical Requirements

Technical Requirements o for computer for run the project:

Composer:
https://getcomposer.org/download/

Symfony:
https://symfony.com/doc/current/setup.html

GitHub:
https://docs.github.com/en/repositories/creating-and-managing-repositories/cloning-a-repository


## Step 1 - Install the project

in command prompt:
git clone https://github.com/poms313/testHumansix


then:
composer install 

 fichier .env du projet, et modifier la variable d'environnement selon vos paramètres :
        

### Step 2 - Create database

change the database url in .env with your parameters:
DATABASE_URL=mysql://User:Password@127.0.0.1:3306/nameDatabasse?serverVersion=5.7

then:
symfony console doctrine:database:create

add entity to the database:
php bin/console make:migration
php bin/console doctrine:migrations:migrate


###### Step 3 - start

For startoing the project, write:
symfony server:start

It run on: http://127.0.0.1:8000/

For security reasons, you must create a new user before accessing the administration area
The link is in the home page
