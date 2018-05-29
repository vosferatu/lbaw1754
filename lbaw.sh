#!/bin/bash

xterm -e "cd ~/lbaw1754; docker-compose up; exec bash" &
sleep 5
xterm -e "cd ~/lbaw1754; php artisan db:seed; php artisan serve; exec bash"
