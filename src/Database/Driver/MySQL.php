<?php namespace Database\Driver;

use \Exception as Exception;

/**
 * MySQL Application
 *
 *  An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		MySQL
 * @category    Classes
 * @author		Ramon Barros
 * @copyright	Copyright (c) 2012, Ramon Barros.
 * @license		http://www.ramon-barros.com/
 * @link		http://public.ramon-barros.com/
 * @since		Version 1.9
 * @filesource  MySQL.php
 */

// ------------------------------------------------------------------------

/**
 * MySQL Class
 *
 * @package		MySQL
 * @subpackage	Libraries
 * @category	Database
 * @author		Ramon Barros
 * @link		http://public.ramon-barros.com/
 */
class MySQL {
	
	/**
	 * Mysql link resource
	 * @var object
	 */
	private $db;
	/**
	 * Nome do servidor
	 * @var string
	 */
	private $db_host='localhost';
	/**
	 * Usuário
	 * @var string
	 */
	private $db_user='root';
	/**
	 * Senha
	 * @var string
	 */
	private $db_pwd='';
	/**
	 * Nome do banco de dados
	 * @var string
	 */
	private $db_name='';

	/**
	 * sql TABLE
	 * @var string
	 */
	private $table = array();

	/**
	 * sql SELECT
	 * @var string
	 */
	private $select;
	/**
	 * sql FROM
	 * @var string
	 */
	private $from;

	/**
	 * sql JOIN
	 * @var array
	 */
	private $join_array = array();

	/**
	 * sql JOIN
	 * @var string
	 */
	private $join;

	/**
	 * sql INNER JOIN
	 * @var string
	 */
	private $inner_join;

	/**
	 * sql LEFT JOIN
	 * @var string
	 */
	private $left_join;

	/**
	 * sql LEFT OUTER JOIN
	 * @var string
	 */
	private $left_outer_join;

	/**
	 * sql RIGHT OUTER JOIN
	 * @var string
	 */
	private $right_outer_join;

	/**
	 * sql WHERE
	 * @var string
	 */
	private $where;

	private $where_or;

	private $where_array = array();

	private $where_or_array = array();

	private $where_in;

	private $where_in_array = array();

	private $where_not_in;

	private $where_not_in_array = array();

	/**
	 * sql UPDATE
	 * @var string
	 */
	private $update;

	/**
	 * sql SET
	 * @var string
	 */
	private $set = array();

	/**
	 * sql INSERT
	 * @var string
	 */
	private $insert;

	/**
	 * sql ORDER BY
	 * @var string
	 */
	private $order_by;

	private $order_by_array = array();


	/**
	 * sql LIMIT
	 * @var string
	 */
	private $limit;

	/**
	 * colunas
	 * @var array
	 */
	private $columns;
	/**
	 * Ultimo sql
	 * @var string
	 */
	private $last_sql;
	/**
	 * Ultima consulta
	 * @var mixed
	 */
	private $last_query;

	/**
	 * Constroi o objeto que representa a conexão ao banco de dados
	 * @param string $dbhost Nome do servidor
	 * @param string $dbuser Usuário
	 * @param string $dbpwd  Senha
	 * @param string $dbname Banco de Dados
	 */
	public function __construct($dbhost=null,$dbuser=null,$dbpwd=null,$dbname=null){
		if($dbhost!=null) 	$this->db_host = $dbhost;
		if($dbuser!=null)   $this->db_user = $dbuser;
		if($dbpwd!=null)  	$this->db_pwd = $dbpwd;
		if($dbname!=null) 	$this->db_name = $dbname;
		if(strlen($this->db_host)>0 && strlen($this->db_user))
		{
			$this->connect();
		}
	}

	/**
	 * Verifica se esta conectado
	 * @access	public
	 * @return bool
	 */
	public function connected() {
		if (gettype($this->db) == "resource") {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Desconecta do banco de dados
	 */
	public function __destruct(){
		$this->disconnect($this->db);
	}

	/**
	 * Efetua a conexão ao banco de dados
	 * @access	private
	 * @return null
	 */
	private function connect(){
		try {
			$this->db = mysql_connect($this->db_host,$this->db_user,$this->db_pwd);
			if($this->connected()){
				$this->selectDatabase();
			}else{
				throw new Exception( "Falha na conexão MySql com o banco [".$this->db_user.'@'.$this->db_host."]." );
			}	
		} catch (Exception $e) {
			echo $e->getMessage();
            exit;
		}
	}

	private function selectDatabase(){
		try{
			if(strlen($this->db_name)>0){
				if(mysql_select_db($this->db_name)){
					return true;
				}else{
					throw new Exception( "Falha ao selecionar o banco  de dados [".$this->db_name."].");
				}
			}else{
				throw new Exception( "Banco de dados não informado");
			}
		}catch(Exception $e) {
			echo $e->getMessage();
            exit;
		}
	}
	/**
	 * Desconecta do banco de dados
	 * @access	public
	 * @return null
	 */
	private function disconnect(){
		if($this->connected()){
			mysql_close($this->db);
		}
	}

	/**
	 * Retorna o erro do mysql
	 *
	 * @access	private
	 * @return	string
	 */
	private function _error_message()
	{
		try{
			if ($this->connected()) {
				$error = mysql_error($this->db);
			} else {
				$error = mysql_error();
			}
		} catch(Exception $e) {
			$error = $e->getMessage();
			$errorno = -999;
			throw new Exception($error);
		}		
	}

	// --------------------------------------------------------------------

	/**
	 * Retorna o numero do erro do mysql
	 *
	 * @access	private
	 * @return	integer
	 */
	public function error_number()
	{
		return @mysql_errno($this->db);
	}

	/**
	 * Retorna o erro do mysql
	 *
	 * @access	public
	 * @return	string
	 */
	public function error()
	{
		return @mysql_error($this->db);
	}


	/**
	 * Escapa a string 
	 *
	 * Define tipos booleanos e null 
	 *
	 * @access	public
	 * @param	string
	 * @return	mixed
	 */
	public function escape($str)
	{
		if (is_string($str))
		{
			$str = "'".$str."'";
		}
		elseif (is_bool($str))
		{
			$str = ($str === FALSE) ? 0 : 1;
		}
		elseif (is_null($str))
		{
			$str = 'NULL';
		}

		return $str;
	}

	/**
	 * Função para filtrar os valores passados para o banco Anti Sql Injection
	 * @access	public
	 * @param  mixed $antiSqlInjection Valor a ser filtrado
	 * @return mixed                    Retorna o valor informado filtrado
	 */
	public function antiSqlInjection( $antiSqlInjection, $escape=TRUE) {
	    if( is_array( $antiSqlInjection ) ) {
	        foreach( $antiSqlInjection  AS $key => $var ) {
	            if( is_array( $var ) ) {
	                $antiSqlInjection[$key] = antiSqlInjection( $var );
	            } else {
	                $var = get_magic_quotes_gpc() ? stripslashes($var) : $var;
	                $antiSqlInjection = function_exists( 'mysql_real_escape_string' ) ? mysql_real_escape_string( $var ) : mysql_escape_string( $var );  
	            	if($escape===TRUE){
	            		$antiSqlInjection[$key] = $this->escape($antiSqlInjection);
	            	}else{
	            		$antiSqlInjection[$key] = $antiSqlInjection;
	            	}	            	
	            }
	        }
	    } else {
	        $antiSqlInjection = get_magic_quotes_gpc() ? stripslashes($antiSqlInjection) : $antiSqlInjection;
	        $antiSqlInjection = function_exists( 'mysql_real_escape_string' ) ? mysql_real_escape_string( $antiSqlInjection ) : mysql_escape_string( $antiSqlInjection );  
			if($escape===TRUE){
				$antiSqlInjection = $this->escape($antiSqlInjection);
			}else{
				$antiSqlInjection = $antiSqlInjection;
			}
	    }
    	return $antiSqlInjection;
    }

    /**
     * Seta a table a ser acessada
     * @access private
     * @param tipo   $type  chave para acessar a tabela futuramente
     * @param table  $table nome da tabela
     */
    private function set_table($type,$table){
    	if(strlen($type)>0){
    		$this->table[$type]=$table;
    	}else{
    		$this->table['FROM']=$table;
    	}
    	return $this;
    }

    /**
     * Constroi o SELECT correspondente as colunas informadas
     * @access public
     * @param  string $columns='*' colunas a serem consultadas
     * @return this   retorna o objeto atual
     */
    public function select($columns='*'){
    	//$columns = $this->antiSqlInjection($columns);
		if(is_array($columns)){
			$this->columns = implode(',', $columns);
		}else{
			$this->columns = $columns;
		}
		$this->select = sprintf('SELECT %s ',$this->columns);
		return $this;
	}

	/**
	 * Constroi o FROM correspondente a tabela informada
	 * @access public
	 * @param  string $table Tabela para consulta
	 * @return this   retorna o objeto atual
	 */
	public function from($table=null){
		$this->table['FROM'] = $table;
		$this->from = sprintf('FROM %s ',$this->table['FROM']);
		return $this;
	}
	
	/**
	 * Constroi o INNER JOIN
	 * @access public
	 * @param  string $table tabela
	 * @param  string $cond  condição 
	 * @return this   retorna o objeto atual
	 */
	public function inner_join($table=null,$cond=null){
		$this->table['INNER_JOIN'] = $table;
		if(is_null($table) && is_null($cond)){
			return false;
		}else{
			$this->inner_join = $this->join($this->table['INNER_JOIN'],$cond,'INNER');
		}
		return $this;
	}

	/**
	 * Constroi o LEFT JOIN
	 * @access public
	 * @param  string $table tabela
	 * @param  string $cond  condição 
	 * @return this   retorna o objeto atual
	 */
	public function left_join($table=null,$cond=null){
		$this->table['LEFT_JOIN'] = $table;
		if(is_null($table) && is_null($cond)){
			return false;
		}else{
			$this->left_join = $this->join($this->table['LEFT_JOIN'],$cond,'LEFT');
		}
		return $this;
	}

	/**
	 * Constroi o LEFT OUTER JOIN
	 * @access public
	 * @param  string $table tabela
	 * @param  string $cond  condição 
	 * @return this   retorna o objeto atual
	 */
	public function left_outer_join($table=null,$cond=null){
		$this->table['LEFT_OUTER_JOIN'] = $table;//$this->antiSqlInjection($table);
		if(is_null($table) && is_null($cond)){
			return false;
		}else{
			$this->left_outer_join = $this->join($this->table['LEFT_OUTER_JOIN'],$cond,'LEFT OUTER');
		}
		return $this;
	}

	/**
	 * Constroi o RIGHT OUTER JOIN
	 * @access public
	 * @param  string $table tabela
	 * @param  string $cond  condição 
	 * @return this   retorna o objeto atual
	 */
	public function right_outer_join($table=null,$cond=null){
		$this->table['RIGHT_OUTER_JOIN'] = $table;//$this->antiSqlInjection($table);
		if(is_null($table) && is_null($cond)){
			return false;
		}else{
			$this->right_outer_join = $this->join($this->table['RIGHT_OUTER_JOIN'],$cond,'RIGHT OUTER');
		}
		return $this;
	}

	/**
	 * Constroi o JOIN
	 * @access public
	 * @param  string $table tabela
	 * @param  string $cond  condição 
	 * @return mixed
	 */
	public function join($table=null,$cond=null,$type=null){
		if(is_null($table) && is_null($cond)){
			return false;
		}else{
			if(strlen($type)>0){
				$type = strtoupper(rtrim($type));
				if (in_array($type, array('LEFT', 'RIGHT', 'OUTER', 'INNER', 'LEFT OUTER', 'RIGHT OUTER')))
				{
					$type .= ' ';
				}else{
					$type = '';
				}
			}
			if (preg_match('/([\w\.]+)([\W\s]+)(.+)/', $cond, $match))
			{
				$cond = $match[1].$match[2].$match[3];
			}

			$this->join = $type.'JOIN '.$table.' ON ( '.$cond.' ) ';
			$this->join_array[] = $this->join;
			return $this;
		}
	}

	/**
	 * Verifica as condições do where
	 * @access private
	 * @param  mixed $cond  Condições de busca
	 * @param  valor $value valor da condição caso necessário
	 * @return this         Retorna o objeto atual
	 */
	private function _check_where($cond,$value){
		
		if(preg_match("/([^']+)([\(].+[\)])([\W]+)?/i", $cond, $match)){
			if(preg_match('/REGEXP/i', $match[1]) || preg_match('/FIND_IN_SET/i',$match[1]))
			{	
				$cond = $match[1].$match[2];
			}elseif(preg_match('/DATE_FORMAT/i', $cond)){
				$cond = $match[1].$match[2].$match[3].$value;
			}elseif(preg_match('/DATE_ADD/i', $cond)){
				$cond = $match[1].$match[2].$match[3].$value; //$this->antiSqlInjection($value);
			}
		}elseif(preg_match('/LIKE/i', $cond)){
			$cond = $cond.' '.$value;
		}elseif(preg_match('/([\w\.]+)([\W\s]+)/',$cond, $match)){
			if(preg_match('/([\w\.]+)([\W\s]+)([\S]+)([\S]+)/', $value,$val)){
				$value = $val[1].$val[2].$this->antiSqlInjection($val[3]).$val[4];
			}else{
				$value = $this->antiSqlInjection($value);
			}			
			$cond = $match[1].$match[2].$value;
		}else{
			$value = $this->antiSqlInjection($value);
			$cond = $cond.'='.$value;
		}
		return $cond;
	}

	/**
	 * Constroi o Where
	 * @access public
	 * @param  string $cond  condição do where
	 * @param  string $value valor da condição se necessário
	 * @return this    retorna o objeto atual    
	 */
	public function where($cond='',$value='0'){
		/*
		if(is_array($cond)){
			foreach ($cond as $key => $val) {
				$this->where_array[] = sprintf(' %s ',$this->_check_where($key,$val));
			}
		}else{
			$this->where_array[] = sprintf(' %s ',$this->_check_where($cond,$value));
		}
		return $this;
		 */
		$this->_where($cond,$value,'AND');
		return $this;
	}

	/**
	 * Constroi o Where OR
	 * @access public
	 * @param  string $cond  Condição do where
	 * @param  string $value Valor da condição se necessário
	 * @return this          Retorna o objeto atual
	 */
	public function where_or($cond='',$value='0'){
		$this->_where($cond,$value,'OR');
		return $this;
	}

	private function _where($cond='',$value='0',$type='AND'){
		if(!is_array($cond)){
			$cond = array($cond=>$value);
		}
		if(is_array($cond)){
			foreach ($cond as $key => $val) {
				$prefix = (isset($this->where_array) && count($this->where_array) == 0) ? '' : $type; 
				if(is_null($val)){
					$key .= ' IS NULL';
				}

				$this->where_array[] = sprintf(' %s %s ',$prefix,$this->_check_where($key,$val));
			}
		}
	}
	
	public function where_in($key = NULL, $values = NULL){
		$this->_compile_where_in($key,$values);
		return $this;
	}

	public function where_or_in($key = NULL, $values = NULL){
		$this->_compile_where_in($key,$values,FALSE,'OR ');
		return $this;
	}

	public function where_not_in($key = NULL, $values = NULL){
		$this->_compile_where_in($key,$values,TRUE);
		return $this;
	}

	public function where_or_not_in($key = NULL, $values = NULL){
		$this->_compile_where_in($key,$values,TRUE,'OR ' );
		return $this;
	}

	private function _compile_where_in($key = NULL, $values = NULL, $not = FALSE, $type = 'AND '){
		if(is_null($key) || is_null($values)){
			return false;
		}else{
			if(!is_array($values)){
				$values = array($values);
			}
			$not = ($not) ? ' NOT':'';
			foreach ($values as $value) {
				$this->where_in_array[] = $this->escape($value);
			}
			$prefix = (count($this->where_array)==0)?'':$type;
			$where_in = $prefix.$key.$not." IN (".implode(',',$this->where_in_array). ") ";
			$this->where_array[] = $where_in;
		}
		$this->where_in_array = array();
	}

	/**
	 * Compila o sql where
	 * @access private
	 * @return string Retorna o where completo com as condições
	 */
	private function _compile_where(){
		if(isset($this->where_array) && is_array($this->where_array))
		{ 
			$this->where = sprintf('WHERE %s ',implode('',$this->where_array));
			return $this->where;
		}else{
			return false;
		}		
	}

	/**
	 * Constroi o sql ORDER BY
	 * @param  mixed $values  valore a serem ordenados
	 * @param  string $order  tipo de ordenação
	 * @return this        Retorna o objeto atual
	 */
	public function order_by($values=null,$order='ASC'){
		if($values!=null)
		{
			if(is_array($values)){
				foreach ($values as $key => $val) {
					$this->order_by_array[] = $val;
				}		
			}else{
				$this->order_by_array[] = $values;
			}
			$this->order_by = sprintf('ORDER BY %s %s ',implode(',',$this->order_by_array),$order);
			return $this;
		}else{
			return false;
		}		
	}

	private function _compile_order_by(){
		return $this->order_by;
	}

	/**
	 * Constroi o LIMIT correspondente ao inicio e numero de registros
	 * @access public
	 * @param  string $inicios   Inicia deste registro
	 * @param  string $registros Mostra n $registros 
	 * @return this   retorna o objeto atual
	 */
	public function limit($inicio=null,$registros=null){
		if(strlen($inicio)>0 && strlen($registros)>0){
			$inicio = $this->antiSqlInjection($inicio,FALSE);
			$registros = $this->antiSqlInjection($registros,FALSE);
			$this->limit = sprintf('LIMIT %s,%s ',$inicio,$registros);
		}else if(strlen($inicio)>0 && $registros<=0){
			$inicio = $this->antiSqlInjection($inicio,FALSE);
			$this->limit = sprintf('LIMIT %s ',$inicio);
		}
		return $this;
	}

	/**
	 * Seta os valores e escapa strings
	 * @access public
	 * @param mixed  $key    
	 * @param string  $value  value se necessário
	 * @param boolean $escape informa se é necessário escapa a string
	 * @return this Retorna o objeto atual
	 */
	public function set($key, $value = '', $escape = TRUE){
		$key = $this->_object2array($key);
		if ( ! is_array($key))
		{
			$key = array($key => $value);
		}
		foreach ($key as $k => $v)
		{
			if ($escape === FALSE)
			{
				$this->set['`'.$k.'`'] = $v;
			}else{
				$this->set['`'.$k.'`'] = $this->antiSqlInjection($v);
			}
		}
		return $this;
	}

	/**
	 * Objeto para Array
	 *
	 * Converte um objeto para um array
	 *
	 * @param	object
	 * @return	array
	 */
	public function _object2array($object)
	{
		if ( ! is_object($object))
		{
			return $object;
		}

		$array = array();
		foreach (get_object_vars($object) as $key => $val)
		{
			// There are some built in keys we need to ignore for this conversion
			if ( ! is_object($val) && ! is_array($val) && $key != '_parent_name')
			{
				$array[$key] = $val;
			}
		}

		return $array;
	}

	/**
	 * Update
	 *
	 * Constroi o sql UPDATE
	 * @access public
	 * @param	string	table a ser atualizada
	 * @param	array	colunas para atualiazar  
	 * @param	array	clausula where
	 * @param	array	clausula order by
	 * @param	array	clausula limit
	 * @return	number numero de registros afetados
	 */
	public function update($table = '', $set = NULL, $where = NULL, $limit = NULL)
	{
		if(strlen($table)>0 && count($set)>0)
		{
			$this->table['UPDATE'] = $table;
			if ( ! is_null($set))
			{
				$this->set($set);
			}
			if ($where != NULL)
			{
				$this->where($where);
			}
			if ($limit != NULL)
			{
				if (preg_match('/([\w\.]+)([\W\s]+)(.+)/', $limit, $match))
				{
					$this->limit($match[1],$match[3]);
				}else{
					$this->limit($limit);
				}			
			}

			$this->last_sql = $this->_compile_update();
			
			$this->query($this->last_sql);
			
			return $this->affected_rows();
		}else{
			return false;
		}		
	}

	/**
	 * Compila o sql UPDATE
	 *
	 * Gera o sql para atualização
	 *
	 * @access	private
	 * @return	string sql update
	 */
	private function _compile_update()
	{
		foreach ($this->set as $key => $val)
		{
			$valstr[] = $key . ' = ' . $val;
		}
		$this->update = sprintf('UPDATE %s SET %s %s %s ',$this->table['UPDATE'],implode(',',$valstr),$this->_compile_where(),$this->limit);

		return $this->update;
	}
	

	/**
	 * Compila Insert
	 *
	 * Compila uma string de inserção e executa a consulta
	 * @access public
	 * @param	string	a tabela para inserir os dados
	 * @param	array	array associativo de valores de inserção
	 * @return	number registros afetados
	 */
	public function insert($table = '', $set = NULL)
	{
		if(strlen($table)>0 && count($set)>0)
		{
			$this->table['INSERT'] = $table;
			if ( ! is_null($set))
			{
				$this->set($set);
			}

			$this->last_sql = $this->_compile_insert();
			
			$this->query($this->last_sql);
						
			return $this->affected_rows();
		}else{
			return false;
		}
	}

	/**
	 * Declaração Insert
	 *
	 * Gera uma string de inserção específica da plataforma a partir dos dados fornecidos
	 *
	 * @access	private
	 * @param	string	o nome da tabela
	 * @param	array	as chaves de inserção
	 * @param	array	os valores de inserção
	 * @return	string
	 */
	private function _compile_insert()
	{
		return sprintf("INSERT INTO %s ( %s ) VALUES ( %s )",
						$this->table['INSERT'] , implode(',',array_keys($this->set)) , implode(',',array_values($this->set)) );
	}

	/**
	 * Constroi o SQL e efetua a consulta no banco de dados
	 * @return mixed retorna o objeto atual ou falso
	 */
	public function _compile_sql(){
		if(strlen($this->select)>8 && strlen($this->from)>6){
			// SELECT * FROM tabela 
			$this->last_sql = $this->select.$this->from;
			if(count($this->join_array)>0){
				$this->last_sql .= implode(' ',$this->join_array);
			}
			if(count($this->where_array)>0){
				$this->last_sql .= $this->_compile_where();
			}
			if(count($this->order_by_array)>0){
				$this->last_sql .= $this->_compile_order_by();
			}
			if(strlen($this->limit)>0){
				$this->last_sql .= $this->limit;
			}			
			return $this->last_sql;
		}else{
			return false;
		}
	}

	private function _clear(){
		$this->select 		  = NULL;
		$this->from 		  = NULL;
		$this->where 		  = NULL;
		$this->where_array 	  = array();
		$this->where_or 	  = NULL;
		$this->where_or_array = array();
		$this->order_by 	  = NULL;
		$this->order_by_array = array();
		$this->limit 		  = NULL;
		$this->join_array 	  = array();
		$this->update     	  = NULL;
		$this->set 		   	  = NULL;
		$this->insert 	      = NULL;
	}

	/**
	 * Retorna as colunas referente a tabela informada.
	 * @param  string $table nome da tabela
	 * @return array        retorna um array com a colunas da tabela.
	 */
	public function describe($table=null){
		$this->set_table('DESCRIBE',$table);
		if(strlen($this->table['DESCRIBE'])>0){
			$this->last_sql = sprintf('DESCRIBE %s ',$this->table['DESCRIBE']);
			$this->last_query = mysql_query($this->last_sql); 
			while($table=@mysql_fetch_array($this->last_query)){
				$columns[$table[0]]='';  //pega o nome das colunas no banco
				if(strtoupper($table[3])=='PRI'){$primaryKeys[$table[0]]='';}  //pega as chaves primárias
			}
			$described['columns']=$columns;
			$described['primaryKeys']=$primaryKeys;
			return ($described);
		}
	}

	/**
	 * Efetua a consulta no banco de dados
	 * @return (this|false) retorna o objeto atual ou falso
	 */
	public function query($query=null){
		if($this->_compile_sql()===false && strlen($query)<=0){
			return false;
		}else{
			$sql = strlen($this->_compile_sql())>0?$this->_compile_sql():$query;
			$this->last_query = mysql_query($sql); 
			$this->_clear();
			return $this;
		}		
	}

	/**
	 * Insert ID
	 *
	 * @access	public
	 * @return	integer
	 */
	public function insert_id()
	{
		return @mysql_insert_id();
	}

	private function create_table_sequence(){
		$this->query("CREATE TABLE sequence_data (
						sequence_name varchar(100) NOT NULL,
						sequence_increment int(11) unsigned NOT NULL DEFAULT 1,
						sequence_min_value int(11) unsigned NOT NULL DEFAULT 1,
						sequence_max_value bigint(20) unsigned NOT NULL DEFAULT 18446744073709551615,
						sequence_cur_value bigint(20) unsigned DEFAULT 1,
						sequence_cycle boolean NOT NULL DEFAULT FALSE,
						PRIMARY KEY (sequence_name)
					) ENGINE=InnoDB;");
		$this->create_function_sequence();
	}

	private function create_function_sequence(){
		$this->query("DELIMITER $$
						CREATE FUNCTION nextval ( seq_name varchar(100) )
						RETURNS bigint(20) NOT DETERMINISTIC
							BEGIN
								DECLARE cur_val bigint(20);
							        SELECT
							               sequence_cur_value INTO cur_val
									FROM
									        sequence_data
									WHERE
									        sequence_name = seq_name;

									IF cur_val IS NOT NULL
									THEN
										UPDATE
							     		sequence_data
										SET
							     			sequence_cur_value = IF ( ( sequence_cur_value + sequence_increment ) > sequence_max_value,
									     	IF ( sequence_cycle = TRUE, sequence_min_value, NULL ), sequence_cur_value + sequence_increment )
								     		WHERE sequence_name = seq_name;
									END IF;
							RETURN cur_val;
						END$$");
	}

	private function check_privileges_user(){
		$this->query("SELECT Host,User,Create_priv FROM mysql.user WHERE User='".$this->db_user."';");
	    $user=$this->RowAssoc();
	    if($user['Create_priv']=='Y'){
	    	return true;
	    }else{
	    	return false;
	    }
	}

	public function last_insert_id($sequence=null){
		/*
		$this->query("SELECT * FROM sequence_data;");
		if($this->RowCount()>0){
			var_dump('a');
			$this->query("INSERT INTO sequence_data (sequence_name) VALUE ('sequence');");
			return $this->query("SELECT nextval('sequence');")->RowArray();
		}else{
			if($this->check_privileges_user()===true){
				$this->create_table_sequence();
				$this->query("INSERT INTO sequence_data (sequence_name) VALUE ('sequence');");
				return $this->query("SELECT nextval('sequence');")->RowArray();
			}else{
				return mysql_insert_id();
			}
		}
		*/
		return mysql_insert_id();
	}

	public function affected_rows(){
		return mysql_affected_rows();
	}

	/**
	 * Retorna o ultimo sql 
	 * @return string
	 */
	public function lastSql()
	{
		if(strlen($this->last_sql)<=0){
			$this->_compile_sql();
		}
		return $this->last_sql;
	}

	/**
	 * Retorna a ultima consulta
	 * @return resource 
	 */
	public function lastQuery(){
		return $this->last_query;
	}

	/**
	 * @return int
	 */
	public function RowCount()
	{
		if($this->connected() && count($this->last_query)>0 && $this->last_query){
			return mysql_num_rows($this->last_query);
		}else{
			return false;
		}
	}

	/**
	 * @return array
	 */
	public function RowArray()
	{
		if(@mysql_num_rows($this->last_query)){
			return mysql_fetch_array($this->last_query);
		}else{
			return false;
		}
	}

	/**
	 * @return object
	 */
	public function RowObject(){
		if(@mysql_num_rows($this->last_query)){
			return mysql_fetch_object($this->last_query);
		}else{
			return false;
		}
	}

	/**
	 * @return assoc
	 */
	public function RowAssoc(){
		if(@mysql_num_rows($this->last_query)){
			return mysql_fetch_assoc($this->last_query);
		}else{
			return false;
		}
	}

	/**
	 * @return array
	 */
	public function RowAll(){
		if(@mysql_num_rows($this->last_query)){
			$fetchAll = array();
			while ( $row = mysql_fetch_array( $this->last_query, MYSQL_ASSOC ) )
	        {
	            $fetchAll[] = $row;
	        }
	        return $fetchAll;
		}else{
			return false;
		}
	}
}

/**
 * END class MySQL
 * includes/classes/MySQL.php
 */