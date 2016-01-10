#!/usr/bin/env python
# -*- coding: UTF-8 -*-
# author mengskysama

from web import db


class Server(db.Model):

    __tablename__ = 'server'

    id = db.Column(db.Integer, primary_key=True, nullable=False, autoincrement=True)
    host = db.Column(db.VARCHAR(128), nullable=False)
    ip = db.Column(db.VARCHAR(32), nullable=False)
    last_ping = db.Column(db.Integer, nullable=False)
    transfer = db.Column(db.Integer, nullable=False)
    locate = db.Column(db.VARCHAR(32), nullable=False)
    method = db.Column(db.VARCHAR(32), nullable=False)
    type_id = db.Column(db.Integer, nullable=False)
    is_public = db.Column(db.Boolean, default=False, nullable=False)

    def __repr__(self):
        return '<Server(id=%s, host=%s, locate=%s, type_id=%s, is_public=%s)>' % (
            self.id, self.host, self.locate, self.type_id, self.is_public
        )
