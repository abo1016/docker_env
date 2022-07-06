FROM 4bopop/runtime:v1

RUN apk add php7-xdebug \
    && echo zend_extension=xdebug.so >> /etc/php7/conf.d/xdebug.ini \
    && rm -rf /tmp/* /var/cache/apk/*
