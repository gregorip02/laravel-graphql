# Laravel and GrpahQL

An simple app that allow you register, authenticate and create to-dos
using graphql.

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
