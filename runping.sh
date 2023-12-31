#!/bin/bash

# Unique ID for the temporary file and lock file
UNIQUE_ID=$1
TARGET_HOST=$2
OUT_FILE="/tmp/ping_output_$UNIQUE_ID.txt"
LOCK_FILE="/tmp/ping_output_$UNIQUE_ID.lock"

# Create the lock file
touch "$LOCK_FILE"

# Write results to temporary file
ping -c 31 -i 0.25 $TARGET_HOST > $OUT_FILE

# Delete the lock file to indicate completion
rm "$LOCK_FILE"
