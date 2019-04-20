FROM mysql/mysql-server:5.6

COPY ./conf/my.cnf /etc/my.cnf
COPY ./conf/docker-entrypoint-initdb.d ./docker-entrypoint-initdb.d
RUN touch /var/log/mysqld-slow-query.log && \
    chown mysql:mysql /var/log/mysqld-slow-query.log
