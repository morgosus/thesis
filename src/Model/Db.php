<?php

namespace App\Model;


use PDO;
use PDOException;

class Db
{
    private $handler;
    
    /**
     * Db constructor.
     *
     * @param PDO $handler
     */
    public function __construct($handler)
    {
        $this->handler = $handler;
    }
    
    /**
     * @param string       $SQL
     * @param array|string $parameters
     * @param bool         $multiple for fetching more than a single value
     * @param int          $mode
     * @return array|mixed
     */
    public function select($SQL, $parameters = [], $multiple = false, $mode = PDO::FETCH_ASSOC)
    {
        //Now a single string can be passed instead of having to remember to array it like [ string ]
        $parameters = $this->parameterCorrection($parameters);
        
        $toFetch = $this->handler->prepare($SQL);
        
        $toFetch->execute($parameters);
        
        if ($multiple)
            return $toFetch->fetchAll($mode);
        else
            return $toFetch->fetch($mode);
    }
    
    /**
     * For non-selecting DML (insert, update, delete, ..)
     *
     * @param string $SQL
     * @param array  $parameters
     * @param bool   $returnId
     * @return bool|mixed
     */
    public function modify($SQL, $parameters, $returnId = false)
    {
        $parameters = $this->parameterCorrection($parameters);
        
        try {
            $to_insert = $this->handler->prepare($SQL);
            if ($returnId) {
                return $to_insert->execute($parameters);
            } else {
                $to_insert->execute($parameters);
                return $this->handler->lastInsertId();
            }
            
        } catch (PDOException $e) {
            $e->getMessage();
        }
        
        return false;
    }
    
    /**
     * @param mixed $parameters
     * @return array
     */
    private function parameterCorrection($parameters)
    {
        //execute takes array
        $parameters = is_array($parameters) ? $parameters : array($parameters);
        
        //and should be passed a null for NULL values
        foreach ($parameters as &$parameter) //make sure PDO will recognize null
            if ($parameter === 'null' or $parameter === 'NULL')
                $parameter = null;
        
        return $parameters;
    }
    
    /**
     * @param string $table where we check for the id
     * @param string $column which should be the name of the id column
     * @param string|int $value which is the id
     *
     * @return false
     */
    public function idExists($table, $column, $value)
    {
        $fetched = $this->select("SELECT COUNT(*) FROM ? WHERE ? = ?", [$table, $column, $value]);
        
        if ($fetched > 0)
            return true;
        else return false;
    }
    
    /**
     * If article isn't found, returns false
     *
     * @param       $SQL
     * @param array $parameters
     * @param       $class
     * @return mixed|bool
     */
    public function fetchOneClass($SQL, $parameters = [], $class)
    {
        try {
            $to_fetch = $this->handler->prepare($SQL);
            $to_fetch->setFetchMode(PDO::FETCH_CLASS, __NAMESPACE__ . '\\' . $class);
            $to_fetch->execute($parameters);
            //return $to_fetch->fetch(PDO::FETCH_CLASS, __NAMESPACE__ . '\\' . $class)
            return $to_fetch->fetch();
        } catch (PDOException $e) {
            //echo $e->getMessage();
            //die('<br>Error accessing the database.');
            return false;
        }
    }
    
    
    /**
     * @param       $SQL
     * @param array $parameters
     * @param       $class
     * @return mixed
     */
    public function fetchAllClass($SQL, $parameters = [], $class)
    {
        //echo __NAMESPACE__ . '\\' . $class;
        try {
            $to_fetch = $this->handler->prepare($SQL);
            $to_fetch->setFetchMode(PDO::FETCH_CLASS, __NAMESPACE__ . '\\' . $class);
            $to_fetch->execute($parameters);
            return $to_fetch->fetchAll();
        } catch (PDOException $e) {
            //echo $e->getMessage();
            //die('<br>Error accessing the database.');
            return false;
        }
    }
    
}
