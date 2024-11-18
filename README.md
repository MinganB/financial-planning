# Financial planning app

## Project overview
The application will enable users to update their personal details, create and a manage a personal budget, record their assets and liabilities, and view their financial planning summary information. An API (Application Programming Interface) will allow third-party applications used by financial planners to view and edit client data.

## Docker installation (Recommended)

- This guide provides step-by-step instructions for setting up the app using Docker.

### Prerequisites
1. Docker
2. Docker compose

### Installation steps
1. Clone the repository to your local machine:
- `git clone https://github.com/MinganB/financial-planning.git`
2. Build and start the docker container
- `docker compose up --build`

## Manual installation (Not recommended)

### Server Requirements

#### PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if using MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if using HTTP\CURLRequest library

#### Apache HTTP server is required (version 2.4 preferred)

- https://httpd.apache.org/docs/2.4/install.html

#### MariaDB Server version 11.0 or higher

- https://mariadb.com/kb/en/getting-installing-and-upgrading-mariadb/

#### Composer Dependency Manager for PHP version 2.8 or higher

- https://getcomposer.org/

### Installation steps (using Composer on Linux)
1. Clone the project's ([GitHub repository](https://github.com/MinganB/financial-planning.git)) to the working directory
- Using:
```sudo git clone https://github.com/MinganB/financial-planning.git .```
2. Install the project dependancies
- Using:
```composer install```
3. Set the correct file permissions, ensuring the "writable" file is writable
- Using:
```sudo chmod -R 0777 writable```
4. Update the document root to point to CodeIgniter's public folder (e.g. /var/www/html/.../public)
- Set the root:
```sudo vi /etc/httpd/conf/httpd.conf```
...
```sudo systemctl restart httpd```
5. Migrate the database
- Transfer ```migrations.sql``` to your web-server and import into MariaDB
6. Update the .env file
- Copy the env file to ```.env``` and complete the MariaDB database connection details
7. Ensure that the .env file has the correct file permissions and is not publicly accessible
- For example using the following rule:
```
<Files ".env">
    Require all denied
</Files>
```
