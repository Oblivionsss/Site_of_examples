<?php

    class Auth 
    {
        public static function setCookie($key, $lastId) 
        {
            setcookie('ID', $lastId, time() + 140);          // Сохраняем юзернейм
            setcookie('key', $key, time() + 140);            // Случайная строка для последующей идентификации
        }

        public static function generateSalt()
        {
            $salt           = '';
            $saltLength     = 8;                    // длина соли
            
            for($i = 0; $i < $saltLength; $i++) {
                $salt .= chr(mt_rand(33, 126));     // символ из ASCII-table
            }
        
            return hash('ripemd128', "$salt");
        }

    }