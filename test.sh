#!/bin/bash

# Number of times to repeat
REPEAT_TIMES=5

for (( i=0; i<REPEAT_TIMES; i++ ))
do
    echo "$i: $(date)"
    sleep 1
done

