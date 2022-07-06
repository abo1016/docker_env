FROM alicfeng/newlink_alpine:latest
LABEL Maintainer="AlicFeng <a@samego.com>" \
      Description="Nginx based on Alpine"

# install dependent app including nginx,supervisor,cron
RUN apk --no-cache add \
        nginx \
        nginx-mod-http-perl \
    # clean
    && rm -rf /tmp/* /var/cache/apk/*

# expose port
EXPOSE 80 443

# docker start container command
CMD ["nginx", "-g", "daemon off;"]
