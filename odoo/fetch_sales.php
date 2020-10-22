<?php

require_once('ripcord.php');
require_once('Odoo.php');
require_once('Sales.php');

$url = 'https://erp.medco.ie';
$db = 'medco12';
$username = 'info@medco.ie';
$password = 'Lismore';

//Doing Authenication of Odoo
$odoo = new Odoo($url, $db, $username, $password);
$uid = $odoo->login();

$order = new Sales($odoo);
echo json_encode($order->displaySaleOrder());