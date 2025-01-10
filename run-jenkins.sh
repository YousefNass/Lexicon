#!/bin/bash

git add .
git commit -m "starting jenkins"
git push origin main

JENKINS_URL=""
JENKINS_JOB=""
JENKINS_TOKEN=""

curl -X POST "http://${JENKINS_URL}/job/${JENKINS_JOB}/build?token=${JENKINS_TOKEN}"