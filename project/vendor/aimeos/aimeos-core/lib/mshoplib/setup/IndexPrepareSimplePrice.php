<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Prepares the mshop_index_price table to simplification
 */
class IndexPrepareSimplePrice extends \Aimeos\MW\Setup\Task\Base
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies()
	{
		return [];
	}


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return string[] List of task names
	 */
	public function getPostDependencies()
	{
		return ['TablesCreateMShop'];
	}


	/**
	 * Executes the task
	 */
	public function migrate()
	{
		$this->msg( 'Prepare mshop_index_price table to simplification', 0, '' );
		$schema = $this->getSchema( 'db-index' );

		if( $schema->tableExists( 'mshop_index_price' ) === true
			&& $schema->constraintExists( 'mshop_index_price', 'unq_msindpr_p_s_prid_lt' ) === true
		) {
			$this->execute( 'DELETE FROM "mshop_index_price"' );
			$this->status( 'done' );
		}
		else
		{
			$this->status( 'OK' );
		}
	}
}
