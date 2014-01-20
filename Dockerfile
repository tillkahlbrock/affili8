FROM ubuntu:quantal

RUN apt-get update

RUN apt-get install -y apache2
RUN apt-get install -y php5 \
        php5-mysql \
        php5-gd \
        php5-curl \
        php5-mcrypt \
        php5-xdebug \
        php-apc \
        libapache2-mod-php5

RUN apt-get install -y curl

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2

ADD conf/000-default /etc/apache2/sites-enabled/

RUN a2enmod rewrite && apache2ctl restart

RUN mkdir -p /affili8/app && rm -fr /var/www && ln -s /affili8/app /var/www
ADD . /affili8

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin && mv /usr/local/bin/composer.phar /usr/local/bin/composer && composer --working-dir="/affili8" install

EXPOSE 80

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]