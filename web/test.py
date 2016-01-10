#!/usr/bin/env python
# -*- coding: UTF-8 -*-
# author mengskysama

from web import db


def init_db():
    db.create_all()

# init_db()
