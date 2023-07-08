# Realtime project With Laravel

### clone the project

```
git clone https://github.com/ahmedisa106/chat.git
```

```
cd chat\
```
### run composer command to install packages

```
composer install
```

### run npm command to install packages

```
npm install
```

### copy .env.example and rename to be .env

```
cp .env.example .env
```

```
php artisan key:generate
```


### configure .env file

```
DB_DATABASE=your_database_name
DB_USERNAME=usernmae
DB_PASSWORD=passwod
```

```
php artisan migrate --seed
```

### Run this  commands with different terminal

```
php artisan serve
nodemon server.js
```
### go to :
```
 /dashboard/login
```
### use email  & password to login

```
email: admin@admin.com
password: 123456
```
