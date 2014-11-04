MakeDieSS
=========

front end for https://github.com/mengskysama/shadowsocks/tree/manyuser


导入 sql.sql

配置 function.php

```
$COOKIEEXPTIME = 3600 * 24;
$BASEURL = 'mdss.mengsky.net';
$mysql_host = '127.0.0.1';
$mysql_user = 'root';
$mysql_pass = 'nicaicai';
$mysql_db = 'shadowsocks';
$init_transfer = 1024 * 1024 * 1024;
$arr_server = array(
    array('uri' => 'http://mdss01.mengsky.net:80', 'key' => 'nicaicai', 'type' => 1)
    //,
    //array('uri'=>'http://mdss10.mengsky.net:80', 'key'=> 'nicaicai', 'type'=>1)
);
```

'arr_server'是一个API用来主动停止一个账号用来重置账号，没有就算了...
```
    def render_GET(self, request):
        retcode = 1
        retmsg = 'unknow err'
        if request.uri.startswith('/cmd/del_server'):
            while True:
                try:
                    if not 'key' in request.args or Config.REST_APIKEY != request.args['key'][0]:
                        retmsg = 'key error'
                        break
                    port = int(request.args['port'][0])
                    if ServerPool.get_instance().del_server(port) is True:
                        retcode = 0
                        retmsg = 'success'
                except Exception, e:
                    retmsg = str(e)
                finally:
                    break
```
