FROM php:7.3-apache

RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -

RUN apt-get update && apt-get install -y \
    build-essential \
    gnupg \
    libpng-dev \
    libjpeg62-turbo-dev \
    rsync \
    git \
    zip \
    nodejs

RUN docker-php-ext-install mysqli
RUN docker-php-ext-configure gd --with-jpeg-dir=/usr/include
RUN docker-php-ext-install gd

RUN a2enmod rewrite
RUN a2enmod expires

RUN curl --silent --show-error https://getcomposer.org/installer | php

RUN php -r "copy('https://getcomposer.org/installer', '/tmp/composer-setup.php');"
RUN php -r "if (hash_file('sha384', '/tmp/composer-setup.php') === 'e5325b19b381bfd88ce90a5ddb7823406b2a38cff6bb704b0acc289a09c8128d4a8ce2bbafcd1fcbdc38666422fe2806') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('/tmp/composer-setup.php'); } echo PHP_EOL;"
RUN php /tmp/composer-setup.php --install-dir /usr/local/bin/
RUN php -r "unlink('/tmp/composer-setup.php');"

RUN pear install PHP_CodeSniffer
