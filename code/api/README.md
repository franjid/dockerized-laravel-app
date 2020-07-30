# Laravel API App

This is a basic Laravel app showing how to work with REST API's. Exposing our own API and also consuming an external one ([JSONPlaceholder](http://jsonplaceholder.typicode.com/) in this case).

In every endpoint, we first look if we have any data in the database. If we don't, then we call the external API, fetch the data and store it in the database.

## API endpoints

* `/api/users`
* `/api/users/{id}`
* `/api/users/{id}/posts`
* `/api/posts/{id}/comments`

## Architecture

The project has a DDD approach architecture. That way the code is as agnostic as possible to the framework, it's more reusable and we could switch frameworks easily.

There is a `src` folder where all the code lies, decoupled from the framework.

* Application: here we would have anything we wanted to connect with the framework (in this project we don't have anything)
* Domain: folder where we store all our domain entities, logic (in the form of services), etc.
* Infrastructure: this is the place to store all the code that will interact to external resources (a database, API's, queue system, etc)

## Database design

This project database schema is really simple. We just added some indexes here and there for future features.

### Tables

#### `users`
    * Added a unique index to the email so we could quickly search a user by it

#### `posts`
    * Added a fulltext index to the title as we could have an option to search posts if a title contains a specific string (this is fine in a first iteration, but should be improved later. More on [Things that could be improved](Things that could be improved))

#### `comments`

## Things that could be improved

* Cache in Redis. Even if in the current state we store data in the database, saving it in Redis (or any similar cache system) would be faster
* Add pagination to the API
* Use Elasticsearch, Algolia or similar for searching posts by title instead of using the database
* I didn't add any tests as the project in its actual state has almost no logic, but in a real worl project we should add tests

