# Laravel & GraphQL

Esta es una estructura base para una aplicación de Laravel con soporte para
autenticación y registro de usuarios usando GraphQL mediante el paquete
Lighthouse e impulsado por Airlock realizar tareas de verificación de sesiones.

> Considere este repositorio como una base para empezar un proyecto con estas tecnologías.

## Empezando

- Clone el repositorio e instale las dependencias.

``` bash
$ git clone https://gitlab.com/gregorip02/laravel-graphql.git my-app
$ cd my-app
$ composer install --ignore-platform-reqs
```

- Configure su archivo de configuración de entorno `.env` y luego genere su llave de aplicación.

``` bash
$ cp .env.example .env
$ php artisan key:generate
```

- Para este ejemplo, levante los servicios definidos en el fichero `docker-compose.yml`.
Luego, cuando este listo, ejecute las migraciones de Laravel.

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
# Registra un usuario y automáticamente ejecuta el login.
mutation {
  createUser(input: {
    name: "Gregori"
    email: "me@gregori.com.ve"
    password: "secret"
  }) {
    id
    name
    email
  }
}

# Luego, puedes probar que el usuario que acabas de registrar
# esta realmente autenticado. Esta es una Query que lo comprueba.
query {
  protected,
  me {
    id
    name
    email
  }
}

# Intenta eliminar la Cookie de sesión que Laravel creó y luego intenta
# autenticarte con las credenciales que has establecido.
query {
    loginUser(input: {
        email: "me@gregori.com.ve"
        password: "secret"
    }) {
        id
        name
        email
    }
}
```

> **Nota:** Recuerda que el paquete Airlock esta diseñado para implementar 
`Autenticación Stateful`, quiere decir que si estas usando una aplicación cliente propia 
no necesitas un token como un Json web token para validar tus credenciales, en vez de ello
Airlock lo hace de manera automática usando Cookies e Identificadores de sesiones al
igual que el guard `web`.
