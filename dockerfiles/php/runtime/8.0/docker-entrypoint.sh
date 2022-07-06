#!/usr/bin/env sh

# handle filesystem permission
chown www:www -R /var/www

# start supervisor service
/usr/bin/supervisord -c /etc/supervisor/supervisord.conf
