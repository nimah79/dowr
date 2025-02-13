#!/bin/bash

touch /var/www/html/database/database.sqlite
php artisan migrate --force
php artisan db:seed
php artisan storage:link
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan event:cache
npm run build

chown -R www-data:www-data /var/www

# Supervisor runs Nginx / octane / queue worker / schedule worker
supervisord -c /etc/supervisor/conf.d/supervisor.conf -n &

# Wait for any process to exit
wait -n

# Exit with status of process that exited first
exit $?
