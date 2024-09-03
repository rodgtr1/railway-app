#!/bin/bash

# Define directories and file paths
SUPERVISOR_DIR="/etc/supervisor/config.d"
CONFIG_FILE="$SUPERVISOR_DIR/laravel-worker.conf"
SUPERVISORD_CONF="/etc/supervisor/supervisord.conf"

# Check if the /etc/supervisor/config.d directory exists
if [ ! -d "$SUPERVISOR_DIR" ]; then
  echo "Directory $SUPERVISOR_DIR does not exist. Creating it..."
  mkdir -p "$SUPERVISOR_DIR"
else
  echo "Directory $SUPERVISOR_DIR exists."
fi

# Create the laravel-worker.conf file and insert the configuration
echo "Creating $CONFIG_FILE with Laravel worker configuration..."
cat <<EOL > "$CONFIG_FILE"
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /app/artisan queue:work --sleep=3 --tries=3 --timeout=60
autostart=true
autorestart=true
user=root
stopasgroup=true
killasgroup=true
numprocs=1
redirect_stderr=true
stdout_logfile=/var/log/supervisor/laravel-worker.out.log
stderr_logfile=/var/log/supervisor/laravel-worker.err.log
EOL

echo "Configuration file $CONFIG_FILE created successfully."

# Overwrite the supervisord.conf file with the required configuration
echo "Creating $SUPERVISORD_CONF with Supervisor configuration..."
cat <<EOL > "$SUPERVISORD_CONF"
[supervisord]
nodaemon=false
logfile=/var/log/supervisord.log
pidfile=/var/run/supervisord.pid

[unix_http_server]
file=/var/run/supervisor.sock
chmod=0700

[supervisorctl]
serverurl=unix:///var/run/supervisor.sock

[include]
files = /etc/supervisor/config.d/*.conf
EOL

echo "Main Supervisor configuration file $SUPERVISORD_CONF created successfully."
