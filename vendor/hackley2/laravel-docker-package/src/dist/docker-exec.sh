#!/usr/bin/env bash

if [ "$1" = "--help" ]; then

cat << EOF

Usage: ./docker-exec.sh [OPTIONS] CONTAINER COMMAND

Runs an exec command on the specified docker CONTAINER and the specified
COMMAND as a user with the same permissions as the host machine's permissions
Note that OPTIONS supports all docker exec options

Options:
   --help               Print Usage

EOF

else

    docker exec -ti -u $(id -u):$(id -g) "$@"

fi
