FROM mariadb:5.5

COPY ./conf/conf.d /etc/mysql/conf.d
COPY ./conf/docker-entrypoint-initdb.d ./docker-entrypoint-initdb.d
RUN touch /var/log/mysqld-slow-query.log && \
    chown mysql:adm /var/log/mysqld-slow-query.log
