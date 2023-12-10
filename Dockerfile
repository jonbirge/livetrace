# Stage 1: PHP installation
FROM php:7.4-fpm as php

# Stage 2: Nginx setup
FROM nginx:latest

# Copy PHP binaries from the PHP stage
COPY --from=php /usr/local/etc/php /usr/local/etc/php
COPY --from=php /usr/local/lib/php /usr/local/lib/php
COPY --from=php /usr/local/bin /usr/local/bin
COPY --from=php /usr/local/sbin /usr/local/sbin

# Install FastCGI
RUN apt-get update && apt-get install -y fcgiwrap && rm -rf /var/lib/apt/lists/*

# Copy the Nginx configuration file
COPY default.conf /etc/nginx/conf.d/default.conf

# Copy the PHP script to the Nginx web root
COPY index.php /usr/share/nginx/html/index.php

# Expose port 80
EXPOSE 80

# Start Nginx
CMD ["nginx", "-g", "daemon off;"]

