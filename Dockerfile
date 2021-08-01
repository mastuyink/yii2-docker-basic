FROM yiisoftware/yii2-php:7.4-apache

RUN a2enmod rewrite

WORKDIR /app
COPY ./ /app
# RUN composer install --prefer-dist --optimize-autoloader --no-dev\
#    && composer clear-cache

RUN apt-get update \
    && apt-get install -y unzip \
    && rm -rf runtime web/assets \
    && mkdir -p runtime web/assets \
    && chmod -R 775 runtime web/assets \
    && chown -R www-data:www-data runtime web/assets
EXPOSE 80
EXPOSE 443
EXPOSE 3306