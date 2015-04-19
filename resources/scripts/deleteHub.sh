#!/bin/bash
if [ -n "$1" ];
then
        echo "INFO: Removing $1"
        echo "INFO: Removed $1"
        exit 0;
else
        echo "ERROR: No Hub Name Specified"
        exit 1;
fi

