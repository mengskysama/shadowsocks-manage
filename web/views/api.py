#!/usr/bin/env python
# -*- coding: UTF-8 -*-
# author mengskysama

from flask import request, Blueprint
from web.models import Server
from web import db
import time


api = Blueprint('api', __name__, template_folder='templates', url_prefix='/api')



