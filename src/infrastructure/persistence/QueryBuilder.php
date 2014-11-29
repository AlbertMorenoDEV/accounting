<?php
namespace accounting\infrastructure\persistence;

final class QueryBuilder
{	
	private $tabla;
	private $tipo = 'SELECT';
	private $cadena_select = '*';
	private $array_where = [];
	private $array_inner = [];
	private $cadena_order = '';
	private $cadena_group = '';
	private $array_having = [];
	private $limit = false;
	private $pagina = 0;
	private $array_campos = [];
	private $array_valores = [];
	private $array_valores_multiples = [];
	
	public function __construct($tabla, $tipo='SELECT')
	{
		assert(is_string($tabla));
		assert(is_string($tipo));
		$this->tabla = $tabla;
		$this->tipo = strtoupper($tipo);
	}
	
	public function select($cadena_select)
	{
		if (in_array($this->tipo, ["DELETE", "UPDATE", "INSERT", "REPLACE"])) {
			throw new RuntimeException("No puede haber campos seleccionados en un {$this->tipo}.");
		}
		
		$this->cadena_select = $cadena_select;
		return $this;
	}
	
	public function inner($array_inner)
	{
		$this->array_inner = $this->stringToArray($array_inner);
		return $this;
	}
	
	public function where($array_where)
	{
		$this->array_where = $this->stringToArray($array_where);
		return $this;
	}
	
	public function order_by($cadena_order)
	{
		$this->cadena_order = $this->arrayToString($cadena_order);
		return $this;
	}
	
	public function group_by($group_by)
	{
		$this->cadena_group = $this->arrayToString($group_by);
		return $this;
	}
	
	public function having($having)
	{
		$this->array_having = $this->stringToArray($having);
		return $this;
	}
	
	public function limit($limit)
	{
		if ($limit === false || $limit === "") {
			$this->limit = false;			
		} else {
			if (!is_numeric($limit)) {
				throw new InvalidArgumentException("El 'limit' debe ser numérico");
			}
			$this->limit = (int) $limit;
		}
		return $this;
	}
	
	public function pagina($pagina)
	{
		if (!is_numeric($pagina) && $pagina != "") {
			throw new InvalidArgumentException("La 'pagina' debe ser numérica");
		}
		$this->pagina = $pagina;
		return $this;
	}
	
	public function valores(array $array_valores)
	{
		if (in_array($this->tipo, ["SELECT", "DELETE"])) {
			throw new RuntimeException("No puede haber valores en un {$this->tipo}.");
		}
		
		$this->array_campos = array_keys($array_valores);
		$this->array_valores = $array_valores;
		return $this;
	}

	public function valores_multiples(array $array_campos, array $array_valores)
	{
		if (in_array($this->tipo, ["SELECT", "DELETE", "UPDATE"])) {
			throw new RuntimeException("No puede haver valores multiples en un {$this->tipo}.");
		}
		
		$this->array_campos = $array_campos;
		$this->array_valores_multiples = $array_valores;
		return $this;
	}
	
	public function __toString()
	{
		if ($this->tipo == "SELECT" || $this->tipo == "DELETE") {
			if ($this->tipo == "SELECT") {
				$consulta = "SELECT {$this->cadena_select} ";
			} else {				
				$consulta = "DELETE ";
			}
			// from
			$consulta .= "FROM {$this->tabla} ";
			
			// inner
			if ( count($this->array_inner) ) {
				$consulta .= implode(" ", $this->array_inner)." ";
			}
			
			// where
			if ( count($this->array_where) ) {
				$condiciones = $this->procesarCondiciones($this->array_where);
				if ( $condiciones!="" ) $consulta .= "WHERE ".$condiciones." ";
			}
			
			// group
			if ( $this->cadena_group!="" ) {
				$consulta .= "GROUP BY {$this->cadena_group} ";
			}
			
			// having
			if ( count($this->array_having) ) {
				$condiciones_having = $this->procesarCondiciones($this->array_having);	
				if ( $condiciones_having!="" ) $consulta .= "HAVING {$condiciones_having} ";
			}
			
			// order
			if ( $this->cadena_order!="" ) {
				$consulta .= "ORDER BY {$this->cadena_order} ";
			}
			
			// limit
			if ( $this->limit !== false ) {
				$consulta .= "LIMIT ".($this->pagina * $this->limit) . "," . $this->limit;
			}
		
		} elseif ($this->tipo == "INSERT" || $this->tipo == "REPLACE") {
			$consulta = $this->tipo." INTO {$this->tabla} ";
			
			// campos
			$consulta .= "(".$this->campos($this->array_campos).") ";
			
			// valores
			if (count($this->array_valores_multiples)) {
				$consulta .= "VALUES ".$this->valoresInsert($this->array_valores_multiples)." ";
			} else {
				$consulta .= "VALUES ".$this->valoresInsert([$this->array_valores])." ";
			}
		
		} elseif ($this->tipo == "UPDATE") {
			
			$consulta = "UPDATE {$this->tabla} ";
				
				// set
				$consulta .= "SET ".$this->valoresUpdate($this->array_valores)." ";
				
				// where
				if ( count($this->array_where) ) {
					$condiciones = $this->procesarCondiciones($this->array_where);
					if ( $condiciones!="" ) $consulta .= "WHERE ".$condiciones." ";
				}
				
				// limit
				if ( $this->limit !== false ) {
					$consulta .= "LIMIT " . $this->limit;
				}
		
		} else {
			throw new \Exception("Tipo de consulta no reconocido: ".$this->tipo.".");
		}
		
		return trim($consulta);
	}
	
	/**
	 * Llega un array pero queremos una cadena
	 * 
	 * @param type Array $valor_array
	 * @return string
	 */
	private function arrayToString($valor_array)
	{
		if ( is_array($valor_array) ) {
			if ( count($valor_array) ) {
				$retorno =implode(", ", $valor_array);
			} else {
				$retorno = "";
			}
		} else {
			$retorno = $valor_array;
		}
		return $retorno;
	}
	
	/**
	 * Llega una cadena pero queremos un array
	 * 
	 * @param type $valor_array
	 * @return array
	 * @author Quim Calpe
	 */
	private function stringToArray($valor_array)
	{
		$resultado = [];
		foreach ((array) $valor_array as $key => $value) {
			if (!is_numeric($key) || trim($value) !== "") {
				$resultado[$key] = $value;
			}
		}
		return $resultado;
	}
	
	/**
	 * Procesamos un array de condiciones y devolvemos el string SQL resultante
	 * 
	 * @return string
	 * @author Benjamin Colomina
	 */
	private function procesarCondiciones(array $array_valor)
	{
		$condiciones = [];
		foreach ($array_valor as $key_condicion => $campos_condicion) {
			if (is_numeric($key_condicion)) {
				$condiciones[] = $campos_condicion;
			} else {
				if ( substr($key_condicion, -3) == " IN" || substr($key_condicion, -7) == " NOT IN" ) {
					$condiciones[] = $this->condicionIn($key_condicion, $campos_condicion);
				} elseif ( substr($key_condicion, -5) == " LIKE" ) {
					$condiciones[] = $this->condicionLike($key_condicion, $campos_condicion);
				} elseif ( substr($key_condicion, -8) == " BETWEEN" ) {
					$condiciones[] = $this->condicionBetween($key_condicion, $campos_condicion);
				} else {
					$condiciones[] = $this->condicionNormal($key_condicion, $campos_condicion);
				}
			}
		}
		return "(".implode(") AND (", $condiciones).")";
	}
	
	/**
	 * Para comprobar si un texto es una funcion reservada de Mysql
	 *
	 * @param string $texto				string que contiene el texto a comrpobar de la tabla a modificar
	 * @return boolean                  devuelve si es o no funcion reservada
	 * @autor                           Benjamin Colomina
	 */
	private function esMetodoMysql($texto)
	{
		// si no es una cadena no lo es seguro
		if (!is_string($texto)) {
			return false;
		}

		// funciones de MYSQL, miramos si empieza por
		$funciones_reservadas = array();
		$funciones_reservadas[] = "date_add(";
		$funciones_reservadas[] = "datediff(";
		$funciones_reservadas[] = "date(";
		$funciones_reservadas[] = "concat(";
		foreach ($funciones_reservadas as $funcion) {
			if ( !(strpos(strtolower($texto), $funcion) === false) ) {
				return true;
			}
		}

		// palabras reservadas miramos si hay coincidencia exacta
		$funciones_reservadas = array();
		$funciones_reservadas[] = "now()";
		$funciones_reservadas[] = "null";
		foreach ($funciones_reservadas as $funcion) {
			if ( strtolower($funcion) == strtolower($texto) ) {
				return true;
			}
		}

		return false;
	}

	private function esOperando($cadena)
	{
		return in_array($cadena, ['<', '>', '>=', '<=', '<>', '!=', '=']);
	}

	private function condicionNormal($key_condicion, $campos_condicion)
	{
		$partes = explode(" ", $key_condicion);
		if (!$this->esOperando(end($partes))) {
			$key_condicion .= " =";
		}
		
		// miramos si necesitamos comillas
		if ($this->conComillas($campos_condicion)) {
			$campos_condicion = "'" . $this->escapar($campos_condicion) . "'";
		}
		
		// montamos la cadena
		$condicion = $key_condicion . " " . $campos_condicion;

		return $condicion;
	}

	private function condicionIn($key_condicion, $campos_condicion)
	{
		if (is_array($campos_condicion)) {
			$campos = [];
			foreach ($campos_condicion as $condicion) {
				if ($this->conComillas($condicion)) {
					$condicion = "'".$this->escapar($condicion)."'";
				}
				$campos[] = $condicion;
			}
			$campos_string = implode(', ', $campos);
		} else {
			$campos_string = $campos_condicion;
		}
		return $key_condicion . " (" . $campos_string . ")";
	}

	private function condicionLike($key_condicion, $campos_condicion)
	{
		return $key_condicion . " '" . $this->escapar($campos_condicion) . "'";
	}

	private function condicionBetween($key_condicion, $campos_condicion)
	{
		if (is_array($campos_condicion)) {
			if (count($campos_condicion) != 2 ) {
				throw new RuntimeException("Condiciones para BETWEEN incorrectas, si es un array debe ser de 2 posiciones");
			}
			$campo1 = $campos_condicion[0];
			if ( $this->conComillas($campo1) ) {
				$campo1 = "'".$this->escapar($campo1)."'";
			}
			$campo2 = $campos_condicion[1];
			if ( $this->conComillas($campo2) ) {
				$campo2 = "'".$this->escapar($campo2)."'";
			}
			$campos_string = $campo1." AND ".$campo2;
		} else {
			$campos_string = $campos_condicion;
		}
		return $key_condicion . " " . $campos_string;
	}
	
	private function campos($campos)
	{
		if (is_array($campos)) {
			return $this->escapar("`".implode('`, `', $campos)."`");
		} else {
			return $this->escapar($campos);
		}
	}
	
	private function valoresInsert($valores)
	{
		if (is_array($valores)) {
			$registros = [];
			foreach ($valores as $registro) {
				$campos = [];
				foreach ($registro as $valor) {
					if ( $this->conComillas($valor) ) $valor = "'".$this->escapar($valor)."'";
					$campos[] = $valor;
				}
				$registros[] = "(".implode(', ', $campos).")";
			}
			return implode(', ', $registros);
		} else {
			return "(".$valores.")";
		}
	}
	
	private function valoresUpdate($valores)
	{
		if (is_array($valores)) {
			$campos = [];
			foreach ($valores as $campo => $valor) {
				if ( $this->conComillas($valor) ) $valor = "'".$this->escapar($valor)."'";
				$campos[] = $campo." = ".$valor;
			}
			return implode(', ', $campos);
		} else {
			return $valores;
		}
	}
	
	/**
	 * Mira si el valor tiene que llevar comillas
	 */
	private function conComillas($var)
	{
		return !$this->esMetodoMysql($var) && !in_array(gettype($var), ["integer", "double"]);
	}

	private function escapar($cadena)
	{
		$cadena = str_replace("'", "\'", $cadena);
		$cadena = str_replace('"', '\"', $cadena);
		return $cadena;
	}
}