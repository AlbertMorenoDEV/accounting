<?php
namespace accounting\infrastructure\persistence;

use accounting\model\AccountHistory;
use accounting\infrastructure\ids\AccountHistoryUuid;
use accounting\model\Money;

class MySQLDataMapperAccountHistory
{
	public function HydrateFromRow(array $row)
	{
		return new AccountHistory(
			AccountHistoryUuid::fromString($row['id']),
			$row['account'],
			new Money($row['amount']),
			new \DateTime($row['date']),
			(string) $row['concept']
		);
	}
}