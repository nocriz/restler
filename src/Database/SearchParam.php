<?php namespace Database;

use \PDO;

/**
 * Classe SearchParam
 * Define a entidade de parâmetros para uma busca
 * Generalização da entidade ArrayIterator 
 * @author Gabriel Heming <gabriel_heming@hotmail.com>
 * @copyright Ezoom Bold Agency
 * @package CRMAX
 */

class SearchParam {
    
    private $column;
    private $method;
    private $pdo_param;
    private $placeholder;
    private $value;
    
    /**
     * Construtor
     * @param string $column O nome da coluna
     * @param string $value O valor a ser comparado
     * @param string $method O método de comparação
     * @param int $pdo_param O tipo de parâmetro definido pelas constantes da PDO
     */
    public function __construct( $column, $value, $method = '=', $pdo_param = PDO::PARAM_STR, $placeholder = null ) {
        $this->column = $column;
        $this->method = $method;
        $this->pdo_param = $pdo_param;
        $this->placeholder = ( $placeholder === null ) ? $column : $placeholder;
        $this->value = $value;
    }
    
    /**
     * Retorna a coluna
     * @return string O nome da coluna
     */    
    public function get_column() {
        return $this->column;
    }
    
    /**
     * Retorna o método de comparação
     * @return string O método
     */    
    public function get_method() {
        return $this->method;
    }    
    
    /**
     * O tipo de parâmetro definido pelas constantes da PDO
     * @return int O tipo de parâmetro
     */    
    public function get_pdo_param() {
        return $this->pdo_param;
    }    
        
    /**
     * Retorna o nome do placeholder para o bindValue
     * @return int O tipo de parâmetro
     */    
    public function get_placeholder() {
        return $this->placeholder;
    }    
    
    /**
     * Retorna o valor da coluna
     * @return string O valor
     */    
    public function get_value() {
        return $this->value;
    }
    
    /**
     * Define o nome da coluna
     * @param string O nome da coluna
     */    
    public function set_column( $column ) {
        $this->column = $column;
    }
    
    /**
     * Define o método de comparação
     * @param string O método
     */    
    public function set_method( $method ) {
        $this->method = $method;
    } 
    
    /**
     * Define o nome do placeholder para o bind value
     * @param string O método
     */    
    public function set_placeholder( $placeholder ) {
        $this->placeholder = $placeholder;
    }    
    
    /**
     * Define o tipo de parâmetro definido pelas constantes da PDO
     * @param int O tipo de parâmetro
     */    
    public function set_pdo_param( $pdo_param ) {
        $this->pdo_param = $pdo_param;
    }    
    
    /**
     * Define o valor da coluna
     * @param string O valor
     */    
    public function set_value( $value ) {
        $this->value = $value;
    }
    
}