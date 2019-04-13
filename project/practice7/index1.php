<?php
    function men ($range, $numb) {
        switch ($range) {
            case '1':
                $range = 1;
                break;

            case '2':
                $range = 1.25;
                break;

            case '3':
                $range = 1.5;
                break;
        }
        $mas = array ('sotr' => array(),
                    'ruk' => array());

        $tugr = 500;
        $cofee = 20;                            // Отдельным параметром передаем данные о руководителе
        array_push($mas['ruk'], 1.5 * $range  * $tugr);    
        array_push($mas['ruk'], 2 * $range * $cofee);
        array_push($mas['ruk'], 0);
        
        $page = 200;
        array_push($mas['sotr'], $range * $numb * $tugr);
        array_push($mas['sotr'], $numb * $cofee);
        array_push($mas['sotr'], $numb * $page);

        return $mas;          
    }

    $resultOfMen = men(1, 3);
    var_dump($resultOfMen);
?>