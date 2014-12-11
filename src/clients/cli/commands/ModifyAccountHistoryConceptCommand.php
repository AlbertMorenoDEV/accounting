<?php
namespace accounting\clients\cli\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use accounting\aplication\ModifyAccountHistoryConcept;

class ModifyAccountHistoryConceptCommand extends Command
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
		$this->setName('account-history:modify-concept')
			->setDescription('Edit concept')
			->addArgument(
				'uuid',
				InputArgument::REQUIRED,
				'Account Uuid'
			)
			->addArgument(
				'concept',
				InputArgument::REQUIRED,
				'New concept of the account history'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$uuid = $input->getArgument('uuid');
		$newConcept = $input->getArgument('concept');
		$usecase = new ModifyAccountHistoryConcept($this->repo, $this->idsGenerator);
		$usecase->execute($uuid, $newConcept);
	}
}