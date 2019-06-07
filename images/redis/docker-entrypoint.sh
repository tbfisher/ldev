#!/bin/sh
set -e

# https://forums.docker.com/t/docker-for-mac-how-to-set-host-settings-sysctl-etc/11168
echo never | tee /sys/kernel/mm/transparent_hugepage/enabled
echo never | tee /sys/kernel/mm/transparent_hugepage/defrag

# rest is same as parent image
# https://github.com/docker-library/redis/blob/master/3.2/docker-entrypoint.sh

# first arg is `-f` or `--some-option`
# or first arg is `something.conf`
if [ "${1#-}" != "$1" ] || [ "${1%.conf}" != "$1" ]; then
  set -- redis-server "$@"
fi

# allow the container to be started with `--user`
if [ "$1" = 'redis-server' -a "$(id -u)" = '0' ]; then
  chown -R redis .
  exec gosu redis "$0" "$@"
fi

exec "$@"
