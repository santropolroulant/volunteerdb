Santropol Volunteer DB
======================

A simple volunteer CRM for use at [le Roulant](https://santropolroulant.org). Maybe it'll be useful for you to! Let us know :)

## Production Install

1. Clone this repo
    ```
    git clone https://github.com/santropolroulant/volunteerdb
    ```
2. Install project dependencies using [composer](https://getcomposer.org):
    ```
    composer install
    ```
    Note that this also generates a secret private password in `config/app.php`, e.g.:
    ```
    'Security' => [
            'salt' => env('SECURITY_SALT', '71fd2ea6382779f5980baeb63e3eae66b5d2a6e4f773a2902520acd3add80f74'),
             ],
    ```
    This should create config/app.php with some default settings in it.
    If it does _not_, run `composer install` a second time. This is a [known bug](https://github.com/santropolroulant/volunteerdb/issues/29).
3. Configure your webserver so that the document root is `volunteerdb/webroot/`.
   You should test that it runs at this point. The PHP should execute and you should get a CakePHP error, complaining about not being able to reach the database. If not, try again.
2. Create a database and a database user _with a strong password_. You may use [all the usual platforms](https://book.cakephp.org/3.0/en/orm/database-basics.html#supported-databases).

    There's an important catch here! VolunteerDB relies upon its database for searches,
    which means the database collation rules --- the rules that define what letters are
    in relation to each other, i.e. how to sort and compare --- will affect the UI.
    The default collation for MySQL is `latin1_swedish_ci` where "E" = "e" but "É" != "E",
    for example (and for a bilingual organisation like the Roulant this is a big deal).
    For a multilingual environment we need to set a full unicode-aware collation.

    Basically, on MySQL/MariaDB [you want](https://dev.mysql.com/doc/refman/8.0/en/charset-collation-implementations.html)
    ```
    CREATE DATABASE `volunteerdb` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    ```
   and on Postgres [you want](https://www.postgresql.org/docs/9.3/static/multibyte.html)
   ```
    CREATE DATABASE volunteerdb WITH ENCODING 'UTF-8' LC_COLLATE='en_US.UTF-8' LC_CTYPE='en_US.UTF-8';
   ```

4. Configure your database connection in `config/app.php`, e.g.:
    ```
    'Datasources' => [
        'default' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'localhost',
            /*
             * CakePHP will use the default DB port based on the driver selected
             * MySQL on MAMP uses port 8889, MAMP users will want to uncomment
             * the following line and set the port accordingly
             */
            //'port' => 'non_standard_port_number',
            'username' => 'volunteerdb',
            'password' => 'secret',
            'database' => 'volunteerdb',
    ```
3. Fill in the database schema:
    ```
    ./bin/cake migrations migrate
    ```
5. It should be running now. If not, try again, then file bug reports.

## Development setup

Development setup is very similar to production, except for what database you choose to use and what server to run on. In short:

    git clone https://github.com/santropolroulant/volunteerdb
    cd volunteerdb
    composer install && composer install # twice to guarantee config/app.php, as above
    < create and add a database and a database user volunteerdb_test, as explained above >
    $EDITOR config/app.php # add database credentials here, as explained above
    bin/cake migrations migrate
    # run the dev server, with verbose errors enabled
    DEBUG=1 bin/cake server

## Development setup - Docker mode

1. [Install Docker Compose](https://docs.docker.com/compose/install/)
2. ???
3. From the project root, run `docker-compose up`
3. The application should now be running on `http://localhost:8090`



