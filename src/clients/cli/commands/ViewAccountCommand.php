<?php
namespace accounting\clients\cli\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use accounting\aplication\ViewAccount;

class ViewAccountCommand extends Command
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
		$this->setName('account:view')
			->setDescription('Show details of an account')
			->addArgument(
				'uuid',
				InputArgument::REQUIRED,
				'Uuid account'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$uuid = $input->getArgument('uuid');
		$usecase = new ViewAccount($this->repo, $this->idsGenerator);
		$account = $usecase->execute($uuid);
		$output->writeln("Id: ".$account->getId());
		$output->writeln("Name: ".$account->getName());
		$output->writeln("Creation date: ".$account->getCreationDate());
	}
}