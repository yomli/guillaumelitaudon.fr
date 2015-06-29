<?php

class chezMadeleine
{

    // Blog url (leave empty to autodetect)
    public $url = '';

    // User login
    public $user_login = 'admin';
    public $user_password = 'abcd';

    public function __construct()
    {
        if(empty($this->url))
            $this->url = $this->getUrl();
    }

    public function login($login, $password)
    {
        if($login != $this->user_login || $password != $this->user_password)
            return false;

        @session_start();
        $_SESSION['logged'] = true;
        return true;
    }

    public function logout()
    {
        @session_start();
        $_SESSION = array();
    }

    public function isLogged()
    {
        @session_start();
        if (!empty($_SESSION['logged']))
            return true;

        return false;
    }

    public function getUrl()
    {
        if (!empty($this->url))
            return $this->url;

        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $url = preg_replace('/([?&].*)$/', '', $url);
        return $url;
    }
}
?>
