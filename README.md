# Laravel & GraphQL

Esta es una estructura base para una aplicación de Laravel con soporte para
autenticación y registro de usuarios usando GraphQL mediante el paquete
Lighthouse e impulsado por Airlock para verificación de sesiones.

## Empezando

- Clone este repositorio e instale las dependencias del proyecto.

``` bash
$ git clone https://gitlab.com/gregorip02/laravel-graphql.git
$ cd laravel-graphql
$ composer install
```

- Defina sus variables de entorno en el fichero `.env` y genere su llave de aplicación.

``` bash
$ cp .env.example .env
$ php artisan key:generate
```

- Para este ejemplo, levante los servicios definidos en el fichero `docker-compose.yml`.
Luego, ejecute las migraciones de Laravel.

> **Atento:** la primera vez que levanta el servicio de `mysql` puede tardar al menos
un minuto en estar listo para aceptar conexiones.

``` bash
$ docker-compose up -d
# Ejecute este comando cuando este seguro que el servicio
# mysql esta listo para aceptar conexiones.
$ docker exec -it graphql php artisan migrate --seed
```

## Probando

Ahora debería ser capaz de tener un servicio listo para probar graphql con Laravel.
Abra su cliente de GraphQL preferido y asigne la dirección del esquema a
`http://localhost:8080/graphql`.

Los siguientes, son algunos ejemplos de lo que podría hacer inicialmente.

``` graphql
# Login with email and password credentials
query {
  login(input: {
    email: "me@gregori.com"
    password: "secret"
  }) {
    id
    name
  }
}

# Get an protected query passing the airlock guard.
query {
  protected
}
```
