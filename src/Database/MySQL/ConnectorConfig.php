<?php namespace Database\MySQL;

use Database\AbstractConnectorConfig;

/**
 * Classe MySQLConnectorConfig
 * Define a configuração para a conexão da classe PDO com o banco de dados MySQL
 * @author João Batista Neto
 * @copyright iMasters Fórum
 */
 class ConnectorConfig extends AbstractConnectorConfig {
        /**
         * Recupera a string de conexão com o banco de dados
         * @return string
         */
        public function get_DSN(){
                return sprintf( 'mysql:host=%s;dbname=%s' , $this->get_host() , $this->get_name() );
        }
 }