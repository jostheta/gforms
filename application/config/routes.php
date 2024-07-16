<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Routes of the forms controller
$route['create'] = 'Forms/create';
$route['my_forms'] = 'Forms/my_forms';
$route['my_drafts'] = 'Forms/my_drafts';
$route['my_drafts'] = 'Forms/my_drafts/$1';
$route['forms/delete/(:num)'] = 'forms/delete_form/$1';
$route['forms/respond/(:num)'] = 'forms/respond/$1';
$route['responses'] = 'Forms/list_user_forms';
$route['edit_form/(:num)'] = 'Forms/edit_form/$1';



//Routes of the pages controller
$route['default_controller'] = 'Pages/view';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['pages'] = 'Pages/view';
$route['(:any)'] = 'Pages/view/$1';