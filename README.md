# challengeBackEnd

## Installation
Please check the official laravel installation guide for server requirements before you start. <a href="https://laravel.com/docs/5.4/installation#installation" target="_blank">Official Documentation</a>

Clone the repository

`git clone git@github.com:fsoaresbraga/challengeBackEnd.git`

Switch to the repo folder

`cd challengeBackEnd`

Install all the dependencies using composer

`composer install`

Copy the example env file and make the required configuration changes in the .env file

`cp .env.example .env`

Generate a new application key

`php artisan key:generate`

Run the database migrations **(Set the database connection in .env before migrating)**

`php artisan migrate`

## Database seeding
#### Populate the database with seed data with relationships which includes users, movements.

Run the database seeder and you're done

`php artisan db:seed`

**Note** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

`php artisan migrate:refresh`

## Testing API

`php artisan serve`
  
  - Register Users
  
  `http://127.0.0.1:8000/api/users`
  
![alt text](http://mejormicroondas.online/images/store-user.jpg)

- List Users

`http://127.0.0.1:8000/api/users`

![alt text](http://mejormicroondas.online/images/list-users.jpg)

- List User

`http://127.0.0.1:8000/api/users/{id}`

![alt text](http://mejormicroondas.online/images/user-list.jpg)

- Remove User

`http://127.0.0.1:8000/api/users/{id}`

![alt text](http://mejormicroondas.online/images/remove-user.jpg)

- Add Movements

`http://127.0.0.1:8000/api/movements`

![alt text](http://mejormicroondas.online/images/add-movements.jpg)

**note*** add body accept

![alt text](http://mejormicroondas.online/images/accept-movements.jpg)

- User Movements

`http://127.0.0.1:8000/api/movements`

![alt text](http://mejormicroondas.online/images/users-movements.jpg)

- Remove Movements

`http://127.0.0.1:8000/api/movements/{idUser}/{idMovement}`

![alt text](http://mejormicroondas.online/images/remove-movements.jpg)


  - Movements Export 

  Last 30 days
  
`http://127.0.0.1:8000/api/movements/user/{userId}/export/?filter=thirty-days`,

 All Movements
 
`http://127.0.0.1:8000/api/movements/user/{userId}/export/?filter=all`

 Month and Year

`http://127.0.0.1:8000/api/movements/user/{userId}/export/?filter=06/20`

- New Balance

`http://127.0.0.1:8000/api/user/balance/{id}`

![alt text](http://mejormicroondas.online/images/new-balance.jpg)

- Balance sum with movements

`http://127.0.0.1:8000/api/user/balanceMovements/{id}`

![alt text](http://mejormicroondas.online/images/balance-movements.jpg)

