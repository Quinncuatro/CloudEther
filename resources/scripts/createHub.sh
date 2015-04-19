#!/bin/bash
if [ -n "$1" ];
then
        echo "INFO: Creating $1 Hub"
        HubPassword=`date +%s | sha256sum | base64 | head -c 32`
        /usr/local/vpnserver/vpncmd localhost:5555 /SERVER /PASSWORD:champlain /CMD HubCreate $1 /PASSWORD:$HubPassword &> /dev/null
        echo "INFO: $1 Created"
        echo "Password: $HubPassword"
        exit 0;

else
        echo "ERROR: No Hub Name Specified"
        exit 1;
fi