<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Routes of the forms controller
$route['forms/create'] = 'Forms/create';



//Routes of the pages controller
$route['default_controller'] = 'Pages/view';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['pages'] = 'Pages/view';
$route['(:any)'] = 'Pages/view/$1';