FROM php:5.6-apache-jessie

COPY ./apt-testing /etc/apt/preferences.d/testing

RUN apt-get update \
	&& apt-get upgrade -y \
	&& apt-get install -y \
		aptitude \
		apt-utils \
		wget \
		vim \
		net-tools \
		git \
		sudo \
		zip \
		unzip \
		libssl-dev \
		acl \
		apache2 \
		curl \
	&& a2enmod rewrite \
	&& a2enmod headers \
	&& apachectl -t \
	&& apt-get clean all

ENV TERM xterm

RUN adduser agh -u 1000 -home /home/agh --shell /bin/bash --disabled-password --gecos ""
RUN usermod www-data --append --groups agh

COPY ./my-httpd.conf /etc/apache2/conf-enabled/001-symfony.conf
COPY ./php.ini /usr/local/etc/php/
COPY ./.bashrc /root/.bashrc
COPY ./.bashrc /home/agh/.bashrc
COPY ./run.sh /run.sh
RUN chmod +x /run.sh

RUN chown agh:agh /home/agh/.bashrc
RUN docker-php-ext-install mysqli \
	&& docker-php-ext-enable mysqli

WORKDIR /home/agh
USER agh

VOLUME /home/agh/.gitconfig
VOLUME /home/agh/.ssh

VOLUME /var/www/agh
WORKDIR /var/www/agh/code

USER root

CMD ["/run.sh"]