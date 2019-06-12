from debian:stretch

run \
  useradd -r -s /bin/false varnishd

# install varnish source build dependencies.
run \
  apt-get update && apt-get install -y --no-install-recommends \
    automake \
    build-essential \
    ca-certificates \
    curl \
    libedit-dev \
    libjemalloc-dev \
    libncurses-dev \
    libpcre3-dev \
    libtool \
    pkg-config \
    python-docutils \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# install varnish from source, so that varnish modules can be compiled and installed.
env VARNISH_VERSION 4.1.11
RUN \
  mkdir -p /usr/local/src && \
  cd /usr/local/src && \
  curl -sfLO https://varnish-cache.org/_downloads/varnish-$VARNISH_VERSION.tgz && \
  tar -xzf varnish-$VARNISH_VERSION.tgz && \
  cd varnish-$VARNISH_VERSION && \
  ./autogen.sh && \
  ./configure && \
  make install && \
  ldconfig && \
  rm ../varnish-$VARNISH_VERSION.tgz

ENV VARNISH_PORT 80
ENV VARNISH_MEMORY 100m
# see http://varnish-cache.org/docs/4.1/reference/varnishd.html#list-of-parameters
ENV VARNISH_DAEMON_OPTS -p http_req_hdr_len=16384 -p http_resp_hdr_len=16384
COPY bin/start-varnishd.sh /usr/local/bin/start-varnishd
RUN chmod +x /usr/local/bin/start-varnishd

ENV VARNISH_VCL_DEFAULT_BACKEND_HOST='"web"'
ENV VARNISH_VCL_DEFAULT_BACKEND_PORT='"80"'
ENV VARNISH_VCL_DEFAULT_ACL_PURGE_BAN='"php"'
ARG vcl_src=conf/default.vcl
COPY $vcl_src /etc/varnish/default.vcl

EXPOSE 80
CMD ["start-varnishd"]

