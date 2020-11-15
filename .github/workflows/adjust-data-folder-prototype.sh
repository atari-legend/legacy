#!/bin/bash
# -
# Script to adjust the data folder when deploying inside the Laravel prototype
#
# The data folder is changed to a symlink pointing to the Laravel storage
# folder, so that we don't have to change all the path in the legacy site
set -e

DEPLOY_USER=$1
DEPLOY_HOST=$2
DEPLOY_PATH=$3

if [ -z "$DEPLOY_USER" ] || [ -z "$DEPLOY_HOST" ] || [ -z "$DEPLOY_PATH" ]; then
    echo "Missing mandatory deployment arguments"
    exit
fi

mkdir -p ~/.ssh/
ssh-keyscan $DEPLOY_HOST >> ~/.ssh/known_hosts

ssh $DEPLOY_USER@$DEPLOY_HOST "cd $DEPLOY_PATH/ && test -h data || ln -s ../storage data"
