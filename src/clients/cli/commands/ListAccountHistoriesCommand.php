<?php
namespace accounting\clients\cli\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use accounting\aplication\ListAccountHistories;
use accounting\infrastructure\ids\AccountUuid;

class ListAccountHistoriesCommand extends Command
{
	private $respostory;
	private $respostoryAccount;

	public function __construct($respostory, $respostoryAccount)
	{
		parent::__construct();
		$this->respostory = $respostory;
		$this->respostoryAccount = $respostoryAccount;
	}

	protected function configure()
	{
		$this->setName('account-history:list')
			->setDescription('List Account Histories')
			->addArgument(
				'id_account',
				InputArgument::REQUIRED,
				'Account id the account history'
			)
			->addArgument(
				'concept',
				InputArgument::OPTIONAL,
				'Concept the account history'
			);
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$account = $this->respostoryAccount->findById(AccountUuid::fromString($input->getArgument('id_account')));
		$conceptFilter = $input->getArgument('concept');

		$usecase = new ListAccountHistories($this->respostory, $account);
		$result = $usecase->execute($conceptFilter);
		foreach ($result as $accountHistory) {
			$output->writeln($accountHistory->getDate()->format('Y-m-d H:i:s')." - ".$accountHistory->getId()." - ".$accountHistory->getConcept()." - ".$accountHistory->getAmount());
		}
	}
}