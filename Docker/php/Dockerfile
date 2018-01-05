FROM php:5.6-apache

RUN apt-get update -y
RUN apt-get install -y libpng-dev
RUN apt-get install -y libjpeg62-turbo-dev

RUN docker-php-ext-install mysqli
RUN docker-php-ext-configure gd --with-jpeg-dir=/usr/include
RUN docker-php-ext-install gd

RUN a2enmod rewrite
RUN a2enmod expires

RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -
RUN apt-get install -y nodejs
RUN apt-get install -y build-essential
