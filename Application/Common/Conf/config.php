<?php
return array(
    //'配置项'=>'配置值'
    'MODULE_ALLOW_LIST'    =>    array('Home','Admin'), //网站首页商户后台、管理后台、微信下单页
    'DEFAULT_MODULE'       =>    'Home',
    'URL_CASE_INSENSITIVE' =>true, //访问action 不区分大小写

    'MULTI_MODULE'          =>  true,
	//'配置项'=>'配置值'
    'URL_MODEL'             =>  '2',    //URL模式
	//数控信息
    'DB_TYPE'      =>  'mysql',                 // 数据库类型
    'DB_HOST'      =>  '120.27.188.126',        // 服务器地址
    'DB_NAME'      =>  'blog',           // 数据库名
    'DB_USER'      =>  'root',                  // 用户名
    'DB_PWD'       =>  'xiaopizi990!',                // 密码
    'DB_PORT'      =>  '3306',                  // 端口
    'DB_PREFIX'    =>  'blog_',                      // 数据库表前缀
    'DB_DSN'       =>  '',                      // 数据库连接DSN 用于PDO方式
    'DB_CHARSET'   =>  'utf8mb4',                  // 数据库的编码 默认为utf8
    'SITE_URL'     =>  'http://www.tandashui.com',
);

// location / {
//             #root   html;
//             index  index.html index.htm index.php;
//                  if (!-e $request_filename) {

//         rewrite  ^(.*)$  /index.php?s=$1  last;

//         break;

//     }
// }
