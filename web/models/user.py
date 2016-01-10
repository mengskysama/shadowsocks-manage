#!/usr/bin/env python
# -*- coding: UTF-8 -*-
# author mengskysama

from web import db


class User(db.Model):

    __tablename__ = 'user'

    id = db.Column(db.Integer, primary_key=True, nullable=False, autoincrement=True)
    email = db.Column(db.VARCHAR(128), nullable=False, index=True)
    login_pass = db.Column('pass', db.VARCHAR(32), nullable=False)
    service_pass = db.Column('passwd', db.VARCHAR(32), nullable=False)
    service_port = db.Column('port', db.Integer, nullable=False, index=True)
    service_switch = db.Column('switch', db.Integer, nullable=False)
    service_enable = db.Column('enable', db.Integer, nullable=False)
    type = db.Column('type', db.Integer, nullable=False)
    last_service_time = db.Column('t', db.Integer, nullable=False)
    last_get_gift_time = db.Column('last_get_gift_time', db.Integer, nullable=False)

    transfer_upload = db.Column('u', db.Integer, nullable=False)
    transfer_download = db.Column('d', db.Integer, nullable=False)
    transfer_enable = db.Column('transfer_enable', db.Integer, nullable=False)

    def get_id(self):
        return unicode(self.id)

    def is_authenticated(self):
        return True

    def is_active(self):
        return self.service_enable

    def is_anonymous(self):
        return False


class Log(db.Model):

    __tablename__ = 'log'

    id = db.Column(db.Integer, primary_key=True, nullable=False, autoincrement=True)
    uid = db.Column(db.Integer, primary_key=True, default=0)
    ua = db.Column(db.VARCHAR(128), nullable=False)
    ip = db.Column(db.VARCHAR(32), nullable=False)
    time = db.Column(db.Integer, nullable=False)
    url = db.Column(db.VARCHAR(1024), nullable=False)
