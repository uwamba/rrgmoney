<h1 style="text-align:center">Docker Environment for Laravel</h1>
<br>

This Laravel Package helps get you up and running with a docker development environment in no time.
No need to bog your host computer down with installing a LAMP stack directly.

## Creating a new Laravel Project:

Installing Laravel required PHP and Composer installed. If you're following
Docker best practices, then you'll want to do the following instead of running
https://laravel.com/docs/installation directly on your host machine (because
you may not have PHP installed on your host computer).

NOTES: 
*The following commands assume you already have docker CE installed 
https://docs.docker.com/engine/installation
and that your host computer is running Linux or macOS. If you're running Windows, 
you will need to modify the following commands or be using Microsoft's 
Bash on Windows 
https://msdn.microsoft.com/en-us/commandline/wsl/install_guide .*

1. Navigate to where you want to install your new Laravel Project
2. You need PHP and Composer to install Laravel, so spin up the official Composer docker
   machine to get access to a bash prompt that has PHP and composer. 
   *(Unless otherwise indicated, all commands step #3 through step #8 should be ran from within 
     the docker container's terminal that we get as a result of this command here in step #2)*
    ```bash
    # Run from host machine to access a php terminal
    docker run -ti --rm -u $(id -u):$(id -g) -v $PWD:/var/www/html hackley2/php-apache bash
    ``` 
3. Install Laravel into a new folder called "blog"
    ```bash
    composer create-project --prefer-dist laravel/laravel blog
    ```
4. Change directory into the new blog folder 
    ```bash
    cd blog
    ```

## Set up Docker with an existing Laravel Project:

Now that you have your Laravel Project set up, and your terminal is still running
the composer bash prompt we opened up in step 2 we can set up the Docker files
required for our development environment

5. Install this repo as a composer package
    ```bash
    composer require hackley2/laravel-docker-package
    ```
6. Register the DockerServiceProvider with Laravel by adding the following line to
   the 'providers' array in your config/app.php file 
    ```php
    // PHP code to enter in config/app.php
    Hackley2\LaravelDockerPackage\DockerServiceProvider::class,
    ```
7. Publish the docker folder and docker-compose.yml file to your project
    ```bash
    php artisan vendor:publish --tag=docker
    ```
8. Exit the composer container that we've been performing commands in that we started in step #2
    ```bash
    exit
    ```

## Use Docker

Now that the docker files are all in place, follow these steps to spin up and manage your Docker LAMP stack:

1. Setup your database settings in your .env file
2. Set the DB_HOST in your .env file to "mysql"
3. Spin up your Docker LAMP stack:
    ```bash
    # Start your docker server containers
    docker-compose up -d
    ```
    ```bash
    # Stop your docker server containers
    docker-compose stop
    ```
4. Peruse the Notes:
    * *All below commands should be ran from the root folder of your Laravel project*
    * *The DB settings you put in your .env file before you build your docker-compose environment
       for the first time will cause the MySQL DB's name, user, and password to be set to what your .env
       file indicates.*
    * *If you delete the MySQL container, your DB's data will be lost. There are plenty of ways around
       this. See https://hub.docker.com/_/mariadb/ for more details.*
    * *If you need to connect to your local development server's terminal for something like db migrations, then
       get the list of the running docker containers by running `docker ps` to determine the name of your "phpserver"
       container and then use the `./docker-exec.sh` script file (see below for more details).*
    * *Once the docker server containers have been started, you can access your Laravel 
       app by pointing your browser to 127.0.0.1*

# Running a command on one of your docker containers

If you need to run a command in one of your docker containers (such as
getting access to your docker container's terminal) use the following command:


```bash
# Run command on one docker container (from MacOS host machine)
docker exec -ti <docker-container-name> <command>
```

```bash
# Run command on one docker container (from Linux host machine)
docker exec -ti -u $(id -u):$(id -g) <docker-container-name> <command>
```

If you find that command to be too cumbersome, you can instead use the `docker-exec.sh`
script as follows:

```bash
./docker-exec.sh <container-name> <command>
```

# Connect to MySQL

To connect to your mysql server, use this command in your terminal, or enter this commands credentials into your favorite
database management program. Use the database password set in your .env file.

```bash
# Replace <DB_USERNAME> with the value defined in your .env file
# Use the password defined in your .env file
mysql -u <DB_USERNAME> -p -h 127.0.0.1 -P 33061
```


# Customize your Docker server environment 

If you need to run redis, memcached, node.js, or some other server environment, add a new service to the docker-compose.yml
file in your project's root. If you don't know enough about Docker to do this, then I'd highly recommend the 
_Docker For Developers_ book by Chris Tankersley. It's not expensive and provides a great introduction to Docker. 
It's available via eBook and soft cover at https://www.phparch.com/books/docker-for-developers/ .

If you need PHP extensions that aren't available in hackely2/php-apache, create your own docker file that has the extensions
you need. You can even build upon hackley2/php-apache and extend it instead of starting from scratch.

