FROM uselagoon/lagoon-cli:latest as LAGOONCLI
FROM amazeeio/php:8.1-cli

#######################################################
# Install the nodejs version required
#######################################################
RUN apk del nodejs-current
RUN apk add --no-cache nodejs

#######################################################
# Install PHP extensions
#######################################################
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install posix
RUN docker-php-ext-install exif

#######################################################
# Setup Laravel Directories needed for composer install
#######################################################
RUN mkdir -p /app/storage/framework/{sessions,views,cache}
RUN mkdir -p /app/storage/app/public

#######################################################
# Install Laoon Tools Globally
#######################################################
COPY --from=LAGOONCLI /lagoon /usr/bin/lagoon
RUN DOWNLOAD_PATH=$(curl -sL "https://api.github.com/repos/uselagoon/lagoon-sync/releases/latest" | grep "browser_download_url" | cut -d \" -f 4 | grep linux_386) && wget -O /usr/bin/lagoon-sync $DOWNLOAD_PATH && chmod +x /usr/bin/lagoon-sync

#######################################################
# Copy files, and run installs for composer and yarn
#######################################################
COPY . /app
#RUN COMPOSER_MEMORY_LIMIT=-1 composer install

ENV WEBROOT=public
ENV PAGER=less
ENV PHP_MEMORY_LIMIT=8192M
