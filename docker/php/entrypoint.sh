#!/bin/sh
set -e

APP_UID=${UID:-1001}
APP_GID=${GID:-1001}

# Create group and user with provided IDs if they don't exist
if ! getent group appgroup >/dev/null; then
    groupadd -g "$APP_GID" appgroup
else
    groupmod -o -g "$APP_GID" appgroup
fi

if ! id appuser >/dev/null 2>&1; then
    useradd -u "$APP_UID" -g appgroup -m appuser
else
    usermod -o -u "$APP_UID" -g appgroup appuser
fi

# Ensure important Laravel directories exist with correct permissions
mkdir -p storage \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/testing \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

chown -R "$APP_UID":"$APP_GID" storage bootstrap/cache

# Run the given command as appuser
exec su appuser -s /bin/sh -c "$*"
