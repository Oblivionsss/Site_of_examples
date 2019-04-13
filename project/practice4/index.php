<?php
	header('Content-Type: text/html; charset=utf-8');
    // Вывести фразу в форме круга 
    // Алгоритм действий следующий:
    // Расчитываем длину строки и делим пополам - будет нашим радиусом
    // Создаем вспомогательный массив который будет отображать наш результат и будет "прототипом" декартовой система коорд.
    // Для просчета определения местоположения нашего первого элемента для будет использовать тригонометрию
    // Понадобятся синусы, косинусы, вписанный прямоугольник в круг, с гипотенузой равной радиусу - от этого будем исходить
    // Также будем исходить из расчета угла между элементами
    // Потрачено 4 часа
    // Работает только для определенного количества элементов строки


    $mas = array();     // Определим основной массив для вывода наших элементов
    $widthMas = 30;      // Зададим ширину нашей декартовой системы равной 30;
    $radius = $widthMas / 2;    
    $mas_coord = array ();  // Создадим вспомогательный массив который будет содержать пару х и у 
                            // - отвечающий за расположение текущего элемента
    $str = "QWERTYUIOPASDFGHJKLZXCVBNM1234567809";    // Тестовый массив

    for ($j = 0; $j < $widthMas +1; $j++){
        for ($i = 0; $i < $widthMas; $i++){
            $mas[$j][$i] = " ";     // Заполним для начала пустотой нашу систему
        }
    }
    
    function print_mas ($mas){      // Функция, которая будет распечатывать наш результат
        foreach ($mas as $key => $value) {
            foreach ($value as $key_1 => $value_1) {
                echo $value_1 . "&nbsp;&nbsp;&nbsp;";
            }
            echo "<br>";
        }
    }

    function circle_mas($mas_coord, $mas, $str){      // Функция которая заполняет "прототип" декартовой системы нашей фразой
        for ($i = 0; $i < count($mas_coord); $i++){
            $coord_x = $mas_coord[$i][0];
            $coord_y = $mas_coord[$i][1];
            // echo $coord_x . " " . $coord_y . "<br>";
            $mas[$coord_x][$coord_y] = $str[$i];
        }
        return $mas;
    }

    // Основной алгоритм расчета координат
    for ($i = 1; $i <= strlen($str);$i++){
        $count = strlen($str); 
        $count = (360 / $count) * $i;       // расчет угла (здесь наверное можно исправить правильность отображения)
        $mas_coord[$i-1][0] = round((cos(($count * pi()) / 180)) * $radius) + 15;   // расчет координаты для х
        $mas_coord[$i-1][1] = abs((floor((sin(($count * pi()) / 180)) * $radius)) - 15);    // расчет координаты для у
    }

    $mas = circle_mas($mas_coord, $mas, $str);
    print_mas($mas);

?>  