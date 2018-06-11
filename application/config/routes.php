<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/* Home 首页 */
$route['gateway'] = 'home/gateway'; // 路由页属于首页类
$route['home'] = 'home/index'; // 首页

/* Account 账号 */
$route['login'] = 'account/login'; // 密码登录
$route['login_sms'] = 'account/login_sms'; // 短信登录/注册
$route['register'] = 'account/register'; // 邮箱注册
$route['logout'] = 'account/logout'; // 退出当前账号
$route['password_set'] = 'account/password_set'; // 设置密码（仅限登录后）
$route['password_reset'] = 'account/password_reset'; // 重置密码（仅限登录前）
$route['password_change'] = 'account/password_change'; // 修改密码（仅限登录后）
$route['email_reset'] = 'account/email_reset'; // 换绑Email（仅限登录后）
$route['mobile_reset'] = 'account/mobile_reset'; // 换绑手机号（仅限登录后）
$route['account/edit'] = 'account/edit'; // 编辑账户资料
$route['mine'] = 'user/mine'; // 个人中心（仅限登录后）

/* 以下按控制器类名称字母降序排列 */
/* Article 平台文章 */
$route['contact-us'] = 'article/detail/contact-us'; // 联系我们
$route['policy-privacy'] = 'article/detail/policy-privacy'; // 协议-隐私协议
$route['article/detail'] = 'article/detail';
$route['article/(:any)'] = 'article/detail/$1';
$route['article'] = 'article/index';
/* Article 商家文章 */
$route['article_biz/detail'] = 'article_biz/detail';
$route['article_biz'] = 'article_biz/index';

/* 商品分类 */
$route['item/category'] = 'item_category/index';
$route['item_category/(:any)'] = 'item_category/detail/$1';
$route['item_category'] = 'item_category/index';

/* 商品 */
$route['item/detail'] = 'item/detail';
$route['item/(:any)'] = 'item/detail/$1';
$route['item'] = 'item/index';

/* 商家 */
$route['biz/detail'] = 'biz/detail';
$route['biz/(:any)'] = 'biz/detail/$1';
$route['biz'] = 'biz/index';

$route['default_controller'] = 'home/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE; // 将路径中的“-”解析为“_”，兼顾SEO需要与类命名规范

/* End of file routes.php */
/* Location: ./application/config/routes.php */