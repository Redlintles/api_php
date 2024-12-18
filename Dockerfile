# Use a imagem oficial do PHP com Apache
FROM php:8.2-apache

WORKDIR /var/www/html

COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# Instale extensões PHP necessárias (adicione outras conforme necessário)
RUN apt-get update && apt-get install -y \
  libonig-dev \
  libzip-dev \
  unzip

RUN docker-php-ext-install mysqli pdo_mysql

# Copie os arquivos do projeto para o diretório público do Apache
COPY . .

# Configure permissões apropriadas para o Apache
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Habilite módulos necessários do Apache
RUN a2enmod rewrite

# Exponha a porta padrão do Apache
EXPOSE 80

CMD ["/bin/bash", "./scripts/wait-for-it.sh", "db:3306", "--", "bash", "-c", "if /var/www/html/propelRebuild.sh; then apache2-foreground; fi"]
