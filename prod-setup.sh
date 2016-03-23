#!/bin/sh
# production enviroment setup

./app/console assets:install
./app/console cache:clear --env=prod --no-debug
