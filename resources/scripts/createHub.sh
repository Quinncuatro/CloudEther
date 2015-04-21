#!/bin/bash

source config


if [ -n "$1" ];
then
	hubStatus=`/var/www/CloudEther/resources/scripts/vpnStatus.sh -g $1` 

        if [ "$hubStatus" = "Hub Exists" ]
	then
		echo "Hub Name Already In Use"
		exit 2;

	fi

	if [ "$hubStatus" = "Hub Does Not Exist" ]
        then
		echo "INFO: Creating $1 Hub"
	        HubPassword=`date +%s | sha256sum | base64 | head -c 32`
        	/usr/local/vpnserver/vpncmd localhost:5555 /SERVER /PASSWORD:$softetherPass /CMD HubCreate $1 /PASSWORD:$HubPassword $> /dev/null

        	echo "INFO: $1 Created"
        	echo "Password: $HubPassword"
        	exit 0;

        fi


else
        echo "ERROR: No Hub Name Specified"
        exit 1;
fi
