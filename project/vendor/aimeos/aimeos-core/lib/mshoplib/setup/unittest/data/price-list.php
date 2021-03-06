<?php
/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2012
 * @copyright Aimeos (aimeos.org), 2015-2018
 */

return array(
	'price/lists/type' => array(
		'customer/test' => array( 'domain' => 'customer', 'code' => 'test', 'label' => 'Standard', 'status' => 1 ),
		'product/default' => array( 'domain' => 'product', 'code' => 'default', 'label' => 'Standard', 'status' => 1 ),
	),

	'price/lists' => array(
		array( 'parentid' => 'price/attribute/default/99.99/9.99', 'type' => 'test', 'domain' => 'customer', 'refid' => 'customer/UTC001', 'start' => null, 'end' => null, 'config' => [], 'pos' => 1, 'status' => 1 ),
		array( 'parentid' => 'price/attribute/default/99.99/9.99', 'type' => 'test', 'domain' => 'customer', 'refid' => 'customer/UTC002', 'start' => null, 'end' => null, 'config' => [], 'pos' => 2, 'status' => 1 ),
		array( 'parentid' => 'price/attribute/default/99.99/9.99', 'type' => 'test', 'domain' => 'customer', 'refid' => 'customer/UTC003', 'start' => '2002-01-01 00:00:00', 'end' => '2006-12-31 23:59:59', 'config' => [], 'pos' => 3, 'status' => 1 ),
	)
);
