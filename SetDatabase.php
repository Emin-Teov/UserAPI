<?php

namespace DatabaseToAPI;

use \PDO;

class SetDatabase
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "user_api";
    private $setQuery = false;
    private $event = "";
    private $query = null;
    private $id = 0;
    private $token;

    /**
     * @param int id
     */
    public function selectDB($id){
        $this->id = $id;
    }

    /**
     * @param array user
     * @param string token 
     */
    public function insertDB($user, $token)
    {
        $this->token = $token;
        $this->setQuery = true;
        $this->event="insert";
        $this->query = "UPDATE tokens SET token='".md5(uniqid())."' WHERE type='insert'; INSERT INTO users(name, surname, email) VALUES('{$user['name']}','{$user['surname']}','{$user['email']}');";
    }

    /**
     * @param int id
     * @param string token 
     */
    public function deleteDB($id, $token)
    {
        $this->token = $token;
        $this->setQuery = true;
        $this->event="delete";
        $this->query = "UPDATE tokens SET token='".md5(uniqid())."' WHERE type='delete'; DELETE FROM users WHERE id=$id;";
    }

    /**
     * @param int id
     * @param array user
     * @param string token 
     */
    public function updateDB($id, $user, $token)
    {
        $this->token = $token;
        $this->setQuery = true;
        $this->event="update";
        $setUpdate = "";
        foreach ($user as $key => $value) {
           $setUpdate .= "$key = '$value',";
        }
        $setUpdate = substr($setUpdate, 0, strlen($setUpdate)-1);
        $this->query = "UPDATE tokens SET token='".md5(uniqid())."' WHERE type='update'; UPDATE users SET $setUpdate WHERE id=$id;";
    }

    /**
     * @return boolean isToken
     */
    public function checkToken()
    {
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $count = $conn->query("SELECT count(*) FROM tokens WHERE token='{$this->token}' AND type='{$this->event}'");
            return $count->fetchColumn();
        }catch(PDOException $e) {
            die("<h4>Query:{$this->query}</h4><h4>Error: {$e->getMessage()}</h4>");
        }
    }

    /**
     * @return array result
     */
    public function setDB()
    {
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $this->id ? " WHERE id = {$this->id}" : null;
            $stmt = $conn->prepare("SELECT * FROM users".$sql);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if($this->setQuery && $this->checkToken()){
                $conn->exec($this->query);
            }
            return $stmt->fetchAll();
        }catch(PDOException $e) {
            die("<h4>Query:{$this->query}</h4><h4>Error: {$e->getMessage()}</h4>");
        }
    }
}