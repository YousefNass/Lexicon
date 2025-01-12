#!/bin/bash

git add .
git commit -m "starting jenkins"
git push origin main

JENKINS_URL="http://localhost:8080/"
JENKINS_JOB="lexicon-job"
JENKINS_TOKEN="11148fe58bea485bec553fa283c049a271"

curl -u "weezo:11148fe58bea485bec553fa283c049a271" -X POST "${JENKINS_URL}/job/${JENKINS_JOB}/build?token=${JENKINS_TOKEN}"
