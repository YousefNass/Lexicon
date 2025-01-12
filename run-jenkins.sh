#!/bin/bash

git add .
git commit -m "starting jenkins"
git push origin main

JENKINS_URL="http://localhost:8080/"
JENKINS_JOB="lexicon-job"
JENKINS_TOKEN="testAuth"

curl -X POST "${JENKINS_URL}/job/${JENKINS_JOB}/build?token=${JENKINS_TOKEN}"
