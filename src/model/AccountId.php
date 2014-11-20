<?php
namespace accounting\model;

interface AccountId
{
	public static function generate();
	public static function fromString($string);
	public static function fromNamespace($ns);
	public function __toString();
}