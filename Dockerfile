FROM ubuntu:18.04

WORKDIR /workspace

ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8
ENV TZ Etc/UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \
    && apt-get install software-properties-common -y \
    && add-apt-repository ppa:ondrej/php -y \
    && apt-get install curl -y

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
    && apt-get update

RUN apt-get install -y  \
    php7.3-cli \
    php7.3-curl \
    php7.3-iconv \
    php7.3-mbstring \
    php7.3-json \
    php7.3-phar \
    php7.3-xml \
    php7.3-zip \
    php7.3-dom \
    php7.3-redis \
    php7.3-cgi \
    git \
    yarn
#    && rm -rf /var/cache/apk/*

    
ADD docker/etc/php.ini /etc/php/7.3/cli/php.ini
ADD docker/etc/php.ini /etc/php/7.3/cgi/php.ini

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

RUN git clone https://github.com/ConnectedGames/MCMirror.git .
RUN composer install

RUN yarn install
RUN yarn encore production

EXPOSE 80

WORKDIR /workspace

ADD docker/run.sh /etc/app/run.sh
ENTRYPOINT ["/bin/bash", "/etc/app/run.sh"]