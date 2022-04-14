FROM smaregi/php:7.4.19-fpm-alpine3.13 AS php-base

# timezone environment
ENV TZ=Asia/Tokyo \
    # composer environment
    COMPOSER_ALLOW_SUPERUSER=1

RUN set -xe \
    && apk add --no-cache git=2.30.3-r0 \
    && docker-php-ext-enable xdebug

# composer のインストール
# (バージョンを1系に指定する理由は、2系であると依存関係のエラーが出るため)
COPY --from=composer:1 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/zf-sample
