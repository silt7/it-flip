<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018
 * @package MShop
 * @subpackage Common
 */


namespace Aimeos\MShop\Common\Manager\Decorator;


/**
 * Provides a decorator for limiting recursive searches
 *
 * @package MShop
 * @subpackage Common
 */
class Depth
	extends \Aimeos\MShop\Common\Manager\Decorator\Base
{
	private $level = 0;


	/**
	 * Searches for all items matching the given critera.
	 *
	 * @param \Aimeos\MW\Criteria\Iface $search Criteria object with conditions, sortations, etc.
	 * @param string[] $ref List of domains to fetch list items and referenced items for
	 * @param integer &$total Number of items that are available in total
	 * @return \Aimeos\MShop\Common\Item\Iface[] List of items
	 */
	public function searchItems( \Aimeos\MW\Criteria\Iface $search, array $ref = [], &$total = null )
	{
		$items = [];

		try
		{
			/** mshop/common/manager/maxdepth
			 * Maximum level of recursion for retrieving referenced items
			 *
			 * Searching for items also fetches the associated items referenced in the
			 * list tables if the domain names are passed to the second parameter of e.g. the
			 * searchItems() method. To avoid infinite recursion because two items reference
			 * each other, the maximum level must be limited.
			 *
			 * The default setting (two levels) means that retrieving a product item with
			 * sub-products will retrieve the directly associated products but not the
			 * products referenced by the associated product for example.
			 *
			 * @param integer Number of levels
			 * @since 2019.04
			 * @category Developer
			 */
			$max = $this->getContext()->getConfig()->get( 'mshop/common/manager/maxdepth', 2 );

			if( $this->level++ < $max ) {
				$items = $this->getManager()->searchItems( $search, $ref, $total );
			}

			$this->level--;
		}
		catch( \Exception $e )
		{
			$this->level--;
			throw $e;
		}

		return $items;
	}
}
