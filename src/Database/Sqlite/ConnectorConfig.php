<?php namespace Database\Sqlite;

use Database\AbstractConnectorConfig;

/**
 * Classe ConnectorConfig
 * Define a configuração para a conexão da classe PDO com o banco de dados Sqlite
 * @author João Batista Neto
 * @copyright iMasters Fórum
 */
 class ConnectorConfig extends AbstractConnectorConfig {
        /**
         * Recupera a string de conexão com o banco de dados
         * @return string
         */
        public function get_DSN(){
                return sprintf( 'sqlite::memory:');
        }
 }