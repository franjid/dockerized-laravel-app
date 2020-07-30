# Dockerized Laravel App

This in an example of a basic Larael project running in a dockerized environment with PHP, Nginx and Mysql.

1) Copy `.env.example` to `.env`
2) Copy `code/api/.env.example` to `code/api/.env`
3) Run:
    ```
    docker-compose up
    ```
4) Run:
    ```
    docker-compose exec php php artisan migrate
    ```

Now you can access the API endpoints:
* [http://localhost/api/users](http://localhost/api/users)
* [http://localhost/api/users/1](http://localhost/api/users/1)
* [http://localhost/api/users/1/posts](http://localhost/api/users/1/posts)
* [http://localhost/api/posts/1/comments](http://localhost/api/posts/1/comments)

You can [read more about the Laravel App](code/api/README.md).
