#!/bin/bash
# -
# Script to deploy the code to the dev server via rsync
set -e

# BRANCH is the current branch, but for pull requests will contain the
# name of the *target* branch!
echo "Current BRANCH: ${BRANCH}"
# HEAD_BRANCH is set only on merge requests and contains the name of the
# source branch
echo "Current HEAD_BRANCH: ${HEAD_BRANCH}"

# We want to deploy only when the dev branch is built, outside of a
# pull request
if [ -z "${HEAD_BRANCH}" ] && [ "${BRANCH}" == "development" ]; then
    rsync -azv Website/AtariLegend/* $DEV_DEPLOY_USER@$DEV_DEPLOY_HOST:$DEV_DEPLOY_PATH/
fi
