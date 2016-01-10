#!/usr/bin/env python
# -*- coding: UTF-8 -*-
# author mengskysama

from flask.ext.login import login_required
from flask import render_template, Blueprint, g
from web.models import Server
import time

manage_page = Blueprint('manage_page', __name__, template_folder='templates', url_prefix='/manage')


# AP控制面板
@login_required
@manage_page.route('/dashboard', methods=['GET'])
def dashboard():
    servers = Server.query.filter_by(is_public=True).all()
    return render_template('dashboard.html', servers=servers, user=g.user)


@login_required
@manage_page.route('/how', methods=['GET'])
def how():
    return render_template('how.html')
