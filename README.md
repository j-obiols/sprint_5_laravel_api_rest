# DICES GAMES API

## Intro

This **REST API** has been designed in the last Sprint from the **Full Stack Developer Course** at **IT Academy** (Barcelona).

It's an **scalable API**, as it could include as many different games as desired. 

In this moment there is only **one game**, called simply 'game'. For the same reason, a player is called simply a 'player' and has the role 'player'.
But if other games were added, every game would have its own name '(this game) game' and the players of this game would be '(this game) players'.

In this first game, the player throws two dices. If the sum of both numbers is 7, he wins. Otherwise, he loses.

## Technologies

Type: REST

Schema: JSON schema

Framework: [Laravel](https://laravel.com/)

Authentication: [Laravel Passport](https://laravel.com/docs/10.x/passport)

Roles & Permissions: [Spatie](https://spatie.be/)

## How it works

There is a preconfigured user with the **'admin' role** assigned. Seeders also provide users, players and games for testing purposes.

New users register themselves with an email, a password, and an optional nickname. If the name field is left empty, they user will be stored 
in Users table as 'Anonymous'.

A registered **USER** will have permission to login and logout, become a PLAYER of different games, see his data as a user, change his name, and get unsubscribed.

When a registered **USER** logs in, he must land in a page with a starting button for every game included in the API.

When he clicks for the first time on a simple **submit button** with the name of a certain game, he gets automatically 
registered as a **PLAYER** of this game, whith his results counters set to 0, and he is assigned with the role '(this game) player'.
Next time he clicks again on this same button, the API will identify him as a player of this game with stored results.
In both cases, this submit action will return the **PLAYER** with his results counters.

#### Once the USER has become a PLAYER, as he's been registered and assigned with '(this game) player' role, he has permission to:

1 - Start playing: he will see the results, these results will be stored, and his counters will be updated. 
(In the existing game: number of games, won Games, and percent of Won Games).

2 - Consult a list of all his rolls and results of each one.

3 - Consult the ranking.

4 - Consult the winner and his results, together with the average percent of wons result.

5 - Consult the loser and his results, together with the average percent of wons result.

A player can not delete any of his rolls, neither the total of them.

#### A User with an **'admin' role** has permission to:

1 - See a list of all users and his data.

2 - See a list of all players and his counters.

3 - Delete the list of games of any player.

3 - Consult the ranking.

4 - Consult the winner and his results, together with the average percent of won games.  

5 - Consult the loser and his results, together with the average percent of won games.

An admin can not edit a user, neither delete him.

#### What happens if two or more players have the same percent of Won Games?

In this case, the API will order them comparing their number of total games. The one with more games will be first. 
In case the number of total games was also identical, the API would decide positions by flipping a virtual coin. 

## Access to the project

Download the repository.

In Visual Studio Code terminal, run:

```composer install```

```cp .env.example .env``` 

Edit .env file, adding a name to Database.

 ```DB_DATABASE = api.dicesgame ```

Create an empty database in localhost with the same name.

```php artisan migrate:fresh --seed``` 

```php artisan serve```

## Testing from Visual Studio Code

In terminal, run:

```php artisan test```

(after testing, and before testing again, sometimes it's necessary to run: ```php artisan cache:clear```)

## Testing from Postman

In terminal Visual Studio Code, run:

```php artisan migrate:fresh --seed```

```php artisan passport:install```

```php artisan serve```
<br/>  

## Routes 

<br/>  

> #### 'id' in route must match with the 'id' of the current authenticated user.
> #### In routes of the type /users/id, it must match his 'id' as a User.  
> #### In routes of the type /players/id, it must match his 'id' as a (this game) Player.
> #### Errors handling is provided.

<br/>

[POST /users/register](#post-usersregister)

[POST /users/login](#post-userslogin)

[POST /users/logout](#post-userslogout)

[GET /users/id](#get-usersid)

[GET /users/id/edit](#get-usersidedit)

[PUT /users/id](#put-usersid)

[DELETE /users/id](#delete-usersid)

[GET /users](#get-users)

[POST /players](#post-players)

[GET /players](#post-players)

[POST /players/id/games](#post-playersidgames)

[GET /players/id/games](#get-playersidgames)

[DELETE /players/id/games](#delete-playersidgames)

[GET /players/ranking](#get-playersranking)

[GET /players/winner](#get-playerswinner)

[GET /players/loser](#get-playersloser)

<br/> 

# POST /users/register 

<br/>

> #### A new user can get registered. 

> #### Authentication is not required.

<br/>

![users_register](https://github.com/j-obiols/sprint_5_laravel_api_rest/assets/127688372/77c738e1-0b0e-492d-b314-6cfe3eece999)

<br/> 

# POST /users/login 

<br/>

> #### A registered user can log in.

> #### Authentication is not required.

> #### A bearer token will be retrieved, and it will be required to access all other API routes acting as this user.

> #### Add 'key' Accept with 'value' application/json to Headers.

<br/>

![users_login](https://github.com/j-obiols/sprint_5_laravel_api_rest/assets/127688372/30f7da3d-6938-4d1f-88bf-2793c76a593d)

<br/> 

# POST /users/logout

<br/>

> #### A registered user can log out.

> #### Authentication is required: bearer token.

> #### Add 'key' Accept with 'value' application/json to Headers.

> #### Add 'key' Submit with null 'value' to Body.

<br/>

![users_logout](https://github.com/j-obiols/sprint_5_laravel_api_rest/assets/127688372/752180aa-8ded-4ffe-84e3-01c06d6e917f)

<br/> 

# GET /users/id

<br/>

> #### A user can see his data as a User: name and email.

> #### Authentication is required: bearer token.

> #### Add 'key' Accept with 'value' application/json to Headers.

<br/>

![users_edit](https://github.com/j-obiols/sprint_5_laravel_api_rest/assets/127688372/ca7d023b-679f-4317-8f16-b030d0150637)

<br/> 

# GET /users/id/edit

<br/>

> #### A user can edit his name.

> #### Authentication is required: bearer token.

> #### Add 'key' Accept with 'value' application/json to Headers.

<br/>

![users_edit](https://github.com/j-obiols/sprint_5_laravel_api_rest/assets/127688372/e71035cc-3613-46a7-b4a7-fdceb0748666)

<br/> 

# PUT /users/id

<br/>

> #### A user can update his name.

> #### Authentication is required: bearer token.

> #### Add 'key' Accept with 'value' application/json to Headers.

<br/>

![users_update](https://github.com/j-obiols/sprint_5_laravel_api_rest/assets/127688372/f3f68e05-45ba-46e7-8eaf-84c000de6443)

<br/> 

# DELETE /users/id

<br/>

> #### A user can unsubscribe.

> #### Authentication is required: bearer token.

> #### Add 'key' Accept with 'value' application/json to Headers.

<br/>

![users_delete](https://github.com/j-obiols/sprint_5_laravel_api_rest/assets/127688372/76c53693-94ce-4050-b0da-26fbc7112205)

<br/> 

# GET /users

<br/> 

> #### A user assigned with role 'admin' can retrieve a users list.

<br/>

![users_index](https://github.com/j-obiols/sprint_5_laravel_api_rest/assets/127688372/e8cbe071-337b-4a72-ab1d-202626649664)

<br/> 

# POST /players

<br/> 

> #### A user can get registered as a (this game) player and get assigned with the role '(this game) player'. 

> #### If he was already registered as a (this game) player) he will be retrieved with updated results counters.

> #### Add 'key' Submit with null 'value' to Body.

> #### Add 'key' Accept with 'value' application/json to Headers.

<br/>

![players_store](https://github.com/j-obiols/sprint_5_laravel_api_rest/assets/127688372/288e817c-e452-4d7c-8bff-3104a695a0ef)

<br/> 

# GET /players

<br/>

> #### A user assigned with role 'Admin' can retrieve a (this game) players list.

<br/>

![players_index](https://github.com/j-obiols/sprint_5_laravel_api_rest/assets/127688372/74756f6a-6829-4adb-b426-74ac4ffba260)

<br/> 

# POST /players/id/games

<br/>

> #### A (this game) player (with role '(this game) player') can make a new roll of the dices (or whatever was the current game, if other games were added), and get the result.

<br/>

![games_store](https://github.com/j-obiols/sprint_5_laravel_api_rest/assets/127688372/2daf446d-c427-4102-9cc0-c15c21ef43b3)

<br/> 

# GET /players/id/games

<br/>

> #### A (this game) player (from creation assigned with role '(this game) player') can get a list of all his games whith his results.

<br/>

![games index](https://github.com/j-obiols/sprint_5_laravel_api_rest/assets/127688372/1fccddfe-08e9-4cb8-8c6c-587acb9334ad)

<br/> 

# DELETE /players/id/games

<br/>

> #### A user assigned with role 'admin' can delete a (this game) player games list.

<br/>

![games delete](https://github.com/j-obiols/sprint_5_laravel_api_rest/assets/127688372/c079002d-cc4f-46a9-9705-203426cc30c0)

<br/> 

# GET /players/ranking

<br/>

> #### A user assigned with role 'admin', or a (this game) player with a (this game) player role, can see the (this game) ranking.

![players_ranking](https://github.com/j-obiols/sprint_5_laravel_api_rest/assets/127688372/6d9d63a1-ecc7-4b0e-b492-41e9f0d28122)

<br/> 

#  GET /players/winner

<br/>

#### A user assigned with role 'admin', or a (this game) player with a (this game) player role, can see the winner, together with the average percent Won.

<br/>

![players_winner](https://github.com/j-obiols/sprint_5_laravel_api_rest/assets/127688372/44b9ff73-ef78-4cb2-9790-e7c59c72eeef)

<br/> 

#  GET /players/loser

<br/>

#### A user assigned with role 'admin', or a (this game) player with a (this game) player role, can see the (this game) loser, together with the average percent Won.

<br/>

![players_loser](https://github.com/j-obiols/sprint_5_laravel_api_rest/assets/127688372/3c9a0f12-9fac-411d-96c4-c7c64e2d006e)



