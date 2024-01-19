<p align="center">
    <h1 align="center">BMS - Book Management System</h1>
    <br>
</p>

Written in Yii 2 

This application is responsible for managing books, where users can register, login and request CRUD actions.

First Access
------------
Assuming you've already cloned this repository:

1º) Open your SGBD and create a database called '`yii2basic`' which is the default settings of the `config/db.php` file.

2º) Open terminal and run the command `php yii migrate/fresh` to create all tables and fake data.

3º) On the terminal start the yii serve by running `php yii serve`, add a port if necessary, in this case `php yii serve -p 8888`.

4º) After the migrations ran succefully, you're ready to log in, the `admin admin` user was created and also 9 other users were randomly stored as well, all of them with a password = `123` since it's stored in hash, you just need to check their usarnames in the table to be able to log in with their accounts.

5º) After logged in you're ready to make your first CRUD requests. Enjoyt it.


Main Rules
------------
~~~
1) Guest users have access only to login and signup pages.
2) Auth users have access to books with all CRUD actions allowed and also API access.
3) Auth users can't have access to login and signup pages while they are authenticated. In order to do so they must logout first.
~~~

Dependencies and Configuration
------------

### Via Composer

Faker to provide fake data for the migrations.<BR>
Httpclient for requests when consuming the API.

~~~
composer require --dev yiisoft/yii2-faker
composer require yiisoft/yii2-httpclient
~~~

### Manually

I worked with the default database config in `config/db.php`

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```


Enabled prettyurl in `config/web.php`
~~~
'urlManager' => [
	'enablePrettyUrl' => true,
	'showScriptName' => false,
	'rules' => [
	],
],
~~~

Technical Descriptions
------------

### Controllers/

`IndexController` responsible for handling inital requests and user session.
```
behaviors() -> Control access to the methods below.
actionIndex() -> Displays the login form on the index page.
actionAttempt() -> Attempts to log in the user based on the provided credentials.
actionLogin() -> Displays the login form.
actionLogout() -> Logs the user out and redirects to the home page.
actionSingup() -> Displays the signup form.
actionRegister() -> Registers a new user.
```

`BookController` responsible for handling CRUD requests.
```
behaviors() -> Control access to the methods below.
actionIndex() -> Displays a list of all books.
actionCreate() -> Displays a form to create a book.
actionStore() -> Save the new book on database.
actionEdit() -> Displays the book editing form.
actionUpdate() -> Handles the book update process.
actionDestroy() -> Responsible for the book deletion process.
```

`ApiController` responsible for Api requests.
```
behaviors() -> Control access to the methods below.
actionIndex() -> Displays information about the weather in São Paulo.
```

### Models/
```
Author -> Model class for table author.
Book -> Model class for table author.
Bookform -> Model class for handling the creation of a book.
BookSeach -> Model class for handling any field search of the list.
LoginForm -> Model class for handling the login.
User -> Model class for table user.
```
### Views/
```
layouts/main -> Default view that handes all pages's structures 

index/error -> View to display errors.
index/login -> View displaying the login form.
index/signup -> View displaying the sign up form.

book/index -> View displaying all books in a table.
book/edit -> View displaying the edit book form.
book/create -> View displaying the create book form.

api/_weather_details -> Model class for table author.
api/index -> View displaying weather info in São Paulo.

```
### Helpers/
```
WeatherHelper.php -> A view component that translates data and returns to the _weather_details.php
```
### Migrations/
```
m240116_161651_create_table_users -> create user table
m240116_171854_create_faker_users -> add fake data to users
m240117_181158_create_table_author -> create table author and add fake data
m240117_181212_create_table_book -> create table books and add fake data
```

