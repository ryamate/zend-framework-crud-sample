FROM nginx:1.18.0-alpine

# timezone environment
ENV TZ=Asia/Tokyo

RUN apk --update --no-cache add git zip unzip

COPY ./docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/zf-sample/public
