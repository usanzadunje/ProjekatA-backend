# Backend application of ProjekatA

### Start application using [Docker](https://docs.docker.com/get-docker/)

1. Position yourself inside root folder of this application inside terminal.
2. Run ```docker-compose up -d``` to run it in development mode with livereload while changing local files (all files in
   docker container are synced to your local ones be careful to install all dependencies locally).
3. Or you can run ```docker-compose -f docker-compose.prod.yml up -d``` to run production version which will copy files
   and bundle application up and run it despite you running npm install and composer install locally.
4. Since this is API only you will need to use API Client such as Postman(described bellow)
5. Address on which application is hosted is: http://localhost/

### Start application without [Docker](https://docs.docker.com/get-docker/)

#### Prerequisites

- PHP
- Web server (Apache/Nginx)
- MySQL
- You could be using:  [laragon](https://laragon.org/) (Windows only), [WAMP](https://www.wampserver.com/en/)
  , [XAMPP](https://www.apachefriends.org/index.html), [LAMP](https://bitnami.com/stack/lamp/installer)
- [Composer](https://getcomposer.org/download/)

#### Installing application

1. Clone repo ```git clone https://github.com/usanzadunje/ProjekatA-backend.git```
2. Run ```composer install```
3. Copy .env.example into .env ```cp .env.example .env``` and populate values (if you are running application using
   Docker you should set ```DB_HOST=db``` so container works as expected)
4. Generate encryption key ```php artisan key:generate```
5. Create a database called  ```projekata```
6. Run migrations and seed database by running ```php artisan migrate --seed```
7. Run ```php artisan optimize```

### Testing application using API Client | [Postman](https://www.postman.com/downloads/)

1. Download Postman collection [here](https://www.mediafire.com/file/gjn5soweuj9nqtt/ProjectA.postman_collection.json/file).
2. Clink on collection options (three dots) and choose Edit.
3. Go to Variables section and set local_api_path to application URL which should be http://localhost/api
4. For some routes you will need to be logged in. Inside Auth folder you will find Login/Register routes, use them and
   copy token you get in return. This token should be value of local_token variable.

### Testing application without installation

*You can use remote section of this collection which has same routes but against already hosted and runnign application,
this way you do not need to install application at all. Process is the same as in this 4 steps to get your Postman
client to work.*

# Contact

- E-mail: [dusan.djordjevic.biz@gmail.com](mailto:dusan.djordjevic.biz@gmail.com)
  | [dussann1997@live.com](mailto:dussann1997@live.comm)

<br>
