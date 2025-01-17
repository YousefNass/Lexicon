#!/bin/bash

git add .
git commit -m "starting jenkins"
git push origin main

JENKINS_URL="http://192.168.64.6:8080/"

curl -X POST "${JENKINS_URL}/buildByToken/build?job=lexicon-job&token=lexical-auth"
