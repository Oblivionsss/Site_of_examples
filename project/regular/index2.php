<?php
	header('Content-Type: text/html; charset=utf-8');
    // Автозамена
    $str = 'Проверка замены слова. Ты дурак. Я редкостный д у p а к. И some английского - дурak. 
    и Еще раз ДурАК ыыы';
    $pattern = '#(д\s?)([уy]\s?)([рp]\s?)([аa]\s?)([кk]\s?)#iu';
    echo preg_replace($pattern, "счастливчик", $str);
    echo "<br>";

    // Дан текст, содержащий в себе email'ы (адреса почты вроде 
    // you+me@some.domain-domain.com ). Напиши скрипт, выводящий все email, встречающиеся в этом тексте

    $pattern_1 = '#[\w-]+@[\w-](.[\w+])+#';
    // $pattern_1 = '#([a-zA-Z0-9_.+-]+)@([a-z0-9.-]+)#'        // Вариант из интернетов


    // Проверка правописания

    $text = ' Привет,я Саша. У меня очень плохо с русским языком но я его учю!сдесь и сейчас';
    $pattern = array (
        '#[.!,;?:]\S#u',      // Проверка отступов после знаков 
        '#[жш]ы#iu',
        '#[чщ]ю#iu',    // Проверка правописания некоторых устойчивых слогов
        '#здела(лa|ли|н|но)#iu',
        '#удевительн(о|ые|ый|а)#iu',
        '#сдесь#iu', // Проверка некоторых слов
        '#\S\sно|a#ui',     // Отсутствие знаков препинания
    );

    echo $text . "<br>";
    // Запускаем цикл проверки по правилам
    foreach ($pattern as $key => $value) {
        if (preg_match_all($value, $text, $mathes,))
        {
            foreach ($mathes as $key_1=> $value_1)
            {
                foreach ($value_1 as $key_2=> $key_3)   
                {
                    switch ($key) {
                        case '0':
                            $text = preg_replace('#([.!,;?:])(\S)#u', '$1 $2', $text);
                            echo "Ошибка в отступах : $key_3 <br> $text<br>";
                            break;
                        
                            
                        case '1':
                            $text = preg_replace('#([жш])ы#iu', '$1и', $text);
                            echo "Ошибка в отступах : $key_3 <br> $text<br>";
                            break;
                        
                        case '2':
                            $text = preg_replace('#([чщ])ю#iu', '$1у', $text);
                            echo "Ошибка в правописании чу щу : $key_3<br> $text<br>";
                            break;
                            
                        case '3':
                            $text = preg_replace('#здела(лa|ли|н|но)#iu', 'сдела$1', $text);
                            echo "Ошибка в правописании слова сделал : $key_3<br> $text<br>";
                            break;

                        case '4':
                            $text = preg_replace('#удевительн(о|ые|ый|а)#iu', 'удивительн$1', $text);
                            echo "Ошибка в правописании слова удивительно : $key_3<br> $text<br>";
                            break;

                        case '5':
                            $text = preg_replace('#сдесь#iu', 'здесь', $text);
                            echo "Ошибка в правописании слова здесь : $key_3<br> $text<br>";
                            break;

                        case '6':
                            $text = preg_replace('#(\S)(\s)(но|a)#ui', '$1,$2$3', $text);
                            echo "Вы пропустили запятую : $key_3<br> $text<br>";
                            break;
                        
                        default :
                            break;
                    }
                }
            }
        }
    }
    echo $text;

?>