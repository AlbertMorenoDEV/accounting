<?php
namespace accounting\infrastructure\persistence;

use accounting\model\AccountHistoryRepository;
use accounting\model\AccountHistory;
use accounting\model\AccountId;
use accounting\model\AccountHistoryId;

class MySQLAccountHistoryRepository implements AccountHistoryRepository
{
	private $tabla = 'accounts_history';
	private $temp = [];
	private $conn;

	public function __construct(\MySQLi $conn)
	{
		$this->conn = $conn;
		$this->mapper = new MySQLDataMapperAccountHistory();
	}

	public function all()
	{
		$resultado = [];
		$qb = new QueryBuilder($this->tabla);
		$action = $this->conn->query((string)$qb);
		if (!$action) {
			throw new \RunTimeException($this->conn->error);
		} 
		while ($row = $action->fetch_array(MYSQLI_ASSOC)) {
			$resultado[] = $this->hydrate($row);
		}
		return $resultado;
	}

	public function findById(AccountHistoryId $id)
	{
		$qb = new QueryBuilder($this->tabla);
		$qb->where(['id' => $id])->limit(1);
		$action = $this->conn->query((string)$qb);
		if (!$action) {
			throw new \RunTimeException($this->conn->error);
		} 
		if ($resultado = $action->fetch_array(MYSQLI_ASSOC)) {
			return $this->hydrate($resultado);
		}	
		return null;
	}

	public function findByConcept($concept)
	{
		$resultado = [];
		$qb = new QueryBuilder($this->tabla);
		$qb->where(['concept LIKE' => "%$concept%"]);
		$action = $this->conn->query((string)$qb);
		if (!$action) {
			throw new \RunTimeException($this->conn->error);
		} 
		while ($row = $action->fetch_array(MYSQLI_ASSOC)) {
			$resultado[] = $this->hydrate($row);
		}
		return $resultado;
	}
	
	public function findByAccountId(AccountId $id)
	{
		$qb = new QueryBuilder($this->tabla);
		$qb->where(['id_account' => $id]);
		$action = $this->conn->query((string)$qb);
		if (!$action) {
			throw new \RunTimeException($this->conn->error);
		} 
		while ($row = $action->fetch_array(MYSQLI_ASSOC)) {
			$resultado[] = $this->hydrate($row);
		}
		return $resultado;
	}

	public function add(AccountHistory $item)
	{
		$this->temp[(string)$item->getId()] = $item;
	}

	public function save()
	{
		$qb = new QueryBuilder($this->tabla, 'REPLACE');
		$campos = ['id', 'id_account', 'amount', 'date', 'concept'];
		$valores = [];
		foreach ($this->temp as $item) {
			$valores[] = [
				$item->getId(),
				$item->getAccount()->getId(),
				$item->getAmount()->getAmount(),
				$item->getDate()->format('Y-m-d H:i:s'),
				$item->getConcept()
			];
		}
		$qb->valores_multiples($campos, $valores);
		$action = $this->conn->query((string)$qb);
		if (!$action) {
			throw new \RunTimeException($this->conn->error);
		}
		$this->temp = [];
	}

	public function delete(AccountHistoryId $id)
	{
		unset($this->temp[(string)$id]);
		$qb = new QueryBuilder($this->tabla, 'DELETE');
		$qb->where(["id" => (string)$id]);
		$action = $this->conn->query((string)$qb);
		if (!$action) {
			throw new \RunTimeException($this->conn->error);
		}
	}
	
	private function hydrate($row)
	{
		$accountRespository = new MySQLAccountRepository($this->conn);
		$row["account"] = $repo->findById($row["id_account"]);
		unset($row["id_account"]);
		return $this->mapper->HydrateFromRow($row);
	}
}