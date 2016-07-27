# .env 配置项
APP_ENV不能为local，否则不发短信验证码  
关闭DEBUG才会显示通用错误页
```
APP_ENV=production
APP_DEBUG=false
```

# supervisor管理邮件队列

## 添加配置文件

/etc/supervisor/conf.d/orangeway_queue.conf

```
[program:orangeway-mail-queue]
process_name=%(program_name)s_%(process_num)02d  
command=php /source部署路径/artisan queue:work redis --queue=email --sleep=3 --tries=3 --daemon
autostart=true
autorestart=true
user=Web账户
numprocs=3
redirect_stderr=true
stdout_logfile=/var/log/supervisor/orangeway-mail-queue.log
```


## 启动队列

```
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start orangeway-mail-queue:*
```

## 每次更新

```
php /source部署路径/artisan queue:restart
```
##定时任务
```
php /source部署路径/artisan schedule:run
```
# nginx参考配置
```
server {
    listen       80;
    #没正式证书，不走https
    #listen       443 ssl;
    #域名
    server_name  www.orangeway.cn;

    #ssl_certificate /home/wangw/server.crt;
    #ssl_certificate_key /home/wangw/root.key;

    #ssl_session_cache shared:SSL:50m;
    #ssl_session_timeout 1d;
    #ssl_session_tickets off;
    #ssl_dhparam /home/wangw/dhparam.pem;
    #ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
    #ssl_ciphers 'ECDHE-ECDSA-CHACHA20-POLY1305:ECDHE-RSA-CHACHA20-POLY1305:ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES128-GCM-SHA256:DHE-RSA-AES256-GCM-SHA384:ECDHE-ECDSA-AES128-SHA256:ECDHE-RSA-AES128-SHA256:ECDHE-ECDSA-AES128-SHA:ECDHE-RSA-AES256-SHA384:ECDHE-RSA-AES128-SHA:ECDHE-ECDSA-AES256-SHA384:ECDHE-ECDSA-AES256-SHA:ECDHE-RSA-AES256-SHA:DHE-RSA-AES128-SHA256:DHE-RSA-AES128-SHA:DHE-RSA-AES256-SHA256:DHE-RSA-AES256-SHA:ECDHE-ECDSA-DES-CBC3-SHA:ECDHE-RSA-DES-CBC3-SHA:EDH-RSA-DES-CBC3-SHA:AES128-GCM-SHA256:AES256-GCM-SHA384:AES128-SHA256:AES256-SHA256:AES128-SHA:AES256-SHA:DES-CBC3-SHA:!DSS';
    #ssl_prefer_server_ciphers on;

	#ajax不走https不用设置跨域
    #add_header 'Access-Control-Allow-Origin' "$http_origin" always;
    #add_header 'Access-Control-Allow-Credentials' 'true' always;
    #add_header 'Access-Control-Allow-Methods' 'GET, POST, PUT, DELETE, OPTIONS' always;
    #add_header 'Access-Control-Allow-Headers' 'Accept,Authorization,Cache-Control,Content-Type,DNT,If-Modified-Since,Keep-Alive,Origin,User-Agent,X-Mx-ReqToken,X-Requested-With,X-CSRF-TOKEN' always;

	#部署路径
    root   /var/www/orangeway/02Source/public;

    location / {
        index  index.html index.htm index.php;
        try_files $uri $uri/ /index.php$is_args$query_string;
    }

    # pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
    #
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }

    # deny access to .htaccess files, if Apache's document root
    # concurs with nginx's one
    #
    location ~ /\.ht {
        deny  all;
    }
   error_log  /var/www/nginx/orangeway_error.log;
   access_log  /var/www/nginx/oangeway.com_access.log  main;
}

备注(需要搭建redis 127.0.0.1:6379)

数据库文件：orangeway2016_test.mod.sql
解压uploads.tar替换public/uploads

修改.env文件到正式的配置环境
