<?php
/**
 * Created by PhpStorm.
 * Users: sohail
 * Date: 1/26/2018
 * Time: 10:03 AM
 */
class UserModel
{
    private $db ;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function findUserByEmail($email)
    {
       return $this->db->mailExist($email);
    }
    //register user
    public function register($data)
    {

     return $this->db->Insert($data);


    }
    public function login($email,$password)
    {

        return $this->db->LoginWithEmail($email,$password);
    }
}