<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MShop
 * @subpackage Common
 */


namespace Aimeos\MShop\Common\Item\Address;


/**
 * Interface for provider common address DTO objects used by the shop.
 * @package MShop
 * @subpackage Common
 */
class Standard
	extends \Aimeos\MShop\Common\Item\Address\Base
	implements \Aimeos\MShop\Common\Item\Address\Iface, \Aimeos\MShop\Common\Item\Position\Iface
{
	private $prefix;


	/**
	 * Initializes the provider common address item object
	 *
	 * @param string $prefix Property prefix when converting to array
	 * @param array $values List of attributes that belong to the provider common address item
	 */
	public function __construct( $prefix, array $values = [] )
	{
		parent::__construct( $prefix, $values );

		$this->prefix = $prefix;
	}


	/**
	 * Returns the customer ID this address belongs to
	 *
	 * @return string Customer ID of the address
	 */
	public function getParentId()
	{
		return (string) $this->get( $this->prefix . 'parentid' );
	}


	/**
	 * Sets the new customer ID this address belongs to
	 *
	 * @param string $parentid New customer ID of the address
	 * @return \Aimeos\MShop\Common\Item\Address\Iface Common address item for chaining method calls
	 */
	public function setParentId( $parentid )
	{
		return $this->set( $this->prefix . 'parentid', (string) $parentid );
	}


	/**
	 * Returns the position of the address item.
	 *
	 * @return integer Position of the address item
	 */
	public function getPosition()
	{
		return (int) $this->get( $this->prefix . 'position' );
	}


	/**
	 * Sets the Position of the address item.
	 *
	 * @param integer $position Position of the address item
	 * @return \Aimeos\MShop\Common\Item\Address\Iface Common address item for chaining method calls
	 */
	public function setPosition( $position )
	{
		return $this->set( $this->prefix . 'position', (int) $position );
	}


	/*
	 * Sets the item values from the given array and removes that entries from the list
	 *
	 * @param array &$list Associative list of item keys and their values
	 * @param boolean True to set private properties too, false for public only
	 * @return \Aimeos\MShop\Common\Item\Address\Iface Address item for chaining method calls
	 */
	public function fromArray( array &$list, $private = false )
	{
		$item = parent::fromArray( $list, $private );

		foreach( $list as $key => $value )
		{
			switch( $key )
			{
				case $this->prefix . 'parentid': !$private ?: $item = $item->setParentId( $value ); break;
				case $this->prefix . 'position': $item = $item->setPosition( $value ); break;
				default: continue 2;
			}

			unset( $list[$key] );
		}

		return $item;
	}


	/**
	 * Returns the item values as array.
	 *
	 * @param boolean True to return private properties, false for public only
	 * @return array Associative list of item properties and their values
	 */
	public function toArray( $private = false )
	{
		$list = parent::toArray( $private );

		$list[$this->prefix . 'position'] = $this->getPosition();

		if( $private === true ) {
			$list[$this->prefix . 'parentid'] = $this->getParentId();
		}

		return $list;
	}

}
