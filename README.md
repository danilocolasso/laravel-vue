# A simple application with
<p align="center">
    <a href="https://github.com/laravel/laravel" target="_blank">
        <img height="120" src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400">
    </a>
    <a href="https://github.com/vuejs/vue" target="_blank">
        <img height="100" src="https://vuejs.org/images/logo.png" alt="Vue logo">
    </a>
</p>


## Before install
- Make sure you have installed Docker Desktop. If you don't, follow the <a href="https://www.docker.com/get-started" target="_blank">Get Started with Docker</a>.
- NPM is required too (I'll include it in the containers in the furure... Or not).

## Installation guide

### Clone the project
    $ git clone https://github.com/danilocolasso/laravel-vue.git myproject
    
    $ cd myproject
If you have MFA enabled, you'll need to clone with SSH.
    
### Up the containers
    $ docker-compose up -d
The `-d` is optional. Just to detach the Docker from your terminal tab and run in background.
    
### Install Composer dependencies
    $ docker run --rm -v $(pwd):/app composer install
You don't need to have Composer installed.
    
### Create an env file
    $ cp .env.example .env
Change the database user, password and name if you want.
    
### Generate Laravel session key (optional)
    $ docker-compose exec app php artisan key:generate
Just to protect your users data. Not essential, right? :p 
    
### Cache your config (optional)
    $ docker-compose exec app php artisan config:cache
It will improve a lot the performance.
    
### Migrate database
    $ docker-compose exec app php artisan migrate --seed
Your database and schema will be created and populated with some demo data automatically.


### Install Node Packages
    $ npm install
    
And to compile your assets:

    $ npm run dev 
    
### Defaut credentials

>**user:** admin@test.com
>
>**password:** password

## To do
- Use [Vuex](https://vuex.vuejs.org/ "I really hope that Vue will be totally independent in the future. Like React did with Redux.") to manager states.
- Work with translations
- Improve code quality
    - Separate tables and forms into components
    - Several other code improvements
    - I really don't know if I like Bootstrap...
