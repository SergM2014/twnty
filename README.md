This application is based upon Laravel Sail Package

steps how to install:

1) git clone https://github.com/SergM2014/twnty.git
2) cd twnty
3) ./vendor/bin/sail up -d
4) ./vendor/bin/sail shell
5) composer install
6) php artisan migrate --seed
_________________________________________
to check if the application is successfully installed visit http://localhost

___________________________________________
tested by postman!!!!

and for further usage postman is needed

 There are 2 restful Apis - users and tasks

examples:

____________________________________________
Users API

get localhost/api/users 

get localhost/api/users/1

post localhost/api/users/1

data to be inserted--> { "name": "newName", "email": "new@example.com", "password": "password", "role": "user" }

put localhost/api/users/1

data for update--> { "name": "upName", "email": "up@example.com", "password": "upPassword", "role": "admin" }


delete localhost/api/users/1

user can have roles - user, moderator, admin
________________________________________________________________
Tasks API

get localhost/api/tasks

get localhost/api/tasks/1


post localhost/api/tasks

{"title": "newTitle", "description": "newDescription", "status": "new", "executor": 1 }

put localhost/api/tasks/1

{"title": "upTitle", "description": "upDescription", "status": "processing", "executor": 2 }

delete localhost/api/tasks/1


task can have status - new, processing, checking, completed

as executor should be put only an integer, it means id of user
____________________________________________________________________
If we delete user, connected to him tasks will be also removed!!!
____________________________________________________________________
____________________________________________________________________

Searching the results by filtering with status and executor

get localhost/api/search

--> output all possible tasks with related users



get localhost/api/search?status=new&executor=Doctor

--> outputs the tasks with status - new and name of the 
executer is written like Doctor.

Any presence/absence or order/variations of filters in query string is possible.
