<?php
namespace accounting\infrastructure\persistence;

use accounting\model\Account;
use accounting\model\AccountId;
use accounting\model\AccountRepository;

class MySQLAccountRepository implements AccountRepository
{

	private $tabla = 'accounts';
	private $temp = [];
	private $conn;

	public function __construct(\MySQLi $conn)
	{
		$this->conn = $conn;
		$this->mapper = new MySQLDataMapperAccount();
	}

	public function add(Account $item)
	{
		$this->temp[(string)$item->getId()] = $item;
	}

	public function all()
	{
		$resultado = [];
		$qb = new QueryBuilder($this->tabla);
		$action = $this->conn->query((string)$qb);
		if (!$action) throw new \RunTimeException($this->conn->error);
		
		while ($row = $action->fetch_array(MYSQLI_ASSOC)) {
			$resultado[] = $this->mapper->HydrateFromRow($row);
		}
		return $resultado;
	}

	public function delete(AccountId $id)
	{
		unset($this->temp[(string)$id]);
		$qb = new QueryBuilder($this->tabla, 'DELETE');
		$qb->where(["id" => (string)$id]);
		$action = $this->conn->query((string)$qb);
		if (!$action) throw new \RunTimeException($this->conn->error);
	}

	public function findById(AccountId $id)
	{
		$qb = new QueryBuilder($this->tabla);
		$qb->where(['id' => $id])->limit(1);
		$action = $this->conn->query((string)$qb);
		if (!$action) throw new \RunTimeException($this->conn->error);
		
		if ($resultado = $action->fetch_array(MYSQLI_ASSOC)) {
			return $this->mapper->HydrateFromRow($resultado);
		}	
		return null;
	}

	public function findByName($name)
	{
		$resultado = [];
		$qb = new QueryBuilder($this->tabla);
		$qb->where(['name LIKE' => "%$name%"]);
		$action = $this->conn->query((string)$qb);
		if (!$action) throw new \RunTimeException($this->conn->error);
		
		while ($row = $action->fetch_array(MYSQLI_ASSOC)) {
			$resultado[] = $this->mapper->HydrateFromRow($row);
		}
		return $resultado;
	}

	public function save()
	{
		$qb = new QueryBuilder($this->tabla, 'REPLACE');
		$campos = ['id', 'name', 'creation_date', 'modification_date', 'total'];
		$valores = [];
		foreach ($this->temp as $item) {
			$valores[] = [
				$item->getId(),
				$item->getName(),
				$item->getCreationDate()->format('Y-m-d H:i:s'),
				$item->getModificationDate()->format('Y-m-d H:i:s'),
				$item->getTotal()->getAmount()
			];
		}
		$qb->valores_multiples($campos, $valores);
		$action = $this->conn->query((string)$qb);
		if (!$action) throw new \RunTimeException($this->conn->error);
		
		$this->temp = [];
	}

}