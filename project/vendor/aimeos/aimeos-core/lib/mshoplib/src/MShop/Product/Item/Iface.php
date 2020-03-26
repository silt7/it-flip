<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MShop
 * @subpackage Product
 */


namespace Aimeos\MShop\Product\Item;


/**
 * Generic interface for product items created and saved by product managers.
 *
 * @package MShop
 * @subpackage Product
 */
interface Iface
	extends \Aimeos\MShop\Common\Item\Iface, \Aimeos\MShop\Common\Item\Config\Iface,
		\Aimeos\MShop\Common\Item\ListRef\Iface, \Aimeos\MShop\Common\Item\PropertyRef\Iface,
		\Aimeos\MShop\Common\Item\Status\Iface, \Aimeos\MShop\Common\Item\Time\Iface,
		\Aimeos\MShop\Common\Item\TypeRef\Iface
{
	/**
	 * Returns the catalog items referencing the product
	 *
	 * @return \Aimeos\Map Associative list of items implementing \Aimeos\MShop\Catalog\Item\Iface
	 */
	public function getCatalogItems();

	/**
	 * Returns the supplier items referencing the product
	 *
	 * @return \Aimeos\Map Associative list of items implementing \Aimeos\MShop\Supplier\Item\Iface
	 */
	public function getSupplierItems();

	/**
	 * Returns the stock items associated to the product
	 *
	 * @return \Aimeos\Map Associative list of items implementing \Aimeos\MShop\Stock\Item\Iface
	 */
	public function getStockItems();

	/**
	 * Returns the code of the product item.
	 *
	 * @return string Code of the product
	 */
	public function getCode();

	/**
	 * Sets a new code of the product item.
	 *
	 * @param string $code New code of the product item
	 * @return \Aimeos\MShop\Product\Item\Iface Product item for chaining method calls
	 */
	public function setCode( $code );

	/**
	 * Returns the data set name assigned to the product item.
	 *
	 * @return string Data set name
	 */
	public function getDataset();

	/**
	 * Sets a new data set name assignd to the product item.
	 *
	 * @param string $name New data set name
	 * @return \Aimeos\MShop\Product\Item\Iface Product item for chaining method calls
	 */
	public function setDataset( $name );

	/**
	 * Returns the label of the product item.
	 *
	 * @return string Label of the product item
	 */
	public function getLabel();

	/**
	 * Sets a new URL target specific for that product
	 *
	 * @param string $label New label of the product item
	 * @return \Aimeos\MShop\Product\Item\Iface Product item for chaining method calls
	 */
	public function setLabel( $label );

	/**
	 * Returns the URL target specific for that product
	 *
	 * @return string URL target specific for that product
	 */
	public function getTarget();

	/**
	 * Sets a new label of the product item.
	 *
	 * @param string $value New URL target specific for that product
	 * @return \Aimeos\MShop\Product\Item\Iface Product item for chaining method calls
	 */
	public function setTarget( $value );
}
