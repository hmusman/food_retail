<?php
defined('BASEPATH') OR exit('No direct script access allowed');



$route['add_purchase_order']         = "warehouse/warehouse/add_purchase_order";
$route['purchase_order_list']        = "warehouse/warehouse/purchase_order_list";
$route['po_details/(:num)'] = 'warehouse/warehouse/purchase_order_details/$1';
$route['po_edit/(:num)'] = 'warehouse/warehouse/bdtask_purchase_order_edit_form/$1';

