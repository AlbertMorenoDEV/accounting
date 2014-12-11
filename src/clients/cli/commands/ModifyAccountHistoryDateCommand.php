<?php
namespace accounting\clients\cli\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use accounting\aplication\ModifyAccountHistoryDate;

class ModifyAccountHistoryDateCommand extends Command
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
		$this->setName('account-history:modify-date')
			->setDescription('Edit date')
			->addArgument(
				'uuid',
				InputArgument::REQUIRED,
				'Account Uuid'
			)
			->addArgument(
				'date',
				InputArgument::REQUIRED,
				'New date of the account history'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$uuid = $input->getArgument('uuid');
		$newDate = $input->getArgument('date');
		$usecase = new ModifyAccountHistoryDate($this->repo, $this->idsGenerator);
		$usecase->execute($uuid, new \DateTime($newDate));
	}
}