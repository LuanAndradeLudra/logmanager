#!/bin/sh
set -e

WWWUSER="${WWWUSER:-1000}"
WWWGROUP="${WWWGROUP:-1000}"

mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache/data \
    storage/logs \
    bootstrap/cache

chown -R "${WWWUSER}:${WWWGROUP}" storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache
