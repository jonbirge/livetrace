# Alpine Linux as the base image
FROM alpine:latest

# Install Nginx and PHP
RUN apk update && apk upgrade
RUN apk add --no-cache nginx php-fpm 

# Setup permissions for Nginx web root
RUN mkdir -p /var/www
RUN chown -R nginx:nginx /var/www

# Copy the Nginx configuration file
COPY default.conf /etc/nginx/http.d/default.conf

# Copy the PHP script to the Nginx web root
COPY index.php /var/www/index.php

# Startup script
COPY start.sh /start.sh
RUN chmod a+x /start.sh

# Expose port 
EXPOSE 80

# Start Nginx and PHP-FPM
CMD ["/start.sh"]

