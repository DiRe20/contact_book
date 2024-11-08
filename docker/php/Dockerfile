FROM php:8.3.6-fpm

RUN apt-get update

RUN apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    libpq-dev \
    tesseract-ocr\
    acl \
    curl \
    nano

# Xdebug
ARG INSTALL_XDEBUG=true
RUN if [ ${INSTALL_XDEBUG} = true ]; \
    then \
      pecl install xdebug && docker-php-ext-enable xdebug; \
    fi;

RUN docker-php-ext-configure gd --with-jpeg --with-freetype

RUN docker-php-ext-install \
   pdo pdo_pgsql zip xsl gd intl opcache exif mbstring

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY xdebug.ini "${PHP_INI_DIR}/conf.d"
COPY error_reporting.ini "${PHP_INI_DIR}/conf.d"
COPY php.ini "${PHP_INI_DIR}/conf.d"

RUN echo "zend_extension=xdebug.so" > "${PHP_INI_DIR}/conf.d/xdebug.ini"

RUN cp /etc/ssl/openssl.cnf /etc/ssl/openssl.cnf.ORI
RUN sed -i "s/\(MinProtocol *= *\).*/\1TLSv1.0 /" "/etc/ssl/openssl.cnf"
RUN sed -i "s/\(CipherString *= *\).*/\1DEFAULT@SECLEVEL=1 /" "/etc/ssl/openssl.cnf"
RUN (diff -u /etc/ssl/openssl.cnf.ORI /etc/ssl/openssl.cnf || exit 0)

WORKDIR /home/fidu/application

RUN chown -R www-data:www-data .

# Executando o PHP
CMD ["php-fpm"]

