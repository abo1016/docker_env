FROM alpine:3.13
LABEL Maintainer="AlicFeng <a@samego.com>" \
      Description="LNP container with Nginx1.16 as well as FPM7.3 based on Alpine"

# This is image info
# default PATH : /usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin

# env list
ENV TIMEZONE=Asia/Shanghai \
    COMPOSER_VERSION=1.10.20 \
    LANG=en_US.UTF-8 \
    LANGUAGE=en_US.UTF-8

# crontab
COPY crontab/default /var/spool/cron/crontabs/
# create container entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
# copy composer
COPY package/composer_${COMPOSER_VERSION}.phar /usr/local/bin/composer

# install dependent app including php,nginx,composer
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories && \
    # install evn dependence
    apk --no-cache add --virtual .build-deps --update \
        tzdata \
        gcc \
        g++ \
        libc-dev \
        make \
        automake \
        autoconf \
        openssl-dev \
        pcre-dev \
        zlib-dev \
        linux-headers \
        curl \
        curl-dev \
        git \
        gnupg \
        libxslt-dev \
        geoip-dev \
        pcre-dev \
        zlib-dev \
        freetype \
        libpng \
        libjpeg-turbo \
        freetype-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        gd-dev \
        php8-dev \
        gd \
    # install php nginx supervisor
    && apk --no-cache add \
        nss \
        openssl \
        php8=8.0.6-r0 \
        php8-fpm \
        php8-opcache \
        php8-mysqli \
        php8-json \
        php8-openssl \
        php8-curl \
        php8-zlib \
        php8-xml \
        php8-phar \
        php8-intl \
        php8-dom \
        php8-xmlreader \
        php8-ctype \
        php8-session \
        php8-simplexml \
        php8-mbstring \
        php8-gd \
        php8-pdo \
        php8-pdo_mysql \
	    php8-exif \
        php8-zip \
        php8-fileinfo \
        php8-tokenizer \
        php8-xmlwriter \
        php8-session \
        php8-iconv \
        php8-pecl-redis \
        nginx \
        supervisor  \
    # php alias handle php-config8  php-fpm8     php8         phpize8
    && ln -s /usr/bin/php8 /usr/bin/php \
    && ln -s /usr/sbin/php-fpm8 /usr/sbin/php-fpm \
    && ln -s /usr/bin/php-config8 /usr/sbin/php-config \
    # timezone
    && ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo $TIMEZONE > /etc/timezone \
    # create www.www and configuration for application
    && addgroup -S www \
    && adduser -D -S -h /var/cache/www -s /sbin/nologin -G www www \
    && mkdir -p /var/www/html /run/nginx /var/log/cron /var/log/supervisord \
    && chown -R www.www /run /var/lib/nginx /var/log/nginx /var/log/php8 /var/log/supervisord \
    && cat /var/spool/cron/crontabs/default >> /var/spool/cron/crontabs/root \
    # clean
    && apk del .build-deps -f \
    && rm -rf /tmp/* /var/cache/apk/*

# configure php-fpm
COPY php/php-fpm.d/www.conf /etc/php8/php-fpm.d/www.conf
COPY php/conf.d/php.ini /etc/php8/conf.d/php.ini

# configure supervisord
COPY supervisor /etc/supervisor

# configure nginx
COPY nginx/conf.d/ /etc/nginx/conf.d/
COPY nginx/nginx.conf /etc/nginx/nginx.conf

# add application
COPY --chown=www src/ /var/www/

# work dir
WORKDIR /var/www/app

# expose port
EXPOSE 80 443

# docker start container command
CMD ["docker-entrypoint.sh"]
