<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2020
 * @package Admin
 * @subpackage JQAdm
 */


namespace Aimeos\Admin\JQAdm\Product\Supplier;

sprintf( 'supplier' ); // for translation


/**
 * Default implementation of product supplier JQAdm client.
 *
 * @package Admin
 * @subpackage JQAdm
 */
class Standard
	extends \Aimeos\Admin\JQAdm\Common\Admin\Factory\Base
	implements \Aimeos\Admin\JQAdm\Common\Admin\Factory\Iface
{
	/** admin/jqadm/product/supplier/name
	 * Name of the supplier subpart used by the JQAdm product implementation
	 *
	 * Use "Myname" if your class is named "\Aimeos\Admin\Jqadm\Product\Supplier\Myname".
	 * The name is case-sensitive and you should avoid camel case names like "MyName".
	 *
	 * @param string Last part of the JQAdm class name
	 * @since 2020.04
	 * @supplier Developer
	 */


	/**
	 * Copies a resource
	 *
	 * @return string|null HTML output
	 */
	public function copy()
	{
		$view = $this->getView();

		$view->supplierData = $this->toArray( $view->item, true );
		$view->supplierBody = '';

		foreach( $this->getSubClients() as $client ) {
			$view->supplierBody .= $client->copy();
		}

		return $this->render( $view );
	}


	/**
	 * Creates a new resource
	 *
	 * @return string|null HTML output
	 */
	public function create()
	{
		$view = $this->getView();
		$siteid = $this->getContext()->getLocale()->getSiteId();
		$data = $view->param( 'supplier', [] );

		foreach( $view->value( $data, 'supplier.lists.id', [] ) as $idx => $value ) {
			$data['supplier.lists.siteid'][$idx] = $siteid;
		}

		$view->supplierData = $data;
		$view->supplierBody = '';

		foreach( $this->getSubClients() as $client ) {
			$view->supplierBody .= $client->create();
		}

		return $this->render( $view );
	}


	/**
	 * Deletes a resource
	 *
	 * @return string|null HTML output
	 */
	public function delete()
	{
		$view = $this->getView();

		$manager = \Aimeos\MShop::create( $this->getContext(), 'supplier/lists' );

		$search = $manager->createSearch();
		$expr = array(
			$search->compare( '==', 'supplier.lists.refid', $view->param( 'id' ) ),
			$search->compare( '==', 'supplier.lists.domain', 'product' )
		);
		$search->setConditions( $search->combine( '&&', $expr ) );
		$search->setSlice( 0, 0x7fffffff );

		$start = 0;

		do
		{
			$search->setSlice( $start );

			$result = $manager->searchItems( $search );
			$manager->deleteItems( $result );

			$count = count( $result );
			$start += $count;
		}
		while( $count >= $search->getSliceSize() );

		return null;
	}


	/**
	 * Returns a single resource
	 *
	 * @return string|null HTML output
	 */
	public function get()
	{
		$view = $this->getView();
		$view->supplierData = $this->toArray( $view->item );
		$view->supplierBody = '';

		foreach( $this->getSubClients() as $client ) {
			$view->supplierBody .= $client->get();
		}

		return $this->render( $view );
	}


	/**
	 * Saves the data
	 *
	 * @return string|null HTML output
	 */
	public function save()
	{
		$view = $this->getView();

		$manager = \Aimeos\MShop::create( $this->getContext(), 'supplier/lists' );
		$manager->begin();

		try
		{
			$this->fromArray( $view->item, $view->param( 'supplier', [] ) );
			$view->supplierBody = '';

			foreach( $this->getSubClients() as $client ) {
				$view->supplierBody .= $client->save();
			}

			$manager->commit();
		}
		catch( \Exception $e )
		{
			$manager->rollback();
			throw $e;
		}

		return null;
	}


	/**
	 * Returns the sub-client given by its name.
	 *
	 * @param string $type Name of the client type
	 * @param string|null $name Name of the sub-client (Default if null)
	 * @return \Aimeos\Admin\JQAdm\Iface Sub-client object
	 */
	public function getSubClient( $type, $name = null )
	{
		/** admin/jqadm/product/supplier/decorators/excludes
		 * Excludes decorators added by the "common" option from the product JQAdm client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to remove a decorator added via
		 * "admin/jqadm/common/decorators/default" before they are wrapped
		 * around the JQAdm client.
		 *
		 *  admin/jqadm/product/supplier/decorators/excludes = array( 'decorator1' )
		 *
		 * This would remove the decorator named "decorator1" from the list of
		 * common decorators ("\Aimeos\Admin\JQAdm\Common\Decorator\*") added via
		 * "admin/jqadm/common/decorators/default" to the JQAdm client.
		 *
		 * @param array List of decorator names
		 * @since 2020.04
		 * @supplier Developer
		 * @see admin/jqadm/common/decorators/default
		 * @see admin/jqadm/product/supplier/decorators/global
		 * @see admin/jqadm/product/supplier/decorators/local
		 */

		/** admin/jqadm/product/supplier/decorators/global
		 * Adds a list of globally available decorators only to the product JQAdm client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap global decorators
		 * ("\Aimeos\Admin\JQAdm\Common\Decorator\*") around the JQAdm client.
		 *
		 *  admin/jqadm/product/supplier/decorators/global = array( 'decorator1' )
		 *
		 * This would add the decorator named "decorator1" defined by
		 * "\Aimeos\Admin\JQAdm\Common\Decorator\Decorator1" only to the JQAdm client.
		 *
		 * @param array List of decorator names
		 * @since 2020.04
		 * @supplier Developer
		 * @see admin/jqadm/common/decorators/default
		 * @see admin/jqadm/product/supplier/decorators/excludes
		 * @see admin/jqadm/product/supplier/decorators/local
		 */

		/** admin/jqadm/product/supplier/decorators/local
		 * Adds a list of local decorators only to the product JQAdm client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap local decorators
		 * ("\Aimeos\Admin\JQAdm\Product\Decorator\*") around the JQAdm client.
		 *
		 *  admin/jqadm/product/supplier/decorators/local = array( 'decorator2' )
		 *
		 * This would add the decorator named "decorator2" defined by
		 * "\Aimeos\Admin\JQAdm\Product\Decorator\Decorator2" only to the JQAdm client.
		 *
		 * @param array List of decorator names
		 * @since 2020.04
		 * @supplier Developer
		 * @see admin/jqadm/common/decorators/default
		 * @see admin/jqadm/product/supplier/decorators/excludes
		 * @see admin/jqadm/product/supplier/decorators/global
		 */
		return $this->createSubClient( 'product/supplier/' . $type, $name );
	}


	/**
	 * Returns the list of sub-client names configured for the client.
	 *
	 * @return array List of JQAdm client names
	 */
	protected function getSubClientNames()
	{
		/** admin/jqadm/product/supplier/standard/subparts
		 * List of JQAdm sub-clients rendered within the product supplier section
		 *
		 * The output of the frontend is composed of the code generated by the JQAdm
		 * clients. Each JQAdm client can consist of serveral (or none) sub-clients
		 * that are responsible for rendering certain sub-parts of the output. The
		 * sub-clients can contain JQAdm clients themselves and therefore a
		 * hierarchical tree of JQAdm clients is composed. Each JQAdm client creates
		 * the output that is placed inside the container of its parent.
		 *
		 * At first, always the JQAdm code generated by the parent is printed, then
		 * the JQAdm code of its sub-clients. The order of the JQAdm sub-clients
		 * determines the order of the output of these sub-clients inside the parent
		 * container. If the configured list of clients is
		 *
		 *  array( "subclient1", "subclient2" )
		 *
		 * you can easily change the order of the output by reordering the subparts:
		 *
		 *  admin/jqadm/<clients>/subparts = array( "subclient1", "subclient2" )
		 *
		 * You can also remove one or more parts if they shouldn't be rendered:
		 *
		 *  admin/jqadm/<clients>/subparts = array( "subclient1" )
		 *
		 * As the clients only generates structural JQAdm, the layout defined via CSS
		 * should support adding, removing or reordering content by a fluid like
		 * design.
		 *
		 * @param array List of sub-client names
		 * @since 2020.04
		 * @supplier Developer
		 */
		return $this->getContext()->getConfig()->get( 'admin/jqadm/product/supplier/standard/subparts', [] );
	}


	/**
	 * Returns the supplier items for the given supplier list items
	 *
	 * @param array $listItems List of items implementing \Aimeos\Common\Item\Lists\Iface
	 * @return array List of supplier IDs as keys and items implementing \Aimeos\Supplier\Item\Iface
	 */
	protected function getSupplierItems( array $listItems )
	{
		$ids = [];

		foreach( $listItems as $listItem ) {
			$ids[] = $listItem->getParentId();
		}

		$manager = \Aimeos\MShop::create( $this->getContext(), 'supplier' );

		$search = $manager->createSearch();
		$search->setConditions( $search->compare( '==', 'supplier.id', $ids ) );

		return $manager->searchItems( $search );
	}


	/**
	 * Returns the supplier list items for the given product ID
	 *
	 * @param string $prodid Unique product ID
	 * @return array Associative list of supplier list IDs as keys and list items as values
	 */
	protected function getListItems( $prodid )
	{
		$manager = \Aimeos\MShop::create( $this->getContext(), 'supplier/lists' );

		$search = $manager->createSearch()->setSlice( 0, 0x7fffffff );
		$expr = array(
			$search->compare( '==', 'supplier.lists.refid', $prodid ),
			$search->compare( '==', 'supplier.lists.domain', 'product' ),
		);
		$search->setConditions( $search->combine( '&&', $expr ) );

		return $manager->searchItems( $search );
	}


	/**
	 * Creates new and updates existing items using the data array
	 *
	 * @param \Aimeos\MShop\Product\Item\Iface $item Product item object without referenced domain items
	 * @param array $data Data array
	 */
	protected function fromArray( \Aimeos\MShop\Product\Item\Iface $item, array $data )
	{
		$manager = \Aimeos\MShop::create( $this->getContext(), 'supplier/lists' );
		$listItems = $this->getListItems( $item->getId() );
		$list = [];

		foreach( $data as $idx => $entry )
		{
			if( isset( $listItems[$entry['supplier.lists.id']] ) ) {
				$litem = $listItems[$entry['supplier.lists.id']];
			} else {
				$litem = $manager->createItem();
			}

			$list[] = $litem->setParentId( $this->getValue( $entry, 'supplier.id' ) )->setDomain( 'product' )
				->setType( $this->getValue( $entry, 'supplier.lists.type' ) )->setRefId( $item->getId() );

			unset( $listItems[$litem->getId()] );
		}

		$manager->deleteItems( $listItems );
		$manager->saveItems( $list );
	}


	/**
	 * Constructs the data array for the view from the given item
	 *
	 * @param \Aimeos\MShop\Product\Item\Iface $item Product item object including referenced domain items
	 * @param bool $copy True if items should be copied, false if not
	 * @return string[] Multi-dimensional associative list of item data
	 */
	protected function toArray( \Aimeos\MShop\Product\Item\Iface $item, $copy = false )
	{
		$siteId = $this->getContext()->getLocale()->getSiteId();
		$listItems = $this->getListItems( $item->getId() );
		$supItems = $this->getSupplierItems( $listItems );
		$data = [];

		foreach( $listItems as $listItem )
		{
			$supId = $listItem->getParentId();

			if( !isset( $supItems[$supId] ) ) {
				continue;
			}

			$list = $listItem->toArray( true ) + $supItems[$supId]->toArray( true );

			if( $copy === true )
			{
				$list['supplier.lists.siteid'] = $siteId;
				$list['supplier.lists.id'] = '';
			}

			$data[] = $list;
		}

		return $data;
	}


	/**
	 * Returns the rendered template including the view data
	 *
	 * @param \Aimeos\MW\View\Iface $view View object with data assigned
	 * @return string|null HTML output
	 */
	protected function render( \Aimeos\MW\View\Iface $view )
	{
		/** admin/jqadm/product/supplier/template-item
		 * Relative path to the HTML body template of the supplier subpart for products.
		 *
		 * The template file contains the HTML code and processing instructions
		 * to generate the result shown in the body of the frontend. The
		 * configuration string is the path to the template file relative
		 * to the templates directory (usually in admin/jqadm/templates).
		 *
		 * You can overwrite the template file configuration in extensions and
		 * provide alternative templates. These alternative templates should be
		 * named like the default one but with the string "default" replaced by
		 * an unique name. You may use the name of your project for this. If
		 * you've implemented an alternative client class as well, "default"
		 * should be replaced by the name of the new class.
		 *
		 * @param string Relative path to the template creating the HTML code
		 * @since 2020.04
		 * @supplier Developer
		 */
		$tplconf = 'admin/jqadm/product/supplier/template-item';
		$default = 'product/item-supplier-standard';

		return $view->render( $view->config( $tplconf, $default ) );
	}
}
