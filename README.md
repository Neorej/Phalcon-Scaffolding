# Phalcon project scaffolding (pre-alpha)

Basic scaffolding for new Phalcon projects

#### Requirements

* PHP >= 7.1.x
* Phalcon >= 3.1.2
* Phalcon Devtools >= 3.1.2
* MySQL >= 5.7
* [Nginx][1] or [Apache][2] with mod_rewrite enabled
* [Composer][3]


#### Installation

First clone the repository:
```
$ git clone https://github.com/Neorej/Phalcon-Scaffolding.git new-project
```
Move into the project directory
```cd new-project```

Install dependencies with Composer:
```
$ composer install
```

Include the basic configuration file:
```
$  mv app/config/config.env.example.php app/config/config.env.php
```
Add your database credentials and save the file

Let the Phalcon Devtools know this is a Phalcon project:
```
$  mkdir .phalcon/
```

Create the database with Phalcon migrations:
```
$  phalcon migration run
```

## License

This project is licensed under the [MIT License][4].



[1]: https://nginx.org/
[2]: https://httpd.apache.org/
[3]: https://getcomposer.org/
[4]: https://github.com/Neorej/Phalcon-Scaffolding/blob/master/LICENSE.md