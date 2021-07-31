FROM yiisoftware/yii2-php:7.4-apache

RUN a2enmod rewrite

WORKDIR /app
COPY ./ /app
# RUN composer install --prefer-dist --optimize-autoloader --no-dev\
#    && composer clear-cache

RUN rm -rf runtime web/assets web/UPLOADED_FILES web/upload web/tmp UPLOADED_FILES TMP \
    && mkdir -p runtime web/assets web/UPLOADED_FILES web/upload web/tmp UPLOADED_FILES TMP \
    && chmod -R 775 runtime web/assets web/UPLOADED_FILES web/upload web/tmp UPLOADED_FILES TMP \
    && chown -R www-data:www-data runtime web/assets web/UPLOADED_FILES web/upload web/tmp UPLOADED_FILES TMP