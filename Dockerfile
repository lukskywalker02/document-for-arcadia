# Dockerfile para Zoo Arcadia
# Imagen base: PHP 8.2 con Apache
FROM php:8.2-apache

# Instalar extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Node.js 18 (para npm, Gulp, y compilar assets)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Habilitar mod_rewrite y mod_headers para Apache
RUN a2enmod rewrite headers

# Copiar configuración de Apache
COPY docker/apache-config.conf /etc/apache2/sites-available/000-default.conf

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar composer.json y composer.lock
COPY composer.json composer.lock ./

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar dependencias PHP (vendor/)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copiar package.json y package-lock.json
COPY package.json package-lock.json ./

# Instalar dependencias Node.js (node_modules/ - Bootstrap, jQuery, DataTables, Gulp, etc.)
RUN npm ci --production=false

# Copiar el resto de los archivos (incluyendo src/, gulpfile.js, etc.)
COPY . .

# Compilar assets (SCSS -> CSS, JS -> minificado) a public/build/
# Esto compila Bootstrap, jQuery, DataTables, y tus archivos personalizados
RUN npx gulp buildCss || (npm run css || echo "Warning: CSS compilation failed, continuing...") \
    && npx gulp buildJs || echo "Warning: JS build failed, continuing..."

# Dar permisos al directorio
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exponer puerto 80
EXPOSE 80

# Comando por defecto (Apache ya se inicia automáticamente)
CMD ["apache2-foreground"]

