#!/bin/bash

# Stop execution if a step fails
set -e

DOCKER_USERNAME=jalmeida225 # Replace by your docker hub username
IMAGE_NAME=lbaw1754

# Ensure that dependencies are available
composer install
php artisan clear-compiled
php artisan optimize

docker build -t $DOCKER_USERNAME/$IMAGE_NAME .
docker push $DOCKER_USERNAME/$IMAGE_NAME
