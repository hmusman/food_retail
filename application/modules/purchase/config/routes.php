<?php
defined('BASEPATH') OR exit('No direct script access allowed');



$route['add_purchase']         = "purchase/purchase/bdtask_purchase_form";
$route['purchase_list']        = "purchase/purchase/bdtask_purchase_list";
$route['purchase_details/(:num)'] = 'purchase/purchase/bdtask_purchase_details/$1';
$route['purchase_edit/(:num)'] = 'purchase/purchase/bdtask_purchase_edit_form/$1';

// receipe_form
$route['receipe_form'] = 'purchase/purchase/receipe_form';
$route['receipe_manage'] = 'purchase/purchase/receipe_manage';
$route['del_receipe'] = 'purchase/purchase/del_receipe/$1';
$route['edit_receipe'] = 'purchase/purchase/edit_receipe/$1';


