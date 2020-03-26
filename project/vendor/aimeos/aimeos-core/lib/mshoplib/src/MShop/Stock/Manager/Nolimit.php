<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018
 * @package MShop
 * @subpackage Stock
 */


namespace Aimeos\MShop\Stock\Manager;


/**
 * Stock manager implementation for unlimited stocks
 *
 * @package MShop
 * @subpackage Stock
 */
class Nolimit
	extends \Aimeos\MShop\Stock\Manager\Standard
	implements \Aimeos\MShop\Stock\Manager\Iface, \Aimeos\MShop\Common\Manager\Factory\Iface
{
	/**
	 * Removes old entries from the storage.
	 *
	 * @param string[] $siteids List of IDs for sites whose entries should be deleted
	 * @return \Aimeos\MShop\Stock\Manager\Iface Manager object for chaining method calls
	 */
	public function cleanup( array $siteids )
	{
		return $this;
	}


	/**
	 * Returns the item specified by its code and domain/type
	 *
	 * @param string $code Code of the item
	 * @param string[] $ref List of domains to fetch list items and referenced items for
	 * @param string|null $domain Domain of the item if necessary to identify the item uniquely
	 * @param string|null $type Type code of the item if necessary to identify the item uniquely
	 * @param boolean $default True to add default criteria
	 * @return \Aimeos\MShop\Common\Item\Iface Item object
	 */
	public function findItem( $code, array $ref = [], $domain = null, $type = null, $default = false )
	{
		$values = ['stock.productcode' => $code, 'stock.type' => $type];
		return $this->getObject()->createItem( $values );
	}


	/**
	 * Inserts the new stock item
	 *
	 * @param \Aimeos\MShop\Stock\Item\Iface $item Stock item which should be saved
	 * @param boolean $fetch True if the new ID should be returned in the item
	 * @return \Aimeos\MShop\Stock\Item\Iface Updated item including the generated ID
	 */
	public function saveItem( \Aimeos\MShop\Common\Item\Iface $item, $fetch = true )
	{
		return $item;
	}


	/**
	 * Removes multiple items specified by ids in the array.
	 *
	 * @param string[] $ids List of IDs
	 * @return \Aimeos\MShop\Stock\Manager\Iface Manager object for chaining method calls
	 */
	public function deleteItems( array $ids )
	{
		return $this;
	}


	/**
	 * Creates a stock item object for the given item id.
	 *
	 * @param string $id Id of the stock item
	 * @param string[] $ref List of domains to fetch list items and referenced items for
	 * @param boolean $default Add default criteria
	 * @return \Aimeos\MShop\Stock\Item\Iface Returns the product stock item of the given id
	 * @throws \Aimeos\MShop\Exception If item couldn't be found
	 */
	public function getItem( $id, array $ref = [], $default = false )
	{
		$values = ['stock.id' => $id, 'stock.type' => 'default'];
		return $this->getObject()->createItem( $values );
	}


	/**
	 * Search for stock items based on the given critera.
	 *
	 * @param \Aimeos\MW\Criteria\Iface $search Search criteria object
	 * @param string[] $ref List of domains to fetch list items and referenced items for
	 * @param integer|null &$total Number of items that are available in total
	 * @return \Aimeos\MShop\Stock\Item\Iface[] List of stock items
	 */
	public function searchItems( \Aimeos\MW\Criteria\Iface $search, array $ref = [], &$total = null )
	{
		$items = [];
		$item = $this->getObject()->createItem( ['stock.type' => 'default'] );

		foreach( $this->getProductCodes( $search->getConditions() ) as $idx => $code )
		{
			$sitem = clone $item;
			$items[$idx] = $sitem->setProductCode( $code )->setId( $idx );
		}

		if( $total !== null ) {
			$total = count( $items );
		}

		return array_splice( $items, 0, $search->getSliceSize() );
	}


	/**
	 * Decreases the stock level for the given product codes/quantity pairs and type
	 *
	 * @param array $codeqty Associative list of product codes as keys and quantities as values
	 * @param string $type Unique code of the stock type
	 * @return \Aimeos\MShop\Stock\Manager\Iface Manager object for chaining method calls
	 */
	public function decrease( array $codeqty, $type = 'default' )
	{
		return $this;
	}


	/**
	 * Increases the stock level for the given product codes/quantity pairs and type
	 *
	 * @param array $codeqty Associative list of product codes as keys and quantities as values
	 * @param string $type Unique code of the type
	 * @return \Aimeos\MShop\Stock\Manager\Iface Manager object for chaining method calls
	 */
	public function increase( array $codeqty, $type = 'default' )
	{
		return $this;
	}


	/**
	 * Returns the product codes from the conditions
	 *
	 * @param \Aimeos\MW\Criteria\Expression\Iface $cond Criteria object
	 * @return string[] List of product codes
	 */
	protected function getProductCodes( \Aimeos\MW\Criteria\Expression\Iface $cond )
	{
		$list = [];

		if( $cond instanceof \Aimeos\MW\Criteria\Expression\Combine\Iface )
		{
			foreach( $cond->getExpressions() as $expr ) {
				$list = array_merge( $list, $this->getProductCodes( $expr ) );
			}
		}
		elseif( $cond instanceof \Aimeos\MW\Criteria\Expression\Compare\Iface )
		{
			if( $cond->getName() === 'stock.productcode' && $cond->getOperator() === '==' ) {
				$list = array_merge( $list, (array) $cond->getValue() );
			}
		}

		return $list;
	}
}
