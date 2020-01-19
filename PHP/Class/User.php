<?php
//include "PHP/Class/DBConnection.php";
//include "ImgUpload.php";
class User
{
    protected $db;
    private $_id;
    private $_imie;
    private $_nazwisko;
    private $_email;
    private $_login;
    private $_haslo;


    private $_userID;
    private $_name;
    private $_username;
    private $_password;


    public function getId()
    {
        return $this->_id;
    }

    public function setID($id) {
        $this->_id = $id;
    }
    public function setImie($imie) {
        $this->_imie = $imie;
    }
    public function setNazwisko($nazwisko) {
        $this->_nazwisko = $nazwisko;
    }
    public function setEmail($email) {
        $this->_email = $email;
    }
    public function setLogin($login) {
        $this->_login = $login;
    }
    public function setHaslo($haslo) {
        $this->_haslo = $haslo;
    }

    public function __construct() {
        $this->db = new DBConnection();
        $this->db = $this->db->returnConnection();
    }
    // User registration Method
    public function userRegistration() {
        $haslo_hash = $this->hash($this->_haslo);
        $query = 'SELECT * FROM user WHERE login="'.$this->_login.'" OR email="'.$this->_login.'"';
        $result = $this->db->query($query) or die($this->db->error);
        $count_row = $result->num_rows;
        if($count_row == 0) {
            $query = 'INSERT INTO user SET 
            imie="'.$this->_imie.'",
            nazwisko="'.$this->_nazwisko.'",
            email="'.$this->_email.'",
            login="'.$this->_login.'",   
            haslo="'.$haslo_hash.'"';
            $result = $this->db->query($query) or die($this->db->error);
            return true;
        } else {
            return false;
        }
    }

    // User Login Method
    public function doLogin() {
        $query = 'SELECT login,haslo,id from user WHERE email="'.$this->_login.'" or login="'.$this->_login.'"';
        $result = $this->db->query($query) or die($this->db->error);
        $user_data = $result->fetch_array(MYSQLI_ASSOC);
        //print_r($user_data);
        $count_row = $result->num_rows;
        if ($count_row == 1) {
            if (!empty($user_data['haslo']) && $this->verifyHash($this->_haslo, $user_data['haslo']) == TRUE) {
                $_SESSION['login'] = TRUE;
                $_SESSION['id'] = $user_data['id'];
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    // get User Information
    public function getUserInfo() {
        $query = "SELECT id, imie, email FROM user WHERE id = ".$this->_id;
        $result = $this->db->query($query) or die($this->db->error);
        $user_data = $result->fetch_array(MYSQLI_ASSOC);
        return $user_data;
    }

    //get Session
    public function getSession() {
        if(!empty($_SESSION['login']) && $_SESSION['login']==TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    // logout method
    public function logout() {
        $_SESSION['login'] = FALSE;
        unset($_SESSION);
        session_destroy();
    }

    // password hash
    public function hash($password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $hash;
    }

    // password verify
    public function verifyHash($password, $vpassword) {
        if (password_verify($password, $vpassword)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


}
?>