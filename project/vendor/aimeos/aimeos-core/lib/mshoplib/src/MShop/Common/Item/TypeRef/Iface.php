<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018
 * @package MShop
 * @subpackage Common
 */


namespace Aimeos\MShop\Common\Item\TypeRef;


/**
 * Common interface for items having types.
 *
 * @package MShop
 * @subpackage Common
 */
interface Iface
{
	/**
	 * Returns the type of the item.
	 *
	 * @return string|null Type of the item
	 */
	public function getType();

	/**
	 * Sets the new type of the item.
	 *
	 * @param string $type Type of the item
	 * @return \Aimeos\MShop\Common\Item\Iface Item for chaining method calls
	 */
	public function setType( $type );
}
