<?php
    	header('Content-Type: text/html; charset=utf-8');
    $regexp = "/к.т/ui";        // Регулярное выражение которое будем искать

    $lines = [
        'Рыжий кот',
        'рыжик крот',
        'скиталец'
    ];

    foreach ($lines as $key) {
        echo "Строка: $key<br>";
        $match = [];
        if (preg_match($regexp, $key, $match) > 0) 
            echo "+ Найдено слово: '{$match[0]}'<br>";
        else 
        {
            echo '- Ничего не найдено<br>';
        }
    }

    // Задача на проверку номера
    $exp = '#[(\\+7)8]((\\s?\\d{3}\\s?|(\\s?\\(\\s?\\d{3}\\s?\\)\\s?)|(\\s?\\-\\s?\\d{3}\\s?\\-\\s?)))(\\s?\\d{3}\\s?)(\\s?\\d{2}\\s?)(\\s?\\d{2}\\s?)#';
    // Не получилось

    echo "<br><br><br>";

    // Ниже первый вариант
    // $regexp_phone = '/^(\+7|8)(((\\S?\\(\\S?)[0-9]{3}(\\S?\\(\\S?))|((\\S?\\-\\S?)[0-9]{3}(\\S?\\-\\S?)))((\\S?\\-\\S?)[0-9]{3}(\\S?\\-\\S?))((\\S?\\-\\S?)[0-9]{2}(\\S?\\-\\S?))((\\S?\\-\\S?)[0-9]{2}(\\S?\\-\\S?))$/';  
    $ms = [];
    $resulten = preg_match($exp, '8 977 6812519', $ms);

    echo $resulten . "<br>";
    var_dump ($ms);
    echo "<br><br><br>";

    
    // Задача на поиск ссылок
    
    $mathes = [];
    $text = "Никогда не переходите на сайт http://2ch.so/b. Заходите лучше на http://google.com";
    $regexp = '!http://([a-z0-9.-]+)(/\\S+)?!';     // Делаем регулярное выражение
    // $count = preg_match_all($regexp, $text, $mathes);    // Вариант 1
    $count = preg_match_all($regexp, $text, $mathes, PREG_SET_ORDER);       

    echo "Найдено ссылок {$count}<br>";
    var_dump($mathes);

    echo "<br>";

    // Пример с заменой
    $text1      = "На улице кошка и собака";
    $regexp1    = '/кошка | собака/u'; 

    // $result = preg_replace($regexp1, 'зверь', $text1);  // 1 вариант замены
    $result = preg_replace($regexp1, '*$0*', $text1);
    
    echo $result;

    // еще один пример с заменой
    $text2      = "kirry@mail.ru, loli@yandex.ru, nolik@google.com";
    $regexp2    = '/([a-zA-Z0-9_+.-]+)@([a-z.-]+)/';

    $result = preg_replace ($regexp2, '$1 (котик) $2', $text2);
    echo "<br>" . $result;



?>
