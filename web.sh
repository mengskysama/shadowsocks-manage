#!/bin/bash

DAEMON="/usr/local/bin/uwsgi"
ARGS=" /home/python/shadowsocks-manage/conf/uwsgi/shadowsocks-manage.ini --catch-exceptions"
PID="/home/python/shadowsocks-manage/web.pid"

case $1 in
"start" )
    echo '--------start----------'
    start-stop-daemon --start -b --make-pidfile --pidfile $PID --exec $DAEMON -- $ARGS
    if [ $? -ne 0 ]; then
        echo 'start failed'
        exit 1
    fi
    ;;
"stop" )
    echo '--------stop----------'
    start-stop-daemon --stop --pidfile $PID --signal 3
    if [ $? -ne 0 ]; then
        echo 'stop failed'
        exit 1
    fi
    ;;
"reload" )
    echo '--------reload----------'
    $DAEMON --reload $PID
    if [ $? -ne 0 ]; then
        echo 'reload failed'
        exit 1
    fi
    ;;
esac
