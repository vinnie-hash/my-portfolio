# Use the official PHP Apache image
FROM php:8.2-apache

# Set working directory inside the container
WORKDIR /var/www/html

# Copy all project files into the container
COPY . .

# Enable Apache rewrite module (for .htaccess)
RUN a2enmod rewrite

# Optionally install PHP extensions if needed (e.g., PDO for MySQL)
# RUN docker-php-ext-install pdo pdo_mysql

# Expose port 80 (Apache default)
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]