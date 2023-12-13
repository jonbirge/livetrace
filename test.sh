#!/bin/bash

# Unique ID for the temporary file and lock file
UNIQUE_ID=$1
TEMP_FILE="/tmp/test_output_$UNIQUE_ID.txt"
LOCK_FILE="/tmp/test_output_$UNIQUE_ID.lock"

# Create the lock file
touch "$LOCK_FILE"

# Number of times to repeat
REPEAT_TIMES=9

# Write output to a temporary file
for (( i=0; i<REPEAT_TIMES; i++ ))
do
    echo "$i: $(date)" >> "$TEMP_FILE"
    sleep 1
done

# Delete the lock file to indicate completion
rm "$LOCK_FILE"

