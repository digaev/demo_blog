Demo Blog
=========

A simple demo blog based on CodeIgniter 3 PHP framework.

System requirements
-------------------

* PHP 5.4+
* SQLite3

Features
--------

* Users registration
* Registered users can post articles
* Registered users can "Like" articles

Installation
------------

    $ git clone https://github.com/digaev/demo_blog.git
    $ cd demo_blog
    $ php -S localhost:8000

Setup database
--------------

By default SQLite3 is used.

    $ cd demo_blog
    $ sqlite3 db/development.sqlite3
    sqlite> .read db/blog.sql

Name of the database depends on application environment, if you want to change it, edit the `application/config/database.php` file.
