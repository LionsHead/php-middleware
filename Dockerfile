FROM php

RUN apt-get update && apt-get install -y mysql-client libmysqlclient-dev \
    git zip unzip php-pclzip && docker-php-ext-install pdo_mysql

ADD . /php_app
EXPOSE 8000

WORKDIR /php_app

RUN curl --silent --show-error https://getcomposer.org/installer | php

CMD ["php", "-S", "0.0.0.0:8000", "-t", "/php_app/public"]
