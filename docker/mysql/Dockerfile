FROM mysql:5.7

LABEL author="Christopher Koleda" version="1.0.0"

#####################################
# Set Timezone
#####################################

ARG TZ=UTC
ENV TZ America/New_York

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone && chown -R mysql:mysql /var/lib/mysql /var/run/mysqld 

COPY ./docker/mysql/my.cnf /etc/mysql/conf.d/my.cnf

# uncomment this line to start mysql with dumpfile preloaded
# COPY ./docker/mysql/dump.sql /docker-entrypoint-initdb.d/dump.sql

RUN chmod 0444 /etc/mysql/conf.d/my.cnf

EXPOSE 3306 33060

CMD ["mysqld"]