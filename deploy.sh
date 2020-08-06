#!/bin/bash
# -
# Script to deploy the code to the dev server via rsync
set -e

RSYNC_FLAGS=(
    -avzn
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

# BRANCH is the current branch, but for pull requests will contain the
# name of the *target* branch!
echo "Current BRANCH: ${BRANCH}"
# HEAD_BRANCH is set only on merge requests and contains the name of the
# source branch
echo "Current HEAD_BRANCH: ${HEAD_BRANCH}"

# We want to deploy only when the dev branch is built, outside of a
# pull request
if [ -z "${HEAD_BRANCH}" ] && [ "${BRANCH}" == "development" ]; then
    echo "Development deployment"

    rsync ${RSYNC_FLAGS[@]} Website/AtariLegend/ $DEV_DEPLOY_USER@$DEV_DEPLOY_HOST:$DEV_DEPLOY_PATH/

    # Run the DB upgrade script via the PHP command-line interface
    ssh $DEV_DEPLOY_USER@$DEV_DEPLOY_HOST "cd $DEV_DEPLOY_PATH/php/admin/administration/ && php7.1-cli database_update.php"
fi

# Similarly, deploy only on prod when the master branch is built,
# outside of a pull request
if [ -z "${HEAD_BRANCH}" ] && [ "${BRANCH}" == "master" ]; then
    echo "Production deployment"

    rsync ${RSYNC_FLAGS[@]} Website/AtariLegend/ $PROD_DEPLOY_USER@$PROD_DEPLOY_HOST:$PROD_DEPLOY_PATH/

    # Run the DB upgrade script via the PHP command-line interface
    ssh $PROD_DEPLOY_USER@$PROD_DEPLOY_HOST "cd $PROD_DEPLOY_PATH/php/admin/administration/ && php7.1-cli database_update.php"
fi
