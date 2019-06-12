#!/bin/bash
set -e

# Write env vars to config.

# shellcheck disable=2039
vars=(
    VARNISH_VCL_DEFAULT_BACKEND_HOST
    VARNISH_VCL_DEFAULT_BACKEND_PORT
    VARNISH_VCL_DEFAULT_ACL_PURGE_BAN
)
# shellcheck disable=2039
for var in "${vars[@]}"; do
    eval "val=\$$var"
    # shellcheck disable=2154
    sed -i 's@%'"$var"'%@'"$val"'@' /etc/varnish/default.vcl
done

exec varnishd \
  -j unix,user=varnishd \
  -F \
  -f /etc/varnish/default.vcl \
  -s "malloc,${VARNISH_MEMORY}" \
  -a "0.0.0.0:${VARNISH_PORT}" \
  ${VARNISH_DAEMON_OPTS}

