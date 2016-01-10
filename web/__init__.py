#!/usr/bin/env python
# -*- coding: UTF-8 -*-
# author mengskysama

from flask import Flask
from flask.ext.sqlalchemy import SQLAlchemy
from flask.ext.login import LoginManager
from flask.ext.redis import Redis
from flask.ext.mail import Mail

import sys
reload(sys)
sys.setdefaultencoding('utf8')

app = Flask(__name__)
app.debug = True
app.config.from_pyfile('../conf/config.py')
app.secret_key = app.config.get('SECRET_KEY')

# mail
mail = Mail(app)

# database
db = SQLAlchemy(app)
from web import models

# login manager
login_manager = LoginManager()
login_manager.init_app(app)
login_manager.login_view = 'login'

# views
from web import views
from views.manage import manage_page
from views.api import api

app.register_blueprint(manage_page)
app.register_blueprint(api)
