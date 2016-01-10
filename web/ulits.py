#!/usr/bin/env python
# -*- coding: UTF-8 -*-
# author mengskysama

import datetime
import re
import time
import hashlib


def md5(_str):
    m2 = hashlib.md5()
    m2.update(_str)
    return m2.hexdigest()


def get_timestamp():
    return str(int(time.time()))


def is_valid_mac(mac):
    allowed = re.compile('[0-9A-F]{12}', re.VERBOSE | re.IGNORECASE)
    if allowed.match(mac) is None:
        return False
    else:
        return True


def form2obj(form, obj, excludes=[]):
    fields = form.__dict__.get('_fields')
    for field in fields:
        if hasattr(obj, field) and field not in excludes:
            form_field = getattr(form, field, None)
            if form_field or form_field == 0:
                setattr(obj, field, form_field.data)


def obj2form(obj, form, excludes=[]):
    fields = form.__dict__.get("_fields")
    for field in fields:
        if hasattr(obj, field) and field not in excludes:
            obj_field = getattr(obj, field, None)
            form_field = getattr(form, field, None)
            if (obj_field or obj_field == 0) and form_field:
                setattr(form_field, 'data', obj_field)


def get_today_range():
    today = datetime.date.today()
    return get_day_range(today)


def get_day_range(today):
    dt_beg = datetime.datetime(today.year, today.month, today.day, 0, 0, 0)
    dt_end = datetime.datetime(today.year, today.month, today.day, 23, 59, 59)
    return dt_beg, dt_end
