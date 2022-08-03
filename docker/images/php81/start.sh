#!/bin/bash

# Run Swoole
composer install
#  composer update
#  php artisan key:generate

#	php artisan octane:install --server="swoole"

#php artisan octane:start --workers=4 --task-workers=8 --host="0.0.0.0" --watch;
php artisan octane:start --server="swoole" --host="0.0.0.0" --workers=${SWOOLE_WORKERS} --task-workers=${SWOOLE_TASK_WORKERS} --max-requests=${SWOOLE_MAX_REQUESTS} --watch ;
#    run_server;
#fi
