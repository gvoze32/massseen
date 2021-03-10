#!/bin/bash
while true
do
echo "Shuffling Target Data..."
shuf data/targetData.txt -o data/targetData.txt
echo "Running Massseen..."
php run.php
sleep 1
done