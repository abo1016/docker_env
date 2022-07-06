FROM ubuntu:18.04
LABEL Maintainer="AlicFeng <a@samego.com>"

# This is image info
# default PATH : /usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin

# env list
ENV DEBIAN_FRONTEND=noninteractive \
    TIMEZONE=Asia/Shanghai \
    LANG=C.UTF-8

# aliyun.sources.list
COPY aliyun.sources.list /etc/apt/sources.list

# container start default script
RUN  apt-get update \
    ## base dependence
    && apt-get install \
        curl \
        tzdata -y \
    && ln -sf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone \
    # clean
    && apt-get auto-remove php${PHP_VERSION}-dev curl zlib1g-dev libxml2-dev -y \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/local/src/* \
    && apt-get autoclean
