#!/bin/bash

source /var/www/CloudEther/resources/scripts/config

if [ -n "$1" ];
then



	hubStatus=`/var/www/CloudEther/resources/scripts/vpnStatus.sh -g $1`

        if [ "$hubStatus" = "Hub Exists" ]
        then

		echo "INFO: Removing $1"
	        /usr/local/vpnserver/vpncmd localhost:5555 /SERVER /PASSWORD:$softetherPass /CMD HubDelete $1 $> /dev/null
        	echo "INFO: Removed $1"
        	exit 0;


        fi

        if [ "$hubStatus" = "Hub Does Not Exist" ]
        then

		echo "Hub Does Not Exist"
                exit 1;

        fi


else
        echo "ERROR: No Hub Name Specified"
        exit 1;
fi
