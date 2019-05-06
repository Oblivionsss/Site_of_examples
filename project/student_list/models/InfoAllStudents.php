<?php

class InfoAllStudents {
    public static function getInfoAboutStudents()
    {
        $db     = Db::getConnection();
        if (gettype($db) == 'string')
            exit;

        $my_Insert_Statement = $db->prepare("SELECT Name, Surname, Sex, Dateofbirth, Email, Groupss, Balls, Number FROM studentlist" );
        $my_Insert_Statement->execute();

        $result     = $my_Insert_Statement->fetchAll();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    
    public static function getSortInfoAboutStudents($path)
    {
        $db     = Db::getConnection();
        if (gettype($db) == 'string')
            exit;
        $query      = "SELECT Name, Surname, Sex, Dateofbirth, Email, Groupss, Balls, Number FROM studentlist";
        
        if (isset($path['search'])) {
            $search = $path['search'];
            $query  .= " WHERE
            (Name LIKE '%$search%') OR (Surname LIKE '%$search%') ";
        }

        if (!empty($path['sort'])) {
            $sort   = $path['sort'];
            $query  .= " ORDER BY $sort";
            if (isset($path['dir'])) {
                
                $query  .= " ASC";            
            }
            else {
                $query  .= " DESC";
            }
        }
        
        $my_Insert_Statement = $db->prepare($query);

        $my_Insert_Statement->execute();

        $result     = $my_Insert_Statement->fetchAll();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

}

