FROM ubuntu:quantal
MAINTAINER Fernando Mayo <fernando@tutum.co>

# Install packages
RUN apt-get update && apt-get -y upgrade && DEBIAN_FRONTEND=noninteractive apt-get -y install supervisor git apache2 libapache2-mod-php5 php5-mysql php5-gd php-pear php-apc php5-curl curl && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin && mv /usr/local/bin/composer.phar /usr/local/bin/composer

# Add image configuration and scripts
ADD https://raw.github.com/tutumcloud/tutum-docker-php/master/start.sh /start.sh
ADD https://raw.github.com/tutumcloud/tutum-docker-php/master/run.sh /run.sh
RUN chmod 755 /*.sh
ADD https://raw.github.com/tutumcloud/tutum-docker-php/master/supervisord-apache2.conf /etc/supervisor/conf.d/supervisord-apache2.conf

RUN mkdir -p /affili8/app && rm -fr /var/www && ln -s /affili8/app /var/www

EXPOSE 80
CMD ["/run.sh"]

ADD . /affili8

RUN cd /affili8 && composer install