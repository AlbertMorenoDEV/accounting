<?php
namespace accounting\clients\cli\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use accounting\aplication\CreateAccount;

class CreateAccountCommand extends Command
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
		$this->setName('account:create')
			->setDescription('Create an account')
			->addArgument(
				'name',
				InputArgument::REQUIRED,
				'Name the new account'
			)
			->addArgument(
				'total',
				InputArgument::REQUIRED,
				'Total amount of the new account'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$name = $input->getArgument('name');
		$total = $input->getArgument('total');
		$usecase = new CreateAccount($this->repo, $this->idsGenerator);
		$result = $usecase->execute($name, $total);

		$output->writeln("Account created with uuid ".(string)$result);
	}
}