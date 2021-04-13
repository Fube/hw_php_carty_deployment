CREATE SCHEMA IF NOT EXISTS cart;

use cart;

CREATE USER 'laravel'@'localhost' IDENTIFIED WITH mysql_native_password BY 'secret';
GRANT ALL PRIVILEGES ON laravel.* TO 'laravel'@'localhost';