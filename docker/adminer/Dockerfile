FROM adminer:4

LABEL maintainer="Patrick Artounian <partounian@gmail.com>"

# Add volume for sessions to allow session persistence
VOLUME /sessions

#####################################
# SQL SERVER:
#####################################
USER root
ARG INSTALL_MSSQL=false
ENV INSTALL_MSSQL ${INSTALL_MSSQL}
RUN if [ ${INSTALL_MSSQL} = true ]; then \
  set -xe \
  # && apk --update add --no-cache --virtual .phpize-deps $PHPIZE_DEPS unixodbc unixodbc-dev \
  # && pecl channel-update pecl.php.net \
  # && pecl install pdo_sqlsrv-4.1.8preview sqlsrv-4.1.8preview \
  # && echo "extension=sqlsrv.so" > /usr/local/etc/php/conf.d/20-sqlsrv.ini \
  # && echo "extension=pdo_sqlsrv.so" > /usr/local/etc/php/conf.d/20-pdo_sqlsrv.ini \
  && apk --update add --no-cache freetds unixodbc \
  && apk --update add --no-cache --virtual .build-deps $PHPIZE_DEPS freetds-dev unixodbc-dev \
  && docker-php-ext-install pdo_dblib \
  && apk del .build-deps \
;fi

USER adminer

# We expose Adminer on port 8080 (Adminer's default)
EXPOSE 8080
