# Alpine Linux as the base image
FROM alpine:latest

# Install Nginx and PHP
RUN apk update && apk upgrade
RUN apk add --no-cache nginx php-fpm bash

# Setup Nginx web root
RUN rm -rf /var/www
RUN mkdir -p /var/www
RUN chown -R nginx:nginx /var/www

# Copy the Nginx configuration file
COPY default.conf /etc/nginx/http.d/default.conf

# Startup script
COPY entry.sh /entry.sh

# Install custom test scripts
COPY runping.sh runtrace.sh /var/www/

# Copy the files to the Nginx web root
COPY *.php *.js *.css /var/www/

# Expose port 
EXPOSE 80

# Start Nginx and PHP-FPM
CMD ["/entry.sh"]
