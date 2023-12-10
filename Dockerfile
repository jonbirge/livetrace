# Alpine Linux as the base image
FROM alpine:latest

# Install Nginx and PHP along with the necessary PHP extensions
RUN apk update
RUN apk upgrade
RUN apk add --no-cache nginx 
RUN apk add --no-cache php php-fpm php-opcache
RUN mkdir -p /run/nginx

# Copy the Nginx configuration file
COPY default.conf /etc/nginx/conf.d/default.conf

# Copy the PHP script to the Nginx web root
COPY index.php /var/www/localhost/htdocs/index.php

# Setup permissions for Nginx web root
RUN chown -R nginx:nginx /var/www/localhost/htdocs

# Expose port 
EXPOSE 8080

# Start Nginx and PHP-FPM
CMD ["nginx", "-g", "daemon off;"]

