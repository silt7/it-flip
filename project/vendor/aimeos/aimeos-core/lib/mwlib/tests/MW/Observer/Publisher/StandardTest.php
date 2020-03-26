<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2018
 */


namespace Aimeos\MW\Observer\Publisher;


class StandardTest extends \PHPUnit\Framework\TestCase
{
	private $object;


	protected function setUp()
	{
		$this->object = new TestPublisher();
	}


	protected function tearDown()
	{
		unset( $this->object );
	}


	public function testAttach()
	{
		$this->object->attach( new TestListener(), 'test' );
	}

	public function testDetach()
	{
		$l = new TestListener();

		$this->object->attach( $l, 'test' );
		$this->object->detach( $l, 'test' );
	}


	public function testOff()
	{
		$this->object->off();
	}


	public function testNotify()
	{
		$value = 'something';
		$l = new TestListener();

		$this->object->attach( $l, 'test' );
		$this->object->attach( $l, 'testagain' );

		$this->object->notifyPublic( 'test', $value );
		$this->object->notifyPublic( 'testagain', $value );
	}
}


class TestPublisher extends \Aimeos\MW\Observer\Publisher\Base
{
	/**
	 * @param string $action
	 * @param string|null $value
	 * @return mixed Modified value parameter
	 */
	public function notifyPublic( $action, $value = null )
	{
		return $this->notify( $action, $value );
	}
}


class TestListener implements \Aimeos\MW\Observer\Listener\Iface
{
	public function register( \Aimeos\MW\Observer\Publisher\Iface $p )
	{
	}

	public function update( \Aimeos\MW\Observer\Publisher\Iface $p, $action, $value = null )
	{
		return $value;
	}
}
