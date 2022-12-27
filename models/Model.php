<?php

    class Model{

        static $hostname = 'localhost', $username = 'root', $password = '', $dataBase = 'coffee_shop';
        protected $mbd;

        protected final function DBConnection(){
        
            $this->mbd = new mysqli(self::$hostname,self::$username,self::$password,self::$dataBase);

            if ($this->mbd->connect_errno) {

                printf("connection failed: %s\n", $this->mbd->connect_error);
                exit();
            }
        }

        public final function CloseConnection(){

            $this->mbd->close();
        }
    }
?>