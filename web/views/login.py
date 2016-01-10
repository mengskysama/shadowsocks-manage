#!/usr/bin/env python
# -*- coding: UTF-8 -*-
# author mengskysama

from flask import Blueprint, render_template, abort, g, redirect, session, url_for, request, flash
from flask.ext.login import login_user, logout_user, current_user, login_required
from flask_mail import Message
from web.models import User, Log
from web import app, login_manager, mail, db
from web.ulits import md5
import re
import random
import time


@app.route('/', methods=['GET', 'POST'])
@app.route('/login', methods=['GET', 'POST'])
def login():
    # if already login
    if hasattr(g, 'user') and g.user is not None and isinstance(g.user, User) and g.user.is_authenticated():
        return redirect(url_for('index'))
    # get request
    if request.method == 'GET':
        return render_template('login.html')
    # post request
    elif request.method == 'POST':
        email = request.form['email']
        password = request.form['password']
        user = User.query.filter_by(email=email, login_pass=password).first()
        if user is None:
            # login failed
            flash('Invalid email or password. Please try again.')
            return redirect(url_for('login'))
        if user.service_port == 0:
            # login failed
            flash('Validate email please!')
            return redirect(url_for('login'))
        login_user(user, remember=False)
        return redirect(request.args.get('next') or url_for('index'))


@app.route('/sign', methods=['GET', 'POST'])
def sign():
    # valid username and password
    email = request.form['email']
    if re.match('\S+@\S+\.\S+', email) is None:
        flash('Invalid email address.')
        return redirect(url_for('login'))
    password = request.form['password']
    if re.match('[0-9a-f]{32}', password) is None:
        flash('Invalid password.')
        return redirect(url_for('login'))
    user = User.query.filter_by(email=email).first()
    if user is not None:
        flash('Email already exist.')
        return redirect(url_for('login'))
    try:
        msg = Message("Account",
                      sender=app.config.get('MAIL_USERNAME'),
                      recipients=[email])
        msg.body = app.config.get('HOST_URL') + "/validate?vcode=%s&email=%s" % \
                                               (md5(app.config.get('SECRET_KEY') + email), email)
        mail.send(msg)
    except:
        import traceback
        traceback.print_exc()
        flash('Mail error happend. Contact us!')
        return redirect(url_for('login'))
    user = User()
    user.email = email
    user.login_pass = password
    user.service_pass = str(random.randint(1000000, 99999999))
    user.transfer_download = 0
    user.transfer_upload = 0
    user.transfer_enable = 0
    user.service_enable = 0
    user.service_switch = 0
    user.last_service_time = 0
    user.last_get_gift_time = 0
    user.type = 0
    user.service_port = 0
    db.session.add(user)
    flash('Validate email send.')
    return redirect(url_for('login'))


@app.route('/validate', methods=['GET', 'POST'])
def validate():
    email = request.args.get('email')
    vcode = request.args.get('vcode')
    code = md5(app.config.get('SECRET_KEY') + email)
    user = User.query.filter_by(email=email).first()
    if user is None:
        flash('Validate failed!')
        return redirect(url_for('login'))
    if vcode != code:
        flash('Validate failed! Code error!')
        return redirect(url_for('login'))
    if user.service_port == 0:
        # find a idle port
        prot_max = app.config.get('MAX_SERVICE_PORT')
        max_service_port = db.session.query(db.func.max(User.service_port)).scalar()
        if max_service_port == 0:
            user.service_port = app.config.get('MIN_SERVICE_PORT')
        elif max_service_port >= prot_max:
            flash('There is no idle port. Contact us!')
            return redirect(url_for('login'))
        user.service_port = max_service_port + 1
        user.transfer_enable = app.config.get('USER_INIT_TRANSFER')
        user.service_enable = 1
        user.service_switch = 1
        db.session.commit()
        flash('Validate success. Please login!')
        return redirect(url_for('login'))


@app.route('/test')
def test():
    pass


@app.route('/logout', methods=['GET', 'POST'])
def logout():
    logout_user()
    return redirect(url_for('login'))


@app.route('/index')
@login_required
def index():
    return redirect(url_for('manage_page.dashboard'))


@login_manager.user_loader
def load_user(id):
    return User.query.get(int(id))


@app.before_request
def before_request():
    g.user = current_user
