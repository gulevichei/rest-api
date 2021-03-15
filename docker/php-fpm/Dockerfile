FROM phpdockerio/php74-cli

# Install FPM
RUN apt-get update \
    && apt-get -y --no-install-recommends install php7.4-fpm mysql-client \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


RUN apt-get update && apt-get install -y \
    php7.4-json \
    php7.4-mbstring \
    php7.4-pdo \
    php7.4-mysql \
    php7.4-soap \
    php7.4-xsl \
    php7.4-gd \
  && rm -rf /var/lib/apt/lists/* ^^ apt-get clean

STOPSIGNAL SIGQUIT

# PHP-FPM packages need a nudge to make them docker-friendly
COPY overrides.conf /etc/php/7.4/fpm/pool.d/z-overrides.conf

CMD ["/usr/sbin/php-fpm7.4", "-O" ]

WORKDIR /var/www/html

# Open up fcgi port
EXPOSE 9000
