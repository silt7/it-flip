<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2019
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Updates product code in subscriptions
 */
class SubscriptionMigrateProductId extends \Aimeos\MW\Setup\Task\Base
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies()
	{
		return array( 'TablesCreateMShop' );
	}


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return string[] List of task names
	 */
	public function getPostDependencies()
	{
		return [];
	}


	/**
	 * Migrate database schema
	 */
	public function migrate()
	{
		$dbdomain = 'db-order';
		$this->msg( 'Updating product ID in subscriptions', 0 );

		if( $this->getSchema( $dbdomain )->tableExists( 'mshop_subscription' ) === false )
		{
			$this->status( 'OK' );
			return;
		}

		$start = 0;
		$conn = $this->acquire( $dbdomain );
		$update = '
			UPDATE "mshop_subscription"
			SET "productid" = (
				SELECT obp."prodid"
				FROM "mshop_order_base_product" AS obp
				WHERE "mshop_subscription"."ordprodid" = obp."id"
				LIMIT 1
			) WHERE "productid" = \'\'
		';

		$conn->create( $update )->execute()->finish();
		$this->release( $conn, $dbdomain );

		$this->status( 'done' );
	}
}
