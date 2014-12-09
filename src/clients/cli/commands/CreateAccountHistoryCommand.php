<?php
namespace accounting\clients\cli\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use accounting\aplication\CreateAccountHistory;
use accounting\infrastructure\ids\AccountUuid;
use accounting\model\Money;

class CreateAccountHistoryCommand extends Command
{
	private $respostory;
	private $idsGenerator;
	private $respostoryAccount;

	public function __construct($respostory, $idsGenerator, $respostoryAccount)
	{
		parent::__construct();
		$this->respostory = $respostory;
		$this->idsGenerator = $idsGenerator;
		$this->respostoryAccount = $respostoryAccount;
	}

	protected function configure()
	{
		$this->setName('account-history:create')
			->setDescription('Create an account history')
			->addArgument(
				'id_account',
				InputArgument::REQUIRED,
				'Account id the new account history'
			)
			->addArgument(
				'amount',
				InputArgument::REQUIRED,
				'Amount of the new account history'
			)
			->addArgument(
				'date',
				InputArgument::REQUIRED,
				'Date the new account history'
			)
			->addArgument(
				'concept',
				InputArgument::REQUIRED,
				'Concept the new account history'
			);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$account = $this->respostoryAccount->findById(AccountUuid::fromString($input->getArgument('id_account')));
		$amount = new Money($input->getArgument('amount'));
		$date = new \DateTime($input->getArgument('date'));
		$concept = $input->getArgument('concept');
		
		$usecase = new CreateAccountHistory($this->respostory, $this->idsGenerator);
		$result = $usecase->execute($account, $amount, $date, $concept);

		$output->writeln("Account history created with uuid ".(string)$result);
	}
}