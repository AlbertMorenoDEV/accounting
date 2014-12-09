<?php
namespace accounting\infrastructure\persistence;

use accounting\model\Account;
use accounting\infrastructure\ids\AccountUuid;
use accounting\model\Money;

class MySQLDataMapperAccount
{
	public function HydrateFromRow(array $row)
	{
		return new Account(
			AccountUuid::fromString($row['id']),
			(string) $row['name'],
			new \DateTime($row['creation_date']),
			new \DateTime($row['modification_date']),
			new Money($row['total'])
		);
	}
}