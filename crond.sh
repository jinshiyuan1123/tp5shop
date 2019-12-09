#!/bin/bash
if [ -f ~/.bash_profile ];
then
  . ~/.bash_profile
fi
step=1 #间隔的秒数，不能大于60  
for (( i = 0; i < 60; i=(i+step) )); do  
	PATH=/data/oneinstack/php/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
	cd /data/wwwroot/jcb.chinajucaibao.com/
    php think auto
    sleep $step  
done
exit 0 