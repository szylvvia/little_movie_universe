<h1>Little Movie Universe </h1>
<p><i>Internet movie database with social features</i></p>

## About application
<p align="justify">
The developed platform is aimed at users who are connected in films, whether professionally or as a hobby. The online movie database gathers existing film productions, allowing the user to familiarize himself with works he is not familiar with, as well as to systematize his collections. Films can be in collections to watch and favorites. Taking into account the community aspect, a logged-in user will be able to add a film item, but it must be unique within the entire film base. In addition, the user will be able to add a rating and review to each movie item. Due to the visibility of ratings and reviews to everyone, the user will have the opportunity to familiarize himself with the opinions of users, often with different views and tastes, thus broadening his horizons. A ranking of movies will also play a not inconsiderable role, which will be based on user ratings, sorting movies from the highest average rating. The ability to create a unique user account tailored to their preferences will allow everyone to express themselves. The streaming service Spotify and Youtube have been used in the web application under development. The use of such a solution in the application allows users to enjoy movie music and trailers without having to search for it on other platforms.</p>

## Technologies
<ul>
    <li>PHP (Laravel + Eloquent as ORM)</li>
    <li>JavaScript</li>
    <li>MySQL with PhpMyAdmin</li>
    <li>Boostrap 5</li>
    <li>Composer as package manager</li>
    <li>Node.js as runtime environment</li>
    <li>XAMPP</li>
</ul>

## Running the application on the local server
In order to launch the application, there are several steps to follow. Beforehand, it is necessary
PHP interpreter, MySQL or MariaDB database server, the tool
Composer and Node.js. Then, in the project directory, issue a command that
will install all the necessary dependencies for proper operation:
```{}
composer install
```
It may also be necessary to generate a new key for the application using the
command: 
```
php artisan key:generate
```
The next step is to configure the
.env configuration file. It is necessary to adjust the variables responsible for the
connection to the database, the example section responsible for connecting to the database is shown
```{php}
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=imdb
DB_USERNAME=root
DB_PASSWORD=root
```
After adjusting the configuration file, start the database server and create a
database with a name consistent with the one set in the .env file. Since
the created database does not have any tables to create them, you should use the
migration mechanism. In the root directory of the project, issue the command: 
```
php artisan migrate
```
This will create tables in the database, which will conform to the structure of the
used by the applications. It is also worth using the table seeding mechanism to
provide test data. This can be achieved by executing command: 
```
php artisan db:seed
```
After database is properly initialized, it is necessary to start the application by
start the servers: the built-in Laravel server with the command: 
```
php artisan serve
```
Also necessary is Node.js development server which enables compilation of GUI resources
user interface i.e. JS scripts, CSS style sheets. This is necessary from the point of view of
view of using the Bootstrap library. This is done using the command issued from the
root directory of the project: 
```
npm run dev
```
After going through all the described steps, application is available locally in the browser at: 
```
http://127.0.0.1:8000
```
<hr>
<i>The project was developed as part of an engineering thesis on Lublin University of Technology.</i>
