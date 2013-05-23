<?php namespace Database\DAO;

use \PDO;
use Database\AbstractConnectorConfig;

/**
 * Classe DAO
 * Define a conexão com o banco de dados extendendo a PDO 
 * @author Gabriel Heming <gabriel_heming@hotmail.com>
 * @copyright Ezoom Bold Agency
 * @package CRMAX
 */
class DAO extends PDO {
    
    private $abstractConnectorConfig;
    
    protected $config;
    
    /**
     * Contrutor
     * Recebe o connector e instancia a PDO
     */    
    public function __construct( AbstractConnectorConfig $config ) {
        
        $this->config = $config;
        
        parent::__construct( $config->get_DSN(), $config->get_user(), $config->get_password(), array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')  );
        parent::setAttribute( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );
    } 
    
    public function next( $sequence ) {
        
        $statement = $this->prepare( sprintf( 'SELECT nextval("%s")', $sequence ) );
        $statement->execute();                   
        return (int)$statement->fetchColumn();    
    }
    
    public function error_translate( $erro ) {
        if( stripos( $erro, 'number of bound variables does not match number of tokens' ) ) {
            $erro = 'N&uacute;mero de tokens n&atilde;o corresponde ao n&uacute;mero de vari&aacute;veis';
        } else if( stripos( $erro, 'Duplicate entry' ) ) {
            $erro = 'Foram encontrados valores duplicados no sistema';
        }
        return $erro;
    }
    
    
}