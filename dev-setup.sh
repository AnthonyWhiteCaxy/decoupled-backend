#!/bin/sh

./app/console assets:install --symlink
./app/console cache:clear --env=dev
