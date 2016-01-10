#!/usr/bin/env python
# -*- coding: UTF-8 -*-
# author mengskysama


# #############################TEST##############################

SQLALCHEMY_DATABASE_URI = "mysql://root" \
                           ":" \
                           "root" \
                           "@" \
                           "mengsky.net/" \
                           "shadowsocks" \
                           "?charset=utf8"

SECRET_KEY = 'Qwwbk5yZff#3jkw12b'

# net.ipv4.ip_local_port_range 32768,61000
MIN_SERVICE_PORT = 61000
MAX_SERVICE_PORT = 65000

HOST_URL = 'http://tea.mengsky.net'

# init transfer
USER_INIT_TRANSFER = 10 * 1024 * 1024 * 1024

# mail config
MAIL_SERVER = 'smtp.gmail.com'
MAIL_PORT = 587
MAIL_USE_TLS = True
MAIL_USE_SSL = False
MAIL_USERNAME = 'smtp@gmail.com'
MAIL_PASSWORD = 'smtp'
