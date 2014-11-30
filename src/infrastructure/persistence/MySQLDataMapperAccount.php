<?php
namespace accounting\infrastructure\persistence;

use accounting\model\Account;
use accounting\infrastructure\ids\AccountUuid;
use accounting\model\Money;

class MySQLDataMapperAccount
{
	public function HydrateFromRow(array $row)
	{
		return new Account( AccountUuid::fromString($row['id']), (string) $row['name'], (string) $row['creation_date'], (string) $row['modification_date'], new Money($row['total']) );
	}
}