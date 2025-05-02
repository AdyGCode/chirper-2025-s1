#!/bin/bash

# Update this path to your project directory (use forward slashes)
PROJECT_PATH="/c/Users/5001775/Source/Repos/chirper-2025-s1"

while true; do
    cd "$PROJECT_PATH"
    php artisan schedule:run
    sleep 60  # Sleep for 300 seconds (5 minutes)
done
