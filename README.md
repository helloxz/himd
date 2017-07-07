# himd
Hi Markdown,一款在线Markdown编辑器，免费开源，简单适用。Hi Markdown前身是[Markdown-Temp](https://github.com/helloxz/Markdown-Temp)，最近学习CodeIgniter框架，于是使用CI完全重写。


### 关于开发
* 编辑器使用[SimpleMDE - Markdown Editor](https://github.com/sparksuite/simplemde-markdown-editor)
* 使用[HyperDow](https://github.com/SegmentFault/HyperDown)对Markdown进行渲染
* 前端使用了BootStrap
* 后端使用了CodeIgniter框架

### 部署与安装
1. 下载源码
2. 将`himd.sql`导入数据库
3. 修改数据库配置文件`application/config/database.php`
4. 可能还需要修改`application/config/config.php`指定Session文件路径
5. SMTP配置在`application/controllers/User.php`

如果您使用的Apache，请在.htaccess添加如下内容：
```
RewriteEngine on  
RewriteCond $1 !^(index\.php|images|static|robots\.txt)
RewriteRule ^(.*)$ /index.php/$1 [L]
```

如果使用的Nginx，添加如下配置到站点配置中：
```
location / {
                try_files $uri $uri/ /index.php?$query_string;
        }

location ~ \.(md|sql)$ {
   return 403;
   deny all;
}
```

### 已实现的功能
* 用户注册、登录
* 新增文档、修改、发布

### 正在开发的功能
* 管理员系统
* 文件导出功能（.md .html）
* 邀请好友功能

### 联系方式
* Blog:[xiaoz.me](https://www.xiaoz.me/)
* Q Q:337003006