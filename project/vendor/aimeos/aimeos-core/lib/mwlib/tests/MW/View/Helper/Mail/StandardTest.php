<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2015-2018
 */


namespace Aimeos\MW\View\Helper\Mail;


class StandardTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $message;


	protected function setUp()
	{
		$view = new \Aimeos\MW\View\Standard();

		$mail = new \Aimeos\MW\Mail\None();
		$this->message = $mail->createMessage();

		$this->object = new \Aimeos\MW\View\Helper\Mail\Standard( $view, $this->message );
	}


	protected function tearDown()
	{
		$this->object = null;
	}


	public function testTransform()
	{
		$this->assertSame( $this->message, $this->object->transform() );
	}

}
