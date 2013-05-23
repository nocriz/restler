<?php namespace Database\DAO;

use Database\Exceptions\DBDAOException;
use Database\DAO\DAO;
use \PDO;

/**
 * Classe ClienteDAO
 * Responsável pela persistência do objeto Cliente
 * @author Gabriel Heming <gabriel_heming@hotmail.com>
 * @copyright Ezoom Bold Agency
 * @package CRMAX
 */

class DB_DAO {
    
    public $table;
    public $key;
    private $DAO;
    private $select;
    private $statement;
    
    /**
     * Construtor
     * @param DAO $DAO Configuração para a conexão com a base de dados
     */
    public function __construct( DAO $DAO ) {
        $this->DAO = $DAO;
        $this->key = 'id';
    }
    
    public function table($table){
        $this->table = $table;
        return $this;
    }

    public function select($select=null){
        if(is_null($select)){
            throw new DBDAOException("Você deve passar o select.");
        }
        return $this;
    }

    /**
     * Retorna a quantidade de clientes cadastrados no sistema
     * @param int $id O id do registro
     * @return int A quantidade 
     */    
    public function count( $key = null ) {
        
        try {        
            $atributos = array();
            
            $this->statement = $this->DAO->prepare( $this->select.' WHERE '.$this->key.' = :'.$this->key );
            $this->statement->execute( array( ':'.$this->key => $key )  );
            return (int)$this->statement->rowCount(); 
        } catch ( \PDOException $e ) {
            echo $e->getMessage();
        } catch ( DBDAOException $e ) {
            echo $e->getMessage();            
        }
        return false;
    }
    
    /**
     * Retorna os dados do banco de dados da tabela informada
     * @param int $id O id do registro
     * @retorno array Um array associativo com os atributos de um registro
     */    
    public function get( $key ) {
        try {        
            $atributos = array();
            $this->statement = $this->DAO->prepare( $this->select.' WHERE '.$this->key.' = :'.$this->key );
            $this->statement->execute( array( ':'.$this->key => $key )  );
            if( $this->statement->rowCount() >= 1 ) {            
                $atributos = $this->statement->fetchAll( PDO::FETCH_ASSOC );
            }
        } catch ( \PDOException $e ) {
            echo $e->getMessage();
        } catch ( DBDAOException $e ) {
            echo $e->getMessage();            
        }
        return $atributos;
    }
    
    
    
    /**
     * Retorna os dados do banco de dados do Cliente
     * @param SearchParam $searchParam A lista de parâmetros no padrão iterator
     * @retorno array Uma lista contendo um array associativo com os atributos de um cliente
     */    
    public function getAll( Iterator $searchParam = null ) {                  
        
        if( $searchParam instanceof Iterator ) {
            $where = array();
            foreach( $searchParam AS $key => $param ) {
                $where[] = $param->get_column().' '.$param->get_method().' :'.$param->get_placeholder();
            }
        }
        
        $where = isset( $where ) && count( $where ) > 0 ? ' WHERE '.implode( ' OR ', $where ) : '';
        
        try {
            $atributos = array();
            $this->select.$where;
            $this->statement = $this->DAO->prepare( $this->select.$where );
            
            if( isset( $where{1} ) ) {
                foreach( $searchParam AS $key => $param ) {
                    $this->statement->bindValue( ':'.$param->get_placeholder(), $param->get_value(), $param->get_pdo_param() );
                }
            }
            $this->statement->execute();
            
            if( $this->statement->rowCount() >= 1 ) {            
                $atributos = $this->statement->fetchAll( PDO::FETCH_ASSOC );
            }
        } catch ( \PDOException $e ) {
            echo $e->getMessage();
        } catch ( DBDAOException $e ) {
            echo $e->getMessage();            
        }
        return $atributos;
    }
    
    /** 
     * insere os atributos de um cliente no banco de dados
     * @param array $atributos Os atributos em um array associativo
     * @return boolean True em caso de sucesso e false em caso de falha
     */     
    public function insert( $atributos ) {        
        try {
            $this->statement = $this->DAO->prepare( "INSERT INTO cliente ( id ) VALUES ( ? );" );            
            $this->statement->bindParam( 1, $atributos['id'], PDO::PARAM_INT );
            $this->statement->execute(); 
            return true;
        } catch( \PDOException $e ) {
            echo '<pre class="erro">'.$this->DAO->error_translate( $e->getMessage() ).'</pre>';
            return false;
        }
    }
}