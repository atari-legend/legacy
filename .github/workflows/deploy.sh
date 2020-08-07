#!/bin/bash
# -
# Script to deploy the code to the dev server via rsync
set -e

RSYNC_FLAGS=(
    -avz
    # Delete all unknown files, except the ones excluded below
    --delete
    # Do not sync local data/ folder, keep the one on the server
    --exclude data
    # Exclude the connection settings file from being deleted, as it's
    # not in Git
    --exclude php/config/connection_settings.php
    # Exclude _elite folder, not in Git
    --exclude _elite
    # Exclude _stonish folder, not in Git
    --exclude _stonish
    # Exclude the atarilegend folder which contains the dev site
    --exclude atarilegend
    # Do not delete logs
    --exclude logs
)

DEPLOY_USER=$1
DEPLOY_HOST=$2
DEPLOY_PATH=$3

if [ -z "$DEPLOY_USER" ] || [ -z "$DEPLOY_HOST" ] || [ -z "$DEPLOY_PATH" ]; then
    echo "Missing mandatory deployment arguments"
    exit
fi

mkdir -p ~/.ssh/
ssh-keyscan $DEPLOY_HOST >> ~/.ssh/known_hosts

rsync ${RSYNC_FLAGS[@]} Website/AtariLegend/ $DEPLOY_USER@$DEPLOY_HOST:$DEPLOY_PATH/

ssh $DEPLOY_USER@$DEPLOY_HOST "cd $DEPLOY_PATH/php/admin/administration/ && php7.1-cli database_update.php"
