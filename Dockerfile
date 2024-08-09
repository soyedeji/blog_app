# Dockerfile

# Use an official PHP image with Apache
FROM php:8.3.7-apache

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy the current directory contents into the container
COPY . /var/www/html/

# Expose port 80 for the web server
EXPOSE 80

# Optionally, set the ServerName globally to suppress warnings
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
