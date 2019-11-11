# larareact

### [Mohammed Jabir -> <med.jabir@gmail.com>]

Laravel and reactjs love affair 

1 - Laravel on the backend (providing API endpoints)<br />
2 - Reactjs on the frontend (using Axios to send requests to API endpoints)<br />
3 - Login and registration system<br />
4 - Email verification<br />
5 - Password reset<br />

***P.S: I used localStorage to save the user's authentication token, it isn't the best secure way but each one of us has his own approach as to how to handle this token, so I'll leave you the choice...***

### Installation

Setup your .env file ( Database credentials and smtp details (mail) )
```
cp .env.example .env
```
```
composer install
```
```
php artisan key:generate
```
```
php artisan migrate
```
```
php artisan passport:install
```
```
npm install
```
```
npm run dev
```
### Launch Development server
```
php artisan serve
```
