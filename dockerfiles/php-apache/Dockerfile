FROM php:8.1.0-apache

RUN apt-get update \
    && apt-get install -y nano zip unzip git libicu-dev mariadb-server \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl mysqli \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

WORKDIR /var/www/html/

RUN git clone https://github.com/MinganB/financial-planning.git . \
    && composer install

RUN chown -R www-data:www-data /var/www/html \
    && composer self-update

COPY env_template /var/www/html/.env

RUN chown www-data:www-data /var/www/html/.env \
    && chmod 664 /var/www/html/.env

RUN mkdir -p /var/www/html/writable \
    && chown -R www-data:www-data /var/www/html/writable \
    && chmod -R 775 /var/www/html/writable

RUN mkdir -p /var/www/html/writable/cache \
    && chown -R www-data:www-data /var/www/html/writable/cache \
    && chmod -R 775 /var/www/html/writable/cache

RUN a2enmod rewrite

COPY codeigniter.conf /etc/apache2/sites-available/
RUN a2ensite codeigniter.conf \
    && service apache2 reload || true

RUN cd /etc/apache2/sites-available \
    && a2dissite 000-default.conf \
    && service apache2 reload || true

EXPOSE 80