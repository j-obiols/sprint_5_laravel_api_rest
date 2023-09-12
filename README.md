# DICES GAME/S API

## Intro

This **REST API** has been designed in the last Sprint from the **Full Stack Developer Course** at **IT Academy** (Barcelona).

It's an **scalable API**, as it could include as many different games as desired, although in this moment there is only **one game**.
In this first game, the player throws two dices. If the sum of both numbers is 7, he wins. Otherwise, he loses.

## Stack

Framework: [Laravel](https://laravel.com/)

Authentication: [Passport](https://laravel.com/docs/10.x/passport)

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

**Once the USER has become a PLAYER, as he's been assigned with '(this game) player' role, he has permission to:**

1 - Start playing: he will see the results, these results will be stored, and his counters will be updated. 
(In the existing game: number of games, won Games, and percent of Won Games).

2 - Consult a list of all his rolls and results of each one.

3 - Consult the ranking.

4 - Consult the winner and his results, together with the average percent of wons result.

5 - Consult the loser and his results, together with the average percent of wons result.

A player can not delete any of his rolls, neither the total of them.

**A User with an **'admin' role** has permission to:**

1 - See a list of all users and his data.

2 - See a list of all players and his counters.

3 - Delete the list of games of any player.

3 - Consult the ranking.

4 - Consult the winner and his results, together with the average percent of won games.  

5 - Consult the loser and his results, together with the average percent of won games.

An admin can not edit a user, neither delete him.

**What happens if two or more players have the same percent of Won Games?**

In this case, the API will order them comparing their number of total games. The one with more games will be first. 
In case the number of total games was also identical, the API would decide positions by flipping a virtual coin. 

## Testing from Visual Studio Code
(...)
php artisan test
(sometimes it's necessary to run also:
php artisan cache:clear)

## Testing from Postman
(...)
php artisan migrate:fresh --seed
php artisan passport:install
php artisan serve

## Routes included

(...)
