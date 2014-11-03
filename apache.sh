#!/bin/sh
#made by andyling QQ 87509994
while [ : ]
do
swaptotle=`free -m |grep Swap |awk '{print $2}'`
swapfree=`free -m | grep Swap |awk '{print $4}'`
freemem=`free -m |grep Mem |awk '{print $4}'`
web_status=`curl -o /dev/null -s  -w %{http_code} "http://socialmovie.innisfree.cn/main_innisfree.php"`
ipv4=`ifconfig eth0|grep "inet addr"| cut -f 2 -d ":"|cut -f 1 -d " "`
http_connections=`netstat -ant |grep ":80" | awk '{print $5}' | cut -d ":" -f4 | sort|uniq -c |wc -l`
zombie_pro=`ps -ef | grep defunct | grep httpd | wc -l`
http_pro=`ps aux |grep httpd |grep -v "grep"|wc -l`
cpu_status=`top -n 1 |awk '/^Cpu/{print $1,$2,$3,$5}'|sed  -e 's/,/ /g'`

echo -e "\e[35;1m"IPV4: $ipv4""
if [ $http_connections -gt 500  ];then

        echo -e "\e[31;1m"Http connections: \   $http_connections""
else
        echo -e "\e[32;1m"Http connections: \   "\e[35;1m""$http_connections"""
fi
if [ $http_pro -gt 256 ];then

        echo -e "\e[31;1m"Http processlists:\   $http_pro""
else
        echo -e "\e[32;1m"Http processlists:\   "\e[35;1m""$http_pro"""
fi

if [ $zombie_pro = 0 ];then

        echo -e "\e[32;1m"Zombie processlists: "\e[35;1m""$zombie_pro"""
else
        echo -e "\e[31;1m"Zombie processlists: $zombie_pro""
fi

echo -e "\e[32;1m"Free Memory: "\e[35;1m"$freemem""" MB"

if [ $swapfree = $swaptotle ];then
        echo -e "\e[32;1m"Swap memory is\  "\e[35;1m"OK""""
else
        echo -e "\e[31;1m"Memory warning!!!!!!!!!""
fi
if [ $web_status = 200 ];then

        echo -e "\e[32;1m"Web status is : "\e[35;1m"$web_status""""
else
        echo -e "\e[31;1m"Web Site was warning!!!!!!!!!""
fi

echo -e "\e[32;1m"$cpu_status""
echo -e "\e[36;1m"=====================================""
echo -e "\e[0m"
sleep 5
done