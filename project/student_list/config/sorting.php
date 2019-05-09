<?php   // Файл формирования URI запросов

    $sort   = 'kek';     // Варианта, позволяющая отследить текущий столбец и его историю
    $search = '';               // Поисковая строка
    $dir    = 'desc';           // Способ сортировка по умолчанию (В порядке убывания)
            
    $columns= array("Name", "Surname", "Sex", "Dateofbirth", "Email", "Groupss", "Balls", "Number");
                // Список названий основных столбцов


    function getSortingLink($column, $sort, $dir, $search, $page)      // Возвращает часть URI под запрос
    {
        $link = "?sort=$column";
	    if ($sort == $column && $dir == 'desc') $link .= '&dir=asc';
        $search = u($search);                                   // Формируем запрос
        $link   .= "&search=$search";  
        $link   .="&page=$page";                         
        return $link;
    }


    function getSortLink($column, $sort, $dir, $search, $page)      // Возвращает часть URI под запрос
    {
        $link   = '';
        $parth  = '?';
        $columns= array("Name", "Surname", "Sex", "Dateofbirth", "Email", "Groupss", "Balls", "Number");
        if (in_array($column, $columns)) {
            $link   = "?sort=$column";
            if ($sort == $column && $dir == 'asc') $link .= '&dir=asc';
            $parth  = '&';
        }
        $search = u($search);                                   // Формируем запрос
        $link   .= "{$parth}search=$search";  
        $link   .="&page=$page";                         
        return $link;
    }

    function getArrow ($column, $sort, $dir)        // Определяет символ убывания, возрастания (или ничего)
    {
        if ($column == $sort){
            if ($dir == 'desc'){
                return "&#8595;";
            } else {
                return "&#8593;";
            }
        }
    }


    function h($in)                                 // Возвращает преобразованную строку в HTML-сущности
    {
        return htmlspecialchars($in, ENT_QUOTES);
    }


    function u($in)                                 // Формирует URL-Кодирование строки
    {
        return urlencode($in);
    }

    if (isset($_GET['dir']) && in_array($_GET['dir'], array('asc', 'desc'))) {
        $dir = $_GET['dir'];
    }
    
    if (isset($_GET['sort']) && in_array($_GET['sort'], $columns)) {
        $sort = $_GET['sort'];
    }

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
    }   

    $sort_1     = $sort; 
