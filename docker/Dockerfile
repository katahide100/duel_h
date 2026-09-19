# CakePHP 2.10 は PHP 7.4 までの対応のため 7.4 固定
FROM php:7.4-apache

RUN docker-php-ext-install pdo_mysql \
    && a2enmod rewrite

COPY apache-duel_h.conf /etc/apache2/sites-available/000-default.conf
COPY php.ini /usr/local/etc/php/conf.d/duel_h.ini
COPY entrypoint.sh /usr/local/bin/duel_h-entrypoint
COPY config /opt/duel_h-config
RUN chmod +x /usr/local/bin/duel_h-entrypoint

ENTRYPOINT ["duel_h-entrypoint"]
CMD ["apache2-foreground"]
