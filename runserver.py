#!/usr/bin/env python
# -*- coding: UTF-8 -*-
# author mengskysama

from web import app


if __name__ == '__main__':
    # app.run('0.0.0.0', 9005)
    app.run('0.0.0.0', 9006, debug=True)
