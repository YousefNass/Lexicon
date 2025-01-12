#!/bin/bash

git add .
git commit -m "starting jenkins"
git push origin main

JENKINS_URL="http://localhost:8080/"

curl -X POST "${JENKINS_URL}/buildByToken/build?job=lexicon-job&token=lexical-auth"
