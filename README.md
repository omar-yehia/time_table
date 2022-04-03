# time_table
installation steps:

1) create a database with the name "time_table_system" with collation utf8_general_ci

2) run command:
	> composer install

3) then copy the .env.example file to a new file .env:
	> cp .env.example .env 
4) then generate the app key by this command:
	> php artisan key:generate

5) then, in the .env file fill in the DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD
    DB_DATABASE=time_table_system
    DB_USERNAME={your db username here}
    DB_PASSWORD={your db password here}

6) then run commands:
    > php artisan migrate

    > php artisan db:seed
    
    > php artisan serv

then go to localhost::8000

you will be redirected to the /login page
login as admin with these credintials

email: admin@gmail.com
password: 123456

then start adding and editing users and pharmacies and their time tables 
also admins and roles
