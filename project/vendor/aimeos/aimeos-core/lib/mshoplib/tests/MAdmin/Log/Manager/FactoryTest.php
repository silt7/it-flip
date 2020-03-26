<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2018
 */


namespace Aimeos\MAdmin\Log\Manager;


class FactoryTest extends \PHPUnit\Framework\TestCase
{
	public function testCreateManager()
	{
		$manager = \Aimeos\MAdmin\Log\Manager\Factory::create( \TestHelperMShop::getContext() );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $manager );
	}


	public function testCreateManagerName()
	{
		$manager = \Aimeos\MAdmin\Log\Manager\Factory::create( \TestHelperMShop::getContext(), 'Standard' );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $manager );
	}


	public function testCreateManagerInvalidName()
	{
		$this->setExpectedException( \Aimeos\MAdmin\Log\Exception::class );
		\Aimeos\MAdmin\Log\Manager\Factory::create( \TestHelperMShop::getContext(), '%^' );
	}


	public function testCreateManagerNotExisting()
	{
		$this->setExpectedException( \Aimeos\MShop\Exception::class );
		\Aimeos\MAdmin\Log\Manager\Factory::create( \TestHelperMShop::getContext(), 'unknown' );
	}

}
