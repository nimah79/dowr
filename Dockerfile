FROM phpswoole/swoole:6.0-php8.4-alpine

RUN apk add -Uuv \
    bash \
    git \
    zip \
    curl \
    sudo \
    unzip \
    nginx \
    libpng-dev \
    libmcrypt-dev \
    libxml2-dev \
    libzip-dev \
    icu-dev \
    icu-data-full \
    autoconf \
    make \
    g++ \
    supervisor \
    procps \
    linux-headers \
    nodejs \
    npm \
    && rm -rf /var/cache/apk/*


RUN docker-php-ext-install \
    bz2 \
    exif \
    gd \
    intl \
    bcmath \
    opcache \
    calendar \
    pdo_mysql \
    soap \
    zip

RUN docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install pcntl

WORKDIR /var/www/html

COPY package.json package-lock.json /var/www/html/
RUN npm install

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html
RUN cd /var/www/html && composer install --no-dev
RUN npm run build
RUN chown -R www-data:www-data /var/www

COPY ./deploy/nginx.conf /etc/nginx/nginx.conf
COPY ./deploy/default /etc/nginx/sites-enabled/default

RUN mkdir -p "/etc/supervisor/logs"
COPY ./deploy/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

RUN echo 'memory_limit = 512M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;

RUN crontab -l | { cat; echo "* * * * * cd /var/www/html/ && php artisan schedule:run >> /dev/null 2>&1"; } | crontab -

COPY docker-entrypoint.sh /var/www/html/docker-entrypoint.sh

RUN chmod +x /var/www/html/docker-entrypoint.sh

EXPOSE 80 8090

ENTRYPOINT ["/bin/bash", "/var/www/html/docker-entrypoint.sh"]
