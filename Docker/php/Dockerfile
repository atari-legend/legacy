FROM php:8.1-apache

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

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
RUN docker-php-ext-configure gd --with-jpeg
RUN docker-php-ext-install gd

RUN a2enmod rewrite
RUN a2enmod expires

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -L -o /usr/bin/phpcs https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar
RUN chmod a+x /usr/bin/phpcs
RUN curl -L -o /usr/bin/phpcbf https://squizlabs.github.io/PHP_CodeSniffer/phpcbf.phar
RUN chmod a+x /usr/bin/phpcbf
