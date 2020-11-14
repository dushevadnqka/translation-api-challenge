#!/bin/sh

./bin/console doctrine:database:drop --force && ./bin/console doctrine:database:create && ./bin/console doctrine:schema:update --force && ./bin/console doctrine:fixtures:load -n && ./bin/console fos:oauth-server:create-client --grant-type=password