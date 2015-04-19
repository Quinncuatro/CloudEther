#!/bin/bash
if [ -n "$1" ];
then
        echo "INFO: Removing $1"
        /usr/local/vpnserver/vpncmd localhost:5555 /SERVER /PASSWORD:champlain /CMD HubDelete $1 $> /dev/null
        echo "INFO: Removed $1"
        exit 0;

else
        echo "ERROR: No Hub Name Specified"
        exit 1;
fi