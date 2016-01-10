#!/usr/bin/env python
# -*- coding: UTF-8 -*-
# author mengskysama

from wtforms import Form, BooleanField, TextField, PasswordField, validators, StringField, IntegerField


class FirmwareForm(Form):
    aptype_id = IntegerField('')
    firmware_version = StringField('')
    firmware_md5 = StringField('')
    firmware_url = StringField('')
    uboot_md5 = StringField('')
    uboot_url = StringField('')
    source_url = StringField('')
    kernel_md5 = StringField('')
    public_time = IntegerField('')
