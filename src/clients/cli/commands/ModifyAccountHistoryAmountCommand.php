<?php
namespace accounting\clients\cli\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use accounting\aplication\ModifyAccountHistoryAmount;
use accounting\model\Money;

class ModifyAccountHistoryAmountCommand extends Command
{
	private $repo;
	private $idsGenerator;

	public function __construct($repo, $idsGenerator)
	{
		parent::__construct();
		$this->repo = $repo;
		$this->idsGenerator = $idsGenerator;
	}

	protected function configure()
	{
		$this->setName('account-history:modify-amount')
			->setDescription('Rename a Account')
			->addArgument(
				'uuid',
				InputArgument::REQUIRED,
				'Account Uuid'
			)
			->addArgument(
				'amount',
				InputArgument::REQUIRED,
				'New amount of the account history'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$uuid = $input->getArgument('uuid');
		$newAmount = $input->getArgument('amount');
		$usecase = new ModifyAccountHistoryAmount($this->repo, $this->idsGenerator);
		$usecase->execute($uuid, new Money($newAmount));
	}
}