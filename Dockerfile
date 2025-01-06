FROM ubuntu
RUN apt update
RUN apt install -y apache2 php libapache2-mod-php php-mysql
WORKDIR /var/www/html
COPY word-site.php /var/www/html

EXPOSE 80

ENTRYPOINT ["/usr/sbin/apachectl", "-D", "FOREGROUND"]