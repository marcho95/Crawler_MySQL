#!/bin/bash

export USERID="$(id -u)"
export GROUPID="$(id -g)"

docker-compose stop
docker-compose rm -f
docker-compose build
docker-compose up -d --force-recreate

./bash.sh