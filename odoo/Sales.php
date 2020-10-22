<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SalesManager
 *
 * @author root
 */
require_once('ripcord.php');
require_once('Odoo.php');

class Sales {

    var $odoo;

    public function __construct($odoo) {

        $this->odoo = $odoo;
    }

    function displaySaleOrder() {
        $models = ripcord::client($this->odoo->url . "/xmlrpc/2/object");

        $order = $models->execute_kw(
            $this->odoo->db, $this->odoo->user_id, 
            $this->odoo->password, 
            'sale.report', 
            'search_read', 
            array(
                array(
                    array('date', '>=', date('Y-m-d H:i:s', strtotime($_GET['start_date']))),
                    array('date', '<=', date('Y-m-d H:i:s', strtotime($_GET['end_date']))),
                )
            ), 
            array(
                'fields' => array(
                    'product_id',
                    'qty_invoiced',
                    'price_subtotal',
                    'qty_to_invoice',
                    'qty_delivered',
                    'price_total',
                    'date'
                )
            )

        );
        
        foreach($order as $k => $o)
        {
            $o['product_id'] = $o['product_id'][1];
            $order[$k] = $o;
        }
        
        return $order;
    }
}
