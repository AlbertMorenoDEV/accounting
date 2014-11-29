<?php
namespace accounting\clients\cli\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use accounting\aplication\ChangeAccountName;

class ChangeAccountNameCommand extends Command
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
		$this->setName('account:change-name')
			->setDescription('Rename a Account')
			->addArgument(
				'uuid',
				InputArgument::REQUIRED,
				'Account Uuid'
			)
			->addArgument(
				'name',
				InputArgument::REQUIRED,
				'New name of the category'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$uuid = $input->getArgument('uuid');
		$newName = $input->getArgument('name');
		$usecase = new ChangeAccountName($this->repo, $this->idsGenerator);
		$usecase->ejecutar($uuid, $newName);
	}
}