#!/bin/sh

# Get the token from AWS.
token=$(aws eks get-token --region ap-southeast-1 --cluster-name vaccination-system-eks)

# Update the Kubernetes configuration file.
kubectl config set-credentials arn:aws:eks:ap-southeast-1:678554781153:cluster/vaccination-system-eks --exec-command "aws eks get-token --region ap-southeast-1 --cluster-name vaccination-system-eks"


