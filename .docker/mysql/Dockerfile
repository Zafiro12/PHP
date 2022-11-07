FROM mysql:latest
COPY .docker/mysql/init.sql /docker-entrypoint-initdb.d/
ENV MYSQL_ROOT_PASSWORD root