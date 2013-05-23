<?php namespace Database;
/**
 * Classe AbstractConnectorConfig
 * Cria uma inteface padrão das configurações para a conexão com a classe PDO
 * @author João Batista Neto
 * @copyright iMasters Fórum
 */
 abstract class AbstractConnectorConfig {
 	/**
 	 * Servidor
 	 * @var string
 	 */
 	private $host;
 
 	/**
 	 * Nome do banco
 	 * @var string
 	 */
 	private $name;
 
 	/**
 	 * Senha de conexão
 	 * @var string
 	 */
 	private $password;
 
 	/**
 	 * Usuário de conexão
 	 * @var string
 	 */
 	private $user;
 
 	/**
 	 * Constroi um objeto de configuração de conexão
 	 * @param string $host Servidor de banco de dados
 	 * @param string $name Nome do banco de dados
 	 * @param string $user Usuário de conexão
 	 * @param string $password Senha de conexão
 	 */
 	public function __construct( $host , $name , $user = null , $password = null ){
 		$this->host = $host;
 		$this->name = $name;
 		$this->user = $user;
 		$this->password = $password;
 	}
 
 	/**
 	 * Recupera o servidor de banco de dados
 	 * @return string
 	 */
 	public function get_host(){
 		return $this->host;
 	}
 
 	/**
 	 * Recupera a senha de conexão com o banco de dados
 	 * @return string
 	 */
 	public function get_password(){
 		return $this->password;
 	}
 
 	/**
 	 * Recupera o nome do banco de dados
 	 * @return string
 	 */
 	public function get_name(){
 		return $this->name;
 	}
 
 	/**
 	 * Recupera o usuário de conexão com o banco de dados
 	 * @return string
 	 */
 	public function get_user(){
 		return $this->user;
 	}
 
 	/**
 	 * Recupera a string de conexão com o banco de dados
 	 * @return string
 	 */
 	abstract public function get_DSN();
 }