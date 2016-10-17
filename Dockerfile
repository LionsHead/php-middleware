FROM php

RUN apt-get update && apt-get install -y mysql-client libmysqlclient-dev \
      && docker-php-ext-install pdo_mysql

ADD . /php_app
EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "/php_app/public"]
