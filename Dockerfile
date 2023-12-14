# Alpine Linux as the base image
FROM alpine:latest

# Install Nginx and PHP
RUN apk update && apk upgrade
RUN apk add --no-cache nginx php-fpm bash

# Setup Nginx web root
RUN mkdir -p /var/www
RUN chown -R nginx:nginx /var/www

# Copy the Nginx configuration file
COPY default.conf /etc/nginx/http.d/default.conf

# Copy the files to the Nginx web root
COPY index.html start.php poll.php script.js styles.css /var/www/

# Install custom test script
COPY test.sh /var/www/test.sh
# RUN chmod a+x /var/www/test.sh

# Startup script
COPY entry.sh /entry.sh
# RUN chmod a+x /entry.sh

# Expose port 
EXPOSE 80

# Start Nginx and PHP-FPM
CMD ["/entry.sh"]

