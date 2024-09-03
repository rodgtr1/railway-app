#!/bin/bash

# Define the directory and file paths
SUPERVISOR_DIR="/etc/supervisor/config.d"
CONFIG_FILE="$SUPERVISOR_DIR/laravel-worker.conf"

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
command=php /app/artisan queue:work
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
numprocs=8
redirect_stderr=true
EOL

echo "Configuration file $CONFIG_FILE created successfully."
