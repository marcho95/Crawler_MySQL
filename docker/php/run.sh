#!/bin/bash

echo "Running AGH PHP server"

# Docker by default do not add to /etc/resolv.conf nameservers used by host
# -dns optionsin docker-compose doesn't work either
echo "nameserver 11.0.0.1" >> /etc/resolv.conf
echo "nameserver 8.8.8.8" >> /etc/resolv.conf

apache2-foreground