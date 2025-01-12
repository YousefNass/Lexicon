#!/bin/bash

git add .
git commit -m "starting jenkins"
git push origin main

JENKINS_URL="http://localhost:8080/"
JENKINS_JOB="lexicon-job"
#add your own USER and TOKEN
JENKINS_TOKEN="11762108ab453b942e7c7d84d617c9a5d1"
JENKINS_USER="weezo"

curl -u "${JENKINS_USER}:${JENKINS_TOKEN}" -X POST "${JENKINS_URL}/job/${JENKINS_JOB}/build?token=${JENKINS_TOKEN}"
