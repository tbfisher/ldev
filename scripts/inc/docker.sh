#!/usr/bin/env bash

# IP of docker host from inside a container.
docker::host-ip() {
    # detect OS, mac uses special hostname to connect back to host
    unameOut="$(uname -s)"
    case "${unameOut}" in
        Darwin*)
            echo docker.for.mac.localhost
            ;;
        *)
            docker network inspect "${COMPOSE_PROJECT_NAME}_default" |
                jq -r '.[0].IPAM.Config[0].Gateway'
    esac
}

