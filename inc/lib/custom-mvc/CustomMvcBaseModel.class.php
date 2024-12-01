<?php

/**
 * Clase Base del Modelo
 * Para extender funcionalidad
 */
class CustomMvcBaseModel
{
    /**
     * Undocumented variable
     *
     * @var database/MyMySQLi
     */
    protected $connection = null;

    protected $databaseName = null;

    /**
     * Asigna la conexión
     *
     * @param database|MyMySQLi $connection
     * @return void
     */
    public function setConnection ($connection)
    {
        $this->connection = $connection;
        $this->databaseName = $this->connection->getDatabase();

        $this->setConnectionCharacterSet('utf8');
    }

    public function getConnection ()
    {
        return $this->connection;
    }

    public function setDatabaseName ($databaseName)
    {
        $this->databaseName = $databaseName;
    }

    /**
     * Llama un stored procedure sin obtener los resultados, es
     * útil para iterar manualmente
     *
     * @param string $storeProcedureName
     * @param array $params
     * @return mysqli_result|bool
     */
    public function callNoFetch ($storeProcedureName, $params)
    {
        $this->assertConnection();

        return $this->rawCall($storeProcedureName, $params);
    }

    /**
     * Llama un store procedure y devuelve uno o más resultados
     *
     * //
     * La clase "database" NO vincula parámetros y los parámetros tienen que ser un array indexado y ordenado
     * //
     * La clase "MyMySQLi" SI vincula parámetros y los parámetros tienen que ser un array indexado pero
     * cada parámetro es otro array asociativo con las llaves "type" y "value"
     *
     * @param string $storeProcedureName
     * @param array $params
     * @param boolean $fetchSingleResult
     * @return array|bool
     */
    public function call ($storeProcedureName, $params, $fetchSingleResult)
    {
        $this->assertConnection();

        $params = is_array($params) ? $params : array();
        $fetchSingleResult = $fetchSingleResult === true;
        $resource = null;

        /**
         * NOTAS:
         * - Cuando no hay resultados y se usa fetch_assoc el resultado es null
         * - Cuando no hay resultados y se usa fetch_all el resultado es vacío []
         */

        // Legacy database Class uses raw queries
        if ($this->isConnectionLegacyDatabase()) {
            $resource = $this->rawCall($storeProcedureName, $params);

            if (is_bool($resource)) {
                return $resource;
            } else if ($fetchSingleResult) {
                // TODO:REDEFECTIVA: Ver como manejar el nulo que se regresa cuando no hay registros
                $results = $resource->fetch_assoc($resource);
                mysqli_free_result($resource);
                return $results;
            }

            $results = $resource->fetch_all(MYSQLI_ASSOC);
            mysqli_free_result($resource);
            return $results;

        // MyMySQLi Class uses statements so we need to close them
        } else if ($this->isConnectionLegacyMymysql()) {
            $resource = $this->rawCall($storeProcedureName, $params);

            if (is_bool($resource)) {
                return $resource;
            } else if ($fetchSingleResult) {
                $result =  $resource->fetch_assoc();
                $this->connection->closeStmt();
                return $result;
            }

            $results = $resource->fetch_all(MYSQLI_ASSOC);
            $this->connection->closeStmt();
            return $results;
        }

        return false;
    }

    /**
     * Genera la llamada al stored procedure dependiendo de los métodos que se
     * usen en la conexión
     *
     * @param string $storeProcedureName
     * @param array $params
     * @return mysqli_result|bool
     */
    private function rawCall ($storeProcedureName, $params)
    {
        if ($this->isConnectionLegacyDatabase()) {
            $resource = $this->connection->query(
                'CALL ' . $this->databaseName . '.' . $storeProcedureName . '('
                    . join(',', $params)
                . ')'
            );

            return $resource;
        } else if ($this->isConnectionLegacyMymysql()) {
            $this->connection->setSDatabase($this->databaseName);
            $this->connection->setParams($params);
            $this->connection->setSStoredProcedure($storeProcedureName);
            $this->connection->execute();

            $resource = $this->connection->getResult();

            // mysqli_stmt::get_result devuelve un objeto "mysql_result" para consultas que producen un conjunto de resultados, como SELECT o SHOW
            // Para otras consultas exitosas devolverá false, por lo tanto las inserciones pueden confundirse con errores
            // https://www.php.net/manual/en/mysqli-stmt.get-result.php
            if ($resource === false) {
                $errorNumber = $this->getErrno();
                return ($errorNumber === 0);
            } else if (is_null($resource)) {
                return false;
            }

            return $resource;
        }

        return false;
    }

    public function foundRows ()
    {
        if ($this->isConnectionLegacyDatabase()) {
            $resource = $this->connection->query('SELECT FOUND_ROWS() AS found_rows');
            $result = $resource->fetch_all(MYSQLI_ASSOC);
            return ((int) $result[0]['found_rows']);
        } else if ($this->isConnectionLegacyMymysql()) {
            $count = $this->connection->foundRows();
            $this->connection->closeStmt();
            return $count;
        }

        return -1;
    }


    public function getErrno ()
    {
        if ($this->isConnectionLegacyDatabase()
            || $this->isConnectionLegacyMymysql()
        ) {
            return $this->connection->LINK->errno;
        }

        return -1;
    }

    /**
     * Arregla acentos y caracteres especiales
     * Aquí se generaliza el conjunto de caracteres para manejar solo uno
     *
     * @return void
     */
    public function setConnectionCharacterSet ($characterSet)
    {
        if (
            $characterSet === 'utf8'
            && (
                $this->isConnectionLegacyDatabase()
                || $this->isConnectionLegacyMymysql()
            )
        ) {
            $this->connection->query('SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci');
        }
    }

    private function isConnectionLegacyDatabase ()
    {
        return (get_class($this->connection) === 'database');
    }

    private function isConnectionLegacyMymysql ()
    {
        return (get_class($this->connection) === 'MyMySQLi');
    }

    private function assertConnection ()
    {
        $this->assertDatabaseName();

        if (is_null($this->connection)) {
            throw new Exception('A connection must be set');
        }
    }

    private function assertDatabaseName ()
    {
        if (is_null($this->databaseName)) {
            throw new Exception('A database name must be set');
        }
    }

}


?>
