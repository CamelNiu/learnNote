FROM centos:centos7
RUN groupadd -r redis && useradd -r -g redis redis
RUN mkdir data ;\
    yum update -y ; \
    yum -y install gcc automake autoconf libtool make wget epel-release gcc-c++;

COPY ./redis-5.0.7.tar.gz redis-5.0.7.tar.gz
RUN mkdir -p /usr/src/redis; \
    tar -zxvf redis-5.0.7.tar.gz -C /usr/src/redis; \
    rm -rf redis-5.0.7.tar.gz; \
    cd /usr/src/redis/redis-5.0.7 && make ; \
    cd /usr/src/redis/redis-5.0.7 && make install

COPY ./conf/redis.conf /usr/src/redis/redis-5.0.7/redis.conf

EXPOSE 6379

ENTRYPOINT ["redis-server", "/usr/src/redis/redis-5.0.7/redis.conf"]
