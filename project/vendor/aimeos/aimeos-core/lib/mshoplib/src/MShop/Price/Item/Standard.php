<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MShop
 * @subpackage Price
 */


namespace Aimeos\MShop\Price\Item;


/**
 * Default implementation of a price object.
 *
 * @package MShop
 * @subpackage Price
 */
class Standard extends Base
{
	private $currencyid;
	private $precision;
	private $tax;


	/**
	 * Initalizes the object with the given values
	 *
	 * @param array $values Associative array of key/value pairs for price, costs, rebate and currencyid
	 * @param \Aimeos\MShop\Common\Item\Lists\Iface[] $listItems List of list items
	 * @param \Aimeos\MShop\Common\Item\Iface[] $refItems List of referenced items
	 * @param \Aimeos\MShop\Common\Item\Property\Iface[] $propItems List of property items
	 */
	public function __construct( array $values = [], array $listItems = [], array $refItems = [], array $propItems = [] )
	{
		parent::__construct( 'price.', $values, $listItems, $refItems, $propItems );

		$this->currencyid = ( isset( $values['.currencyid'] ) ? $values['.currencyid'] : null );
		$this->precision = ( isset( $values['.precision'] ) ? $values['.precision'] : 2 );
		$this->tax = $this->get( 'price.taxvalue' );
	}


	/**
	 * Returns the type of the price.
	 *
	 * @return string|null Type of the price
	 */
	public function getType()
	{
		return $this->get( 'price.type' );
	}


	/**
	 * Sets the new type of the price.
	 *
	 * @param string $type Type of the price
	 * @return \Aimeos\MShop\Price\Item\Iface Price item for chaining method calls
	 */
	public function setType( $type )
	{
		return $this->set( 'price.type', $this->checkCode( $type ) );
	}


	/**
	 * Returns the currency ID.
	 *
	 * @return string|null Three letter ISO currency code (e.g. EUR)
	 */
	public function getCurrencyId()
	{
		return $this->get( 'price.currencyid' );
	}


	/**
	 * Sets the used currency ID.
	 *
	 * @param string $currencyid Three letter currency code
	 * @return \Aimeos\MShop\Price\Item\Iface Price item for chaining method calls
	 * @throws \Aimeos\MShop\Exception If the language ID is invalid
	 */
	public function setCurrencyId( $currencyid )
	{
		return $this->set( 'price.currencyid', $this->checkCurrencyId( $currencyid, false ) );
	}


	/**
	 * Returns the domain the price is valid for.
	 *
	 * @return string Domain name
	 */
	public function getDomain()
	{
		return (string) $this->get( 'price.domain', '' );
	}


	/**
	 * Sets the new domain the price is valid for.
	 *
	 * @param string $domain Domain name
	 * @return \Aimeos\MShop\Price\Item\Iface Price item for chaining method calls
	 */
	public function setDomain( $domain )
	{
		return $this->set( 'price.domain', (string) $domain );
	}


	/**
	 * Returns the label of the item
	 *
	 * @return string Label of the item
	 */
	public function getLabel()
	{
		return (string) $this->get( 'price.label', '' );
	}


	/**
	 * Sets the label of the item
	 *
	 * @param string $label Label of the item
	 * @return \Aimeos\MShop\Price\Item\Iface Price item for chaining method calls
	 */
	public function setLabel( $label )
	{
		return $this->set( 'price.label', (string) $label );
	}


	/**
	 * Returns the quantity the price is valid for.
	 *
	 * @return integer Quantity
	 */
	public function getQuantity()
	{
		return (int) $this->get( 'price.quantity', 1 );
	}


	/**
	 * Sets the quantity the price is valid for.
	 *
	 * @param integer $quantity Quantity
	 * @return \Aimeos\MShop\Price\Item\Iface Price item for chaining method calls
	 */
	public function setQuantity( $quantity )
	{
		return $this->set( 'price.quantity', (int) $quantity );
	}


	/**
	 * Returns the amount of money.
	 *
	 * @return string Price value
	 */
	public function getValue()
	{
		return (string) $this->get( 'price.value', '0.00' );
	}


	/**
	 * Sets the new amount of money.
	 *
	 * @param string|integer|double $price Amount with two digits precision
	 * @return \Aimeos\MShop\Price\Item\Iface Price item for chaining method calls
	 */
	public function setValue( $price )
	{
		return $this->set( 'price.value', $this->checkPrice( $price ) );
	}


	/**
	 * Returns costs.
	 *
	 * @return string Costs
	 */
	public function getCosts()
	{
		return (string) $this->get( 'price.costs', '0.00' );
	}


	/**
	 * Sets the new costs.
	 *
	 * @param string|integer|double $price Amount with two digits precision
	 * @return \Aimeos\MShop\Price\Item\Iface Price item for chaining method calls
	 */
	public function setCosts( $price )
	{
		return $this->set( 'price.costs', $this->checkPrice( $price ) );
	}


	/**
	 * Returns the rebate amount.
	 *
	 * @return string Rebate amount
	 */
	public function getRebate()
	{
		return (string) $this->get( 'price.rebate', '0.00' );
	}


	/**
	 * Sets the new rebate amount.
	 *
	 * @param string|integer|double $price Rebate amount with two digits precision
	 * @return \Aimeos\MShop\Price\Item\Iface Price item for chaining method calls
	 */
	public function setRebate( $price )
	{
		return $this->set( 'price.rebate', $this->checkPrice( $price ) );
	}


	/**
	 * Returns the tax rate
	 *
	 * @return string Tax rate
	 */
	public function getTaxRate()
	{
		$list = (array) $this->get( 'price.taxrates', [] );
		return ( isset( $list[''] ) ? (string) $list[''] : '0.00' );
	}


	/**
	 * Returns all tax rates in percent.
	 *
	 * @return string[] Tax rates for the price
	 */
	 public function getTaxRates()
	 {
		return (array) $this->get( 'price.taxrates', [] );
	 }


	/**
	 * Sets the new tax rate.
	 *
	 * @param string|integer|double $taxrate Tax rate with two digits precision
	 * @return \Aimeos\MShop\Price\Item\Iface Price item for chaining method calls
	 */
	public function setTaxRate( $taxrate )
	{
		return $this->setTaxRates( ['' => $taxrate] );
	}


	/**
	 * Sets the new tax rates in percent
	 *
	 * @param array $taxrates Tax rates with name as key and values with two digits precision
	 * @return \Aimeos\MShop\Price\Item\Iface Price item for chaining method calls
	 */
	public function setTaxRates( array $taxrates )
	{
		foreach( $taxrates as $name => $taxrate )
		{
			unset( $taxrates[$name] ); // change index 0 to ''
			$taxrates[$name ?: ''] = $this->checkPrice( $taxrate );
		}

		return $this->set( 'price.taxrates', $taxrates );
	}


	/**
	 * Returns the tax rate flag.
	 *
	 * True if tax is included in the price value, costs and rebate, false if not
	 *
	 * @return boolean Tax rate flag for the price
	 */
	public function getTaxFlag()
	{
		return (bool) $this->get( 'price.taxflag', true );
	}


	/**
	 * Sets the new tax flag.
	 *
	 * @param boolean $flag True if tax is included in the price value, costs and rebate, false if not
	 * @return \Aimeos\MShop\Price\Item\Iface Price item for chaining method calls
	*/
	public function setTaxFlag( $flag )
	{
		return $this->set( 'price.taxflag', (bool) $flag );
	}


	/**
	 * Returns the tax for the price item
	 *
	 * @return string Tax value with four digits precision
	 * @see mshop/price/taxflag
	 */
	public function getTaxValue()
	{
		if( $this->tax === null )
		{
			$taxrate = array_sum( $this->getTaxRates() );

			if( $this->getTaxFlag() !== false ) {
				$tax = ( $this->getValue() + $this->getCosts() ) / ( 100 + $taxrate ) * $taxrate;
			} else {
				$tax = ( $this->getValue() + $this->getCosts() ) * $taxrate / 100;
			}

			$this->tax = $this->formatNumber( $tax, $this->precision + 2 );
			parent::setModified();
		}

		return $this->tax;
	}


	/**
	 * Sets the tax amount
	 *
	 * @param string|integer|double $value Tax value with up to four digits precision
	 */
	public function setTaxValue( $value )
	{
		$this->tax = $this->checkPrice( $value, $this->precision + 2 );
		parent::setModified();
		return $this;
	}


	/**
	 * Returns the status of the item
	 *
	 * @return integer Status of the item
	 */
	public function getStatus()
	{
		return (int) $this->get( 'price.status', 1 );
	}


	/**
	 * Sets the status of the item
	 *
	 * @param integer $status Status of the item
	 * @return \Aimeos\MShop\Price\Item\Iface Price item for chaining method calls
	 */
	public function setStatus( $status )
	{
		return $this->set( 'price.status', (int) $status );
	}


	/**
	 * Sets the modified flag of the object.
	 *
	 * @return \Aimeos\MShop\Price\Item\Iface Price item for chaining method calls
	 */
	public function setModified()
	{
		$this->tax = null;
		return parent::setModified();
	}


	/**
	 * Tests if the item is available based on status, time, language and currency
	 *
	 * @return boolean True if available, false if not
	 */
	public function isAvailable()
	{
		return parent::isAvailable() && $this->getStatus() > 0
			&& ( $this->currencyid === null || $this->getCurrencyId() === $this->currencyid );
	}


	/**
	 * Add the given price to the current one.
	 *
	 * @param \Aimeos\MShop\Price\Item\Iface $item Price item which should be added
	 * @param integer $quantity Number of times the Price should be added
	 * @return \Aimeos\MShop\Price\Item\Iface Price item for chaining method calls
	 */
	public function addItem( \Aimeos\MShop\Price\Item\Iface $item, $quantity = 1 )
	{
		if( $item->getCurrencyId() != $this->getCurrencyId() )
		{
			$msg = 'Price can not be added. Currency ID "%1$s" of price item and currently used currency ID "%2$s" does not match.';
			throw new \Aimeos\MShop\Price\Exception( sprintf( $msg, $item->getCurrencyId(), $this->getCurrencyId() ) );
		}

		if( $this === $item ) { $item = clone $item; }
		$taxValue = $this->getTaxValue(); // use initial value before it gets reset

		$this->setQuantity( 1 );
		$this->setValue( $this->getValue() + $item->getValue() * $quantity );
		$this->setCosts( $this->getCosts() + $item->getCosts() * $quantity );
		$this->setRebate( $this->getRebate() + $item->getRebate() * $quantity );
		$this->setTaxValue( $taxValue + $item->getTaxValue() * $quantity );

		return $this;
	}


	/**
	 * Resets the values of the price item.
	 * The currency ID, domain, type and status stays the same.
	 *
	 * @return \Aimeos\MShop\Price\Item\Iface Price item for chaining method calls
	 */
	public function clear()
	{
		$this->setQuantity( 1 );
		$this->setValue( '0.00' );
		$this->setCosts( '0.00' );
		$this->setRebate( '0.00' );
		$this->setTaxRate( '0.00' );
		$this->tax = null;

		return $this;
	}


	/*
	 * Sets the item values from the given array and removes that entries from the list
	 *
	 * @param array &$list Associative list of item keys and their values
	 * @param boolean True to set private properties too, false for public only
	 * @return \Aimeos\MShop\Price\Item\Iface Price item for chaining method calls
	 */
	public function fromArray( array &$list, $private = false )
	{
		$item = parent::fromArray( $list, $private );

		foreach( $list as $key => $value )
		{
			switch( $key )
			{
				case 'price.type': $item = $item->setType( $value ); break;
				case 'price.currencyid': $item = $item->setCurrencyId( $value ); break;
				case 'price.domain': $item = $item->setDomain( $value ); break;
				case 'price.quantity': $item = $item->setQuantity( $value ); break;
				case 'price.value': $item = $item->setValue( $value ); break;
				case 'price.costs': $item = $item->setCosts( $value ); break;
				case 'price.rebate': $item = $item->setRebate( $value ); break;
				case 'price.taxvalue': $item = $item->setTaxValue( $value ); break;
				case 'price.taxrates': $item = $item->setTaxRates( (array) $value ); break;
				case 'price.taxrate': $item = $item->setTaxRate( $value ); break;
				case 'price.taxflag': $item = $item->setTaxFlag( $value ); break;
				case 'price.status': $item = $item->setStatus( $value ); break;
				case 'price.label': $item = $item->setLabel( $value ); break;
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

		$list['price.type'] = $this->getType();
		$list['price.currencyid'] = $this->getCurrencyId();
		$list['price.domain'] = $this->getDomain();
		$list['price.quantity'] = $this->getQuantity();
		$list['price.value'] = $this->getValue();
		$list['price.costs'] = $this->getCosts();
		$list['price.rebate'] = $this->getRebate();
		$list['price.taxvalue'] = $this->getTaxValue();
		$list['price.taxrates'] = $this->getTaxRates();
		$list['price.taxrate'] = $this->getTaxRate();
		$list['price.taxflag'] = $this->getTaxFlag();
		$list['price.status'] = $this->getStatus();
		$list['price.label'] = $this->getLabel();

		return $list;
	}
}
