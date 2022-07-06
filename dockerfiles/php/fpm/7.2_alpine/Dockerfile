FROM alpine:3.8
LABEL Maintainer="AlicFeng <a@samego.com>" \
    Description="FPM7.2 based on Alpine"

# env list
ENV TIMEZONE=Asia/Shanghai \
    CPHALCON_VERSION=3.4.5 \
    PHPREDIS_VERSION=4.3.0 \
    COMPOSER_VERSION=1.10.20 \
    SWOOLE_VERSION=4.4.2 \
    PROBUF_VERSION=3.17.1 \
    REDIS_VERSION=5.1.1 \
    XLSWRITER_VERSION=1.3.7 \
    YASD_VERSION=0.3.9 \
    LANG=en_US.UTF-8 \
    LANGUAGE=en_US.UTF-8

# work dir
WORKDIR /var/www/app

# copy composer
COPY package/composer_${COMPOSER_VERSION}.phar /usr/local/bin/composer

# copy composer
ADD package/yasd_${YASD_VERSION} /usr/local/src

# phalcon source package | notice:::source.*.bash2sh
ADD package/cphalcon-${CPHALCON_VERSION}.tar.gz /usr/local/src/

# install dependent app including php
RUN set -xue && \
    sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories && \
    # install evn dependence
    apk --no-cache add --virtual .build-deps --update \
    tzdata \
    gcc \
    g++ \
    libc-dev \
    make \
    automake \
    autoconf \
    libressl \
    libressl-dev \
    pcre-dev \
    zlib-dev \
    linux-headers \
    curl \
    curl-dev \
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
    gd \
    php7-dev \
    php7-pear \
    boost-dev \
    # install php nginx supervisor
    && apk --no-cache add \
    php7 \
    php7-fpm \
    php7-pdo \
    php7-pdo_mysql \
    php-mysqlnd \
    php7-mysqli \
    php7-json \
    php7-openssl \
    php7-curl \
    php7-zlib \
    php7-xml \
    php7-phar \
    php7-intl \
    php7-pcntl \
    php7-dom \
    php7-ctype \
    php7-session \
    php7-mbstring \
    php7-gd \
    php7-pdo \
    php7-opcache \
    php7-posix \
    php7-bcmath \
    php7-pdo_pgsql \
    php7-tokenizer \
    php7-xmlwriter \
    boost \
    # install cphalcon by source build
    && cd /usr/local/src/cphalcon-${CPHALCON_VERSION}/build \
    && ./install \
    && echo extension=phalcon.so >> /etc/php7/conf.d/phalcon.ini \
    # install xlswriter by pecl.online
    && pecl install xlswriter-${XLSWRITER_VERSION} \
    && echo extension=xlswriter.so >> /etc/php7/conf.d/xlswriter.ini \
    # install protobuf by pecl.online
    && pecl install protobuf-${PROBUF_VERSION} \
    && echo extension=protobuf.so >> /etc/php7/conf.d/protobuf.ini \
    # install swoole by pecl.online
    && pecl install swoole-${SWOOLE_VERSION} \
    && echo extension=swoole.so >> /etc/php7/conf.d/swoole.ini \
    # install redis by pecl.online
    && pecl install redis-${REDIS_VERSION} \
    && echo extension=redis.so >> /etc/php7/conf.d/redis.ini \
    && chmod 755 /usr/lib/php7/modules/*.so \
    # complie install yasd
    && cd /usr/local/src/yasd-${YASD_VERSION} \
    && phpize --clean && \
    phpize && \
    ./configure && \
    make clean && \
    make && \
    make install \
    && echo zend_extension=yasd >> /etc/php7/conf.d/yasd.ini \
    # timezone
    && ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo $TIMEZONE > /etc/timezone \
    # create www.www and configuration for application
    && addgroup -S www \
    && adduser -D -S -h /var/cache/www -s /sbin/nologin -G www www \
    && chown -R www.www /run /var/log/php7 \
    && echo -e "<?php\nphpinfo();" >> /var/www/app/index.php \
    # clean
    && apk del .build-deps -f \
    && rm -rf /tmp/* /var/www/localhost /var/cache/apk/* /usr/local/src/

# configure php-fpm
COPY php/php-fpm.d/www.conf /etc/php7/php-fpm.d/www.conf
COPY php/conf.d/php.ini /etc/php7/conf.d/php.ini

# expose port
EXPOSE 9000

# docker start container command
CMD ["php-fpm7", "-F"]
