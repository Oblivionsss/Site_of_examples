<?php

class Register 
{   
    // Add new user in DataBse
    public static function addNewUser($param) 
    {
        $db     = Db::getConnection();
        if (gettype($db) == 'string')
            exit;

        $cookie     = "";
        $my_Insert_Statement = $db->prepare("INSERT INTO studentlist 
        (Name, Surname, Sex, Dateofbirth, Email, Groupss, Balls, Number, cookie) 
        VALUES (:names, :surname, :sex, :dateofbirth, :email, :groups, :balls, :number, :cookie)");
        
        
        $my_Insert_Statement->bindParam(':names',       $param['name']);
        $my_Insert_Statement->bindParam(':surname',     $param['surname']);
        $my_Insert_Statement->bindParam(':sex',         $param['radio']);
        $my_Insert_Statement->bindParam(':dateofbirth', $param['dateOfBirth']);
        $my_Insert_Statement->bindParam(':email',       $param['e_mail']);
        $my_Insert_Statement->bindParam(':groups',      $param['numberOfGroups']);
        $my_Insert_Statement->bindParam(':balls',       $param['balls']);
        $my_Insert_Statement->bindParam(':number',      $param['number']);
        $my_Insert_Statement->bindParam(':cookie',      $cookie);


        if ($my_Insert_Statement->execute()) {
            return $db->lastInsertId();
        } else {
            return false;
        }
    }

    // Update cookie for new user
    public static function addCookieBase($key, $lastId) 
    {
        $db     = Db::getConnection();
        if (gettype($db) == 'string')
            exit;

        $my_Insert_Statement = $db->prepare("UPDATE studentlist SET cookie=:key WHERE ID=:id");

        $my_Insert_Statement->bindParam(':key', $key);
        $my_Insert_Statement->bindParam(':id',  $lastId);

        if ($my_Insert_Statement->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Check currently cookies 
    public static function checkCookie($lastId, $key)
    {
        $db     = Db::getConnection();
        if (gettype($db) == 'string')
            exit;
        
        $my_Insert_Statement = $db->prepare("SELECT * FROM studentlist WHERE ID=:id");

        $my_Insert_Statement->bindParam(':id', $lastId);
        $my_Insert_Statement->execute();

        $result     = $my_Insert_Statement->fetchAll();
        if ($result) {
            return $result;
        } else {
            return false;
        }     
    }

    public static function setInfo($param, $id)
    {
        $db     = Db::getConnection();
        if (gettype($db) == 'string')
            exit;

        $my_Insert_Statement = $db->prepare("UPDATE studentlist SET Name=:names, Surname=:surname, Sex=:sex, 
        Dateofbirth=:dateofbirth, Email=:email, Groupss=:groups, Balls=:balls, Number=:number WHERE ID=:id");            
        
        $my_Insert_Statement->bindParam(':names',       $param['name']);
        $my_Insert_Statement->bindParam(':surname',     $param['surname']);
        $my_Insert_Statement->bindParam(':sex',         $param['radio']);
        $my_Insert_Statement->bindParam(':dateofbirth', $param['dateOfBirth']);
        $my_Insert_Statement->bindParam(':email',       $param['e_mail']);
        $my_Insert_Statement->bindParam(':groups',      $param['numberOfGroups']);
        $my_Insert_Statement->bindParam(':balls',       $param['balls']);
        $my_Insert_Statement->bindParam(':number',      $param['number']);
        $my_Insert_Statement->bindParam(':id',          $id);

        $error  =   $my_Insert_Statement->errorCode();
        if ( $error )
            return $error;
        else  $my_Insert_Statement->execute();

    }
}