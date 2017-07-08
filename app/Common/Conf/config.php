<?php
return array(

	'DOMAIN'=>$_SERVER['SERVER_NAME'],

	'DOMAIN_URL'=>'http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],'/')+1),

	'URL_HTML_SUFFIX'=>'html',	//伪静态后缀

	'URL_MODEL'  => 3,		    //URL模式：0 :普通模式 1 :PATHINFO 2 :REWRITE 3 :兼容模式

	'URL_PATHINFO_DEPR'=>'/',

	/********************************************伪静态路径配置**************************************/

	'URL_CASE_INSENSITIVE' =>true,// 默认false 表示URL区分大小写 true则表示不区分大小写

	//tp升级

	'LIST_ROWS'=>100,//后台数据每页显示记录数

	'VIP_LIST_ROWS'=>10,  

	'DB_TYPE'   => 'mysql', 	// 数据库类型

	

	'DB_HOST'   => '103.224.83.152', // 服务器地址

	'DB_NAME'   => 'ek',// 数据库名

	'DB_USER'   => 'ek',		// 用户名

	'DB_PWD'    => 'ek', 			// 密码

	'DB_PORT'   => '3306', 		// 端口

	'DB_PREFIX' => 'ez_', 		// 数据库表前缀

	'DEFAULT_MODULE'=>'Home', 



	/* nm数据库1 配置 */

	'DB_CONFIG1'  =>array(

    	'DB_TYPE' 	=> 'mysql', 

    	'DB_HOST' 	=> 'db..net',

    	'DB_NAME'   => 'baidulab_wx',	

    	'DB_USER' 	=> '', 

   		'DB_PWD' 	=> 'testuser01',

    	'DB_PORT'   => '3306',

        'DB_PREFIX' => 'tp_',

	),



	/* stat数据库2 配置 */

	'DB_CONFIG1'  =>array(

    	'DB_TYPE' 	=> 'mysql', 

    	'DB_HOST' 	=> 'db..net',

    	'DB_NAME'   => 'phpstat_analytics_web',	

    	'DB_USER' 	=> '', 

   		'DB_PWD' 	=> 'testuser01',

    	'DB_PORT'   => '3306',

        'DB_PREFIX' => 'phpstat_analytics_',

	),





	/* SESSION 和 COOKIE 配置 */

	'SESSION_PREFIX'=>'ez_',

	'COOKIE_PATH'=> '/',

	'DB_BACKUP'=>  '/',////////////////////////////////////////////////////////////////////////////////////////////////

	'COOKIE_PREFIX'=>'ez_',

	/* 模版 配置 */

	'TMPL_PARSE_STRING'  =>array(

    	'__PUBLIC__' 	=> __ROOT__ .'/Public', 	// 更改默认的/Public 替换规则

    	'__MOBILE__' 	=> __ROOT__ .'/Public/Mobile', 	// 更改默认的/Public 替换规则

   		'__JS__' 		=> __ROOT__ .'/Public/js',// 增加新的JS类库路径替换规则

    	'__UPLOAD__' 	=> __ROOT__ .'/Uploads', 	// 增加新的上传路径替换规则

    	'__STATIC__' => __ROOT__ . '/Public/static',

        '__ADDONS__' => __ROOT__ . '/Addons',

        '__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/images',

        '__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',

        '__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',

	),

	/* 加密 配置 */

	'DATA_AUTH_KEY'=>'lkjhgfdsa', //默认数据加密KEY

	'INVITE_CODE_KEY'=>'6515916',//默认邀请码加密KEY

	'ACCOUNT_SIGN_KEY'=>'sss2617727',//

	'ACCOUNT_TOKEN_KEY'=>'ttt2617727',//

	/* 分页相关配置 */

	'VAR_PAGE'        =>  'p',

	'PAGE'=>array(

		'theme'=>'%upPage% %linkPage% %downPage% %ajax%'

	),

	/* 自动加载相关配置 */

	'TAGLIB_PRE_LOAD'    =>    '',

	/* 权限相关配置 */

	'USER_AUTH_ON' => true,

	'USER_AUTH_TYPE' => 2,

	'USER_AUTH_KEY' => 'authId',

	'ADMIN_AUTH_KEY' => 'administrator',

	'USER_AUTH_MODEL' => 'User',

	'AUTH_PWD_ENCODER' => 'md5',

	'USER_AUTH_GATEWAY' => '/Admin/Login/index',

	'NOT_AUTH_MODULE' => 'Login,Public',

	'REQUIRE_AUTH_MODULE' => '',

	'NOT_AUTH_ACTION' => '',

	'REQUIRE_AUTH_ACTION' => '',

	'GUEST_AUTH_ON' => false,

	'GUEST_AUTH_ID' => 0,

	'RBAC_ROLE_TABLE' => 'ez_role',

	'RBAC_USER_TABLE' => 'ez_role_user',

	'RBAC_ACCESS_TABLE' => 'ez_access',

	'RBAC_NODE_TABLE' => 'ez_node',

	'SPECIAL_USER' => 'admin',





        'ZTR_DB_DATABASE'	=> 	'baidulab_zhan',//数据库地址

        'ZTR_DB_HOST'	=> 	'172.16.0.8',//数据库用户名

	'ZTR_DB_USER'	=> 	'dbtest',//数据库用户名

	'ZTR_DB_PASSWD' => 	'testuser01',//数据库密码

//	'ZTR_DB_PREFIX'	=> 	'site_',//新建数据库的前缀

	//导入数据库内容的全路径

	'ZTR_SQL_FILE_PATH'	=> '/websitesrc/www.sql',//导入数据库表中数据的全路径

	'ZTR_SITE_SOURCE_PATH'	=> 	'/websitesrc/www/',//模板站点的目录，全路径,以/符号结尾

	'ZTR_SITE_TARGET_PATH'	=> 	'/wwwroot/autowebsites/',//新建站点的目标目录，全路径，以/符号结尾

//最终新建站点的目录为：SITE_TARGET_PATH+输入的新建站点域名的第3级子域名去掉最后三位编码+输入的新建站点域名的第3级子域名，例如，最终结果为：/home/wwwroot/beijing/beijing001

	//'ZTR_DB_SOURCE_NAME'	=> 	'www',

	'ZTR_DB_CONFIG_PATH'	=> 	'config/database.php',

	'ZTR_SITE_CONFIG_PATH'	=> 	'config/site/1.php',

	'ZTR_DOMAIN_PATH'	=> 'config/domain.php',//修改此文件，把原来的域名，替换为新输入的域名，例如：把free.myweb.com替换为beijing001.baidu.com



	//oss配置 
   "OSS_ACCESS_ID" => 'LTAIVMFGWvcm8nzP', 
   "OSS_ACCESS_KEY"=> 'pgx2KbRx8YXtvuqAmHwotT7wL2hGEx', 
   "OSS_ENDPOINT"  => 'jishanstore-upload.oss-cn-beijing.aliyuncs.com', 
   "OSS_TEST_BUCKET" => 'jishanstore-upload', 
   "OSS_WEB_SITE" =>'img.zhangtengrui.com',    //上面4个就不用介绍了，这个OSS_WEB_SITE是oss的bucket创建后的外网访问地址，如需二级域名，可以指向二级域名，具体可以参考阿里云控制台里面的oss  
    
   //oss文件上传配置 
   'oss_maxSize'=>1048576,    //1M 
   'oss_exts'   =>array(// 设置附件上传类型    
       'image/jpg',  
       'image/gif',  
       'image/png',  
       'image/jpeg', 
       'application/octet-stream'//阿里云好像都是通过二进制上传，似乎上面4个后缀设置起到什么用？  
   ),



    //腾讯QQ登录配置
	'THINK_SDK_QQ' => array(
		'APP_KEY' => '101403635', //应用注册成功后分配的 APP ID
		'APP_SECRET' => '87b6d5cdb642cf804cd6b7ff2091a3eb', //应用注册成功后分配的KEY
		'CALLBACK' => 'http://ek.zhangtengrui.com/index.php?s=/Home/Index/callback.html&type=qq',
	),

);

?>

