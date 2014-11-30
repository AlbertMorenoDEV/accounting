<?php
namespace accounting\infrastructure\ids;

use accounting\model\AccountHistoryId;
use Rhumsaa\Uuid\Uuid;

class AccountHistoryUuid implements AccountHistoryId
{
	private $uuid;

	public function __construct($uuid = "")
	{
		$this->uuid = $uuid;
	}

	public static function generate()
	{
		return new self(Uuid::uuid4());
	}

	public static function fromString($string)
	{
		return new self(Uuid::fromString($string));
	}

	public static function fromNamespace($ns)
	{
		return new self(Uuid::uuid5(Uuid::NAMESPACE_DNS, $ns));		
	}

	public function __toString()
	{
		return (string)$this->uuid;
	}
}
