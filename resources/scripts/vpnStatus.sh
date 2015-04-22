#!/bin/bash

source /var/www/CloudEther/resources/scripts/config

name=

function serverStatus
{

portStatus=`nc -z 0.0.0.0 5555; echo $?`
if [ $portStatus -eq 0 ]
then
	echo "Service Is Online"
	exit 3
else
	echo "Service Is Offline"
	exit 4
fi

}

function getHub
{

hub=`/usr/local/vpnserver/vpncmd localhost:5555 /SERVER /PASSWORD:$softetherPass /CMD Hub $name | grep 'The Virtual Hub' | grep $name`

if [ -z "$hub" ]
then
	echo "Hub Does Not Exist"
	exit 5
else
	echo "Hub Exists"
	exit 6
fi

}


while getopts ":g:s" OPTION
do
     case $OPTION in
         s)
		serverStatus
		;;
         g)
		name=$OPTARG
		getHub

             ;;
     esac
done


