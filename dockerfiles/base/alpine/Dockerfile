FROM alpine:latest
LABEL Maintainer="AlicFeng <a@samego.com>" \
      Description="Alpine Image"

# env list
ENV LANG=en_US.UTF-8 \
    LANGUAGE=en_US.UTF-8

RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories

