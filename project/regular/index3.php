<?php
error_reporting(-1);
mb_internal_encoding('utf-8');
$text = "ну что.      не смотрел еще black mesa.я собирался скачать  ,но все как-то некогда было.";
// Для тестов
// $text = 'roses are red,and violets are blue.whatever you do i'll keep it for you.';
// $text = 'привет.есть 2 функции,preg_split и explode ,не понимаю,в чем между ними разница.';
 
/* Делает первую букву в строке заглавной */
function makeFirstLetterUppercase($text) {
    $mas = preg_split('#[.] #u', $text);
    foreach ($mas as $key => $value) {
        $value[0] = mb_strtoupper($value[0]);
        echo $value;
    }        
    return $mas;    
}

/* исправляет текст */
function fixText ($text) {
    $pattern = array ('#(\w|[.,])(\s+)#',
                    '#(\s*)([.,])(\w)#u');
    $replace = array ('$1 ',
                    '$2 $3');           
    $text = preg_replace($pattern, $replace, $text);
    return makeFirstLetterUppercase($text);
}
    $result = fixText($text);
    var_dump ($result);
?>