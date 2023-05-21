<?php 
class Db{
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    protected $conn;

    public function __construct(){
        if (!isset($this->conn)) {          
            $this->db_host = "localhost";
            $this->db_user = "db_admin";
            $this->db_pass = "Admin@123";
            $this->db_name = "hrm";

            $this->conn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        }
    }
}
?>