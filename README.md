# Laravel and GrpahQL

An simple app that allow you register, authenticate and create to-dos
using graphql.

## Get started

Clone this repo and install dependecies. Then, create your `.env` file.

``` bash
$ git clone https://gitlab.com/gregorip02/laravel-graphql.git
$ cd laravel-graphql
$ composer install
$ cp .env.example .env
```

For this example, up the services defined in the `docker-compose.yml` file. then,
run the laravel migrations using this.

``` bash
$ docker-compose up -d
$ docker exec -it graphql php artisan migrate
```

Now the laravel app is listening in `http://localhost:8080`. Great, 
in your graphql client run this for test.

``` graphql
# Register a new user
mutation {
  register(input: {
    name: "Gregori"
    email: "me@example.com"
    password: "secret"
  }) {
    id
  }
}

# Login with email and password credentials
mutation {
  login(input: {
    email: "me@example.com"
    password: "secret"
  }) {
    id
    email
  }
}
```
