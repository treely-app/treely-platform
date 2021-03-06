#!/bin/bash

# Check if your a sudo user
if [ "$EUID" -ne 0 ]
    then
    echo "Please run as root."
    exit
fi

if [ -z "$1" ]
    then
    echo "No user supplied!"
    exit
fi

# Set your user as owner
chown -R $1:www-data ./
find ./ -type f -exec chmod 664 {} \;
find ./ -type d -exec chmod 775 {} \;

# Give the webserver the rights to read and write to storage and cache
chgrp -R www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache
chmod -R a+x node_modules

# Make this script executable again
chmod +x $0

echo -e "\033[0;32mFile permissions fixed.\033[0m"
