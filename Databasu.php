<?php
defined('APP_PATH') OR exit('No direct script access allowed'); 

class Databasu
{
    public $db = null;
    
    function __construct()
    {
        try {
            self::openDatabaseConnection();
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
    
    private function openDatabaseConnection()
    {
        if(DB_CONNECTOR == 'sqlite')
        {
            //Connect SQLite
            $this->db = new SQLite3(DB_PATH) or die('Error Connect DB');    
        }
        else
        {
            $this->db = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die('Error Connect DB');    
        }
    }
    
    public function query($query)
    {
        return $this->db->query($query);    
    }
    
    public function fetchArray($result)
    {
        if(DB_CONNECTOR == 'sqlite')
        {
            return $result->fetchArray();     
        }
        else
        {
            return $result->fetch_array();
        }
                
    }   
}