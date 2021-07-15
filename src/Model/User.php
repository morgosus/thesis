<?php

namespace App\Model;


class User
{
    public $id_user;
    
    public $valid = false;
    
    private $username, $email, $hash, $creation;
    
    public function __construct($id_user = null, $username = null, $handler)
    {
        $db = new Db($handler);
        
        if ($id_user !== null) {
            $this->id_user = $id_user;
            $fetch = $db->select('SELECT * FROM user WHERE id_user = ?', [$this->id_user]);
            if ($fetch) {
                $this->username = $fetch['username'];
                $this->email = $fetch['email'];
                $this->hash = $fetch['hash'];
                $this->creation = $fetch['creation'];
            }
        } elseif ($username !== null) {
            $this->username = $username;
            $fetch = $db->select('SELECT * FROM user WHERE username = ?', [$this->username]);
            if ($fetch) {
                $this->id_user = $fetch['id_user'];
                $this->email = $fetch['email'];
                $this->hash = $fetch['hash'];
                $this->creation = $fetch['creation'];
            }
        }
    }
    
    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    public function getEmailMinimal()
    {
        return (($this->email != null) ? (preg_replace('/(\S).*(\S)@(.*)/', '$1 *** $2@$3', $this->decrypt($this->email))) : ('NULL'));
    }
    
    /**
     * @return string
     */
    public function getCreation()
    {
        return $this->creation;
    }
    
    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->id_user;
    }
    
    /**
     * @param string $password
     * @return bool
     */
    public function login($password)
    {
        if (!isset($_SESSION['user'])) {
            if (password_verify($password, $this->hash)) {
                //'Logging in.'
                $_SESSION['user'] = $this;
                if (isset($_SESSION['user'])) {
                    $this->valid = true;
                    $_SESSION['user']->valid = true;
                }
                return true;
            } else {
                unset($_SESSION['user']);
                //'[ERROR] Password does not match username. Unable to log in.'
                //'[ERROR] User found. Password does not match username. Unable to log in.'
                return false;
            }
        } else {
            //'[ERROR] Logged in user detected. Unable to log in.'
            //'[ERROR] User session is set. Unable to log in.'
            return false;
        }
    }
    
    /**
     * @return bool
     */
    public function logout()
    {
        if (session_destroy()) {
            //'You were logged out.'
            return true;
        } else {
            //'A weird error occurred. Logout unsuccessful.'
            return false;
        }
    }
    
    private function encrypt($toEncrypt)
    {
        $encryption_key = $this->getKey();
        $iv = $this->generateIv();
        
        $encrypted = openssl_encrypt($toEncrypt, 'aes-256-cbc', $encryption_key, 0, $iv);
        
        return $encrypted . ':' . base64_encode($iv);
        
    }
    
    private function decrypt($encrypted)
    {
        $encryption_key = $this->getKey();
        $parts = explode(':', $encrypted);
        $decrypted = openssl_decrypt($parts[0], 'aes-256-cbc', $encryption_key, 0, base64_decode($parts[1]));
        
        return $decrypted;
    }
    
    private function getKey()
    {
        return file_get_contents(__DIR__ . '/k.php'); //encryption_key = openssl_random_pseudo_bytes(32);
    }
    
    private function generateIv()
    {
        return openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    }
    
    public function hash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}
