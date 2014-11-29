<?php
namespace accounting\clients\cli\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use accounting\aplication\ListAccounts;

class ListAccountsCommand extends Command
{
	private $repo;

	public function __construct($repo)
	{
		parent::__construct();
		$this->repo = $repo;
	}

	protected function configure()
	{
		$this->setName('account:list')
			->setDescription('List Accounts')
			->addArgument(
				'name',
				InputArgument::OPTIONAL,
				'Account name filter'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$nameFilter = $input->getArgument('name');

		$usecase = new ListAccounts($this->repo);
		$result = $usecase->execute($nameFilter);
		foreach ($result as $account) {
			$output->writeln($account->getId()." - ".$account->getName());
		}
	}
}