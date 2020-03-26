<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018
 */


return array(
	'manager' => array(
		'standard' => array(
			'aggregate' => array(
				'ansi' => '
					SELECT "key", COUNT("val") AS "count"
					FROM (
						SELECT :key AS "key", :val AS "val"
						FROM "mshop_subscription" AS mord
						:joins
						WHERE :cond
						/*-orderby*/ ORDER BY :order /*orderby-*/
						LIMIT :size OFFSET :start
					) AS list
					GROUP BY "key"
				'
			),
			'insert' => array(
				'ansi' => '
					INSERT INTO "mshop_subscription" ( :names
						"baseid", "ordprodid", "next", "end", "interval", "productid", "period",
						"reason", "status", "mtime", "editor", "siteid", "ctime"
					) VALUES ( :values
						?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
					)
				'
			),
			'update' => array(
				'ansi' => '
					UPDATE "mshop_subscription"
					SET :names
						"baseid" = ?, "ordprodid" = ?, "next" = ?, "end" = ?, "interval" = ?,
						"productid" = ?, "period" = ?, "reason" = ?, "status" = ?, "mtime" = ?, "editor" = ?
					WHERE "siteid" = ? AND "id" = ?
				'
			),
			'delete' => array(
				'ansi' => '
					DELETE FROM "mshop_subscription"
					WHERE :cond AND siteid = ?
				'
			),
			'search' => array(
				'ansi' => '
					SELECT :columns
						mord."id" AS "subscription.id", mord."baseid" AS "subscription.ordbaseid",
						mord."ordprodid" AS "subscription.ordprodid", mord."siteid" AS "subscription.siteid",
						mord."next" AS "subscription.datenext", mord."end" AS "subscription.dateend",
						mord."interval" AS "subscription.interval", mord."reason" AS "subscription.reason",
						mord."productid" AS "subscription.productid", mord."period" AS "subscription.period",
						mord."status" AS "subscription.status", mord."ctime" AS "subscription.ctime",
						mord."mtime" AS "subscription.mtime", mord."editor" AS "subscription.editor"
					FROM "mshop_subscription" AS mord
					:joins
					WHERE :cond
					GROUP BY :columns
						mord."id", mord."baseid", mord."ordprodid", mord."siteid", mord."next", mord."end",
						mord."interval", mord."reason", mord."productid", mord."period", mord."status",
						mord."ctime", mord."mtime", mord."editor"
					/*-orderby*/ ORDER BY :order /*orderby-*/
					LIMIT :size OFFSET :start
				'
			),
			'count' => array(
				'ansi' => '
					SELECT COUNT( DISTINCT mord."id" ) AS "count"
					FROM "mshop_subscription" AS mord
					:joins
					WHERE :cond
				'
			),
			'newid' => array(
				'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
				'mysql' => 'SELECT LAST_INSERT_ID()',
				'oracle' => 'SELECT mshop_subscription_seq.CURRVAL FROM DUAL',
				'pgsql' => 'SELECT lastval()',
				'sqlite' => 'SELECT last_insert_rowid()',
				'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
				'sqlanywhere' => 'SELECT @@IDENTITY',
			),
		),
	),
);
