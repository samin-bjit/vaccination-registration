#!/bin/bash


export KUBECONFIG=$HOME/.kube/config

CREDENTIALS=$(aws sts assume-role --role-arn arn:aws:iam::678554781153:role/service-role/Vaccination-CodeBuildServiceRole --role-session-name eks-codebuild --region ap-southeast-1)
export AWS_ACCESS_KEY_ID="$(echo ${CREDENTIALS} | jq -r '.Credentials.AccessKeyId')"
export AWS_SECRET_ACCESS_KEY="$(echo ${CREDENTIALS} | jq -r '.Credentials.SecretAccessKey')"
export AWS_SESSION_TOKEN="$(echo ${CREDENTIALS} | jq -r '.Credentials.SessionToken')"
export AWS_EXPIRATION=$(echo ${CREDENTIALS} | jq -r '.Credentials.Expiration')

echo "Update Kube Config"
aws eks update-kubeconfig --name vaccination-system-eks --region ap-southeast-1
echo "Apply changes to kube manifests"  
kubectl get pods -A
