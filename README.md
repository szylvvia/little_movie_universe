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

## Views of application
![m1](https://github.com/szylvvia/little_movie_universe/assets/84547266/5e3fa1b9-18aa-498b-8637-808035c41c16)
<p align='center'><i>Home page with quiz</i></p>

![m2](https://github.com/szylvvia/little_movie_universe/assets/84547266/590488c2-e662-4c29-b6ca-b585cede6458)
<p align='center'><i>The best movies rank</i></p>

![m5](https://github.com/szylvvia/little_movie_universe/assets/84547266/3d474333-39b1-4446-b8ba-5a4d49c6b446)
<p align='center'><i>Page with details of choosen movie</i></p>

![m6](https://github.com/szylvvia/little_movie_universe/assets/84547266/3b16ae4a-de2f-4237-9402-dcadfdd9a06f)
<p align='center'><i>Rate and review section of choosen movie</i></p>

![m3](https://github.com/szylvvia/little_movie_universe/assets/84547266/105005ab-8d13-40bc-9a85-a8a2ec953c64)
<p align='center'><i>Page with all artists verified in database</i></p>

![m4](https://github.com/szylvvia/little_movie_universe/assets/84547266/cc37e3e3-cb26-48f2-b7ab-b2df268a1a63)
<p align='center'><i>Details of choosen artist</i></p>

![m7](https://github.com/szylvvia/little_movie_universe/assets/84547266/4866754d-319e-47a1-bca1-e2592b762294)
<p align='center'><i>Admin panel with pending items sections</i></p>

![m8](https://github.com/szylvvia/little_movie_universe/assets/84547266/a0fd5510-27d6-4d58-b157-901fb3bac933)
<p align='center'><i>User home page</i></p>

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
