<?php

class InfoAllStudents {
    public static function getInfoAboutStudents($bool, $numbOfPage) // Вывод информации при первом посещении страницы
    {                                                               // Либо при объеме страницы меньше заданного
        $db     = Db::getConnection();
        
        
        if (gettype($db) == 'string')
            exit;

        $query_parth        = '';


        if ($bool == true) {            // Проверка на запрос строк
            $query_parth    = " COUNT(*)";
        }                               
        else {                          // Проверка на вывод полной информации
            $query_parth    = " Name, Surname, Sex, Dateofbirth, Email, Groupss, Balls, Number";
        }
        
        $query              = "SELECT" . $query_parth . " FROM studentlist";

 
        if ($numbOfPage > 1) {

            if (isset($_GET['page'])) {
                $page = $_GET['page'];   

                if ($page <= $numbOfPage && $page > 1){
                    $lower_grace = (($page - 1) * 6);  // Определяем нижнюю границу
                    // if ($page == $numbOfPage){
                    //     $query      .= " LIMIT $lower_grace, 6";    
                    // }
                    $query      .= " LIMIT $lower_grace, 6";
                }
                else {
                    $query          .= " LIMIT 1, 6";
                }
            }
            else {
                $query          .= " LIMIT 1, 6";      // Если страница не соответствует действительности
                                                        // либо задана некорректно или выходит за границы - выдаем 1 страницу
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
    
    public static function getSortInfoAboutStudents($path, $bool, $numbOfPage)
    {
        $db             = Db::getConnection();


        if (gettype($db) == 'string')
            exit;                       // Проверка на подключени
        
        $query_parth        = '';


        if ($bool == true) {            // Проверка на запрос строк
            $query_parth    = " COUNT(*)";
        }                               
        else {                          // Проверка на вывод полной информации
            $query_parth    = " Name, Surname, Sex, Dateofbirth, Email, Groupss, Balls, Number";
        }

        $query          = "SELECT" . $query_parth . " FROM studentlist";   
                                        // Основная часть запроса


        if (isset($path['search'])) {   // Дополнительные параметры - запрос 
            $search     = $path['search'];
            $query      .= " WHERE
            (Name LIKE '%$search%') OR (Surname LIKE '%$search%') ";
        }


        if (!empty($path['sort'])) {    // Дополнительные параметры - сортировка столбца
            $sort       = $path['sort'];
            $query      .= " ORDER BY $sort";

            if (isset($path['dir'])) {  // Дополнительные параметры - способ сортировки    
                $query  .= " ASC";            
            }
            else {
                $query  .= " DESC";
            }
        }

       
        if ($numbOfPage > 1) {

            if (isset($path['page'])) {
                $page = $path['page'];   

                if ($page <= $numbOfPage && $page > 1){
                    $lower_grace = (($page - 1) * 6);  // Определяем нижнюю границу
                    
                    $query      .= " LIMIT $lower_grace, 6";
                }
                else {
                    $query          .= " LIMIT 1, 6";
                }
            }
            else {
                $query          .= " LIMIT 1, 6";      // Если страница не соответствует действительности
                                                        // либо задана некорректно или выходит за границы - выдаем 1 страницу
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

