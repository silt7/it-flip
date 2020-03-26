<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2019
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Migrates the tax rate in price table
 */
class PriceMigrateTaxrate extends \Aimeos\MW\Setup\Task\Base
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
		$dbdomain = 'db-price';
		$this->msg( 'Migrating taxrate column in price table', 0 );

		if( $this->getSchema( $dbdomain )->tableExists( 'mshop_price' ) === false )
		{
			$this->status( 'OK' );
			return;
		}

		$conn = $this->acquire( $dbdomain );
		$select = 'SELECT "id", "taxrate" FROM "mshop_price" WHERE "taxrate" NOT LIKE \'{%\'';
		$update = 'UPDATE "mshop_price" SET "taxrate" = ? WHERE "id" = ?';

		$stmt = $conn->create( $update, \Aimeos\MW\DB\Connection\Base::TYPE_PREP );
		$result = $conn->create( $select )->execute();

		while( ( $row = $result->fetch() ) !== false )
		{
			$stmt->bind( 1, json_encode( ['' => $row['taxrate']], JSON_FORCE_OBJECT ) );
			$stmt->bind( 2, $row['id'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );

			$stmt->execute()->finish();
		}

		$this->release( $conn, $dbdomain );

		$this->status( 'done' );
	}
}
