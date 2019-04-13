<?php
header('Content-Type: text/html; charset=utf-8');
define('SUBWAY', 'sub');
define('FOOT', 'foot');
define('BUS', 'bus');
 
$transportName = array(
    SUBWAY  =>  'едешь на метро',
    FOOT    =>  'идешь пешком',
    BUS     =>  'едешь на автобусе'
);
 
$startPoint = 'pet'; // Петроградская
$endPoint = 'nov'; // Новая Голландия
 
$pointNames = array(
    'pet'   =>  'ст. м. Петроградская',
    'chk'   =>  'ст. м. Чкаловская',
    'gor'   =>  'ст. м. Горьковская',
    'spo'   =>  'ст. м. Спортивная',
    'vas'   =>  'ст. м. Василеостровская',
    'kre'   =>  'Петропавловская крепость',
    'let'   =>  'Летний сад',
    'dvo'   =>  'Дворцовая площадь',
    'isa'   =>  'Исакиевский собор',
    'nov'   =>  'Новая Голландия',
    'ras'   =>  'Дом Раскольникова',
    'gos'   =>  'Гостиный Двор',
    'sen'   =>  'Сенная Площадь',
    'vla'   =>  'ст. м. Владимирская',
    'vit'   =>  'Витебский вокзал',
    'teh'   =>  'Технологический Институт'
);
 
$paths = array(
    'pet'   =>  array(
        'chk'   =>  canGet(10, BUS),
        'gor'   =>  canGet(3, SUBWAY)
    ),
 
    'chk'   =>  array(
        'pet'   =>  canGet(10, BUS),
        'spo'   =>  canGet(3, SUBWAY)
    ),
 
    'gor'   =>  array(
        'pet'   =>  canGet(3, BUS),
        'kre'   =>  canGet(5, FOOT),
        'gos'   =>  canGet(6, SUBWAY)
    ),
 
    'spo'   =>  array(
        'chk'   =>  canGet(3, SUBWAY),
        'vas'   =>  canGet(10, BUS),
        'sen'   =>  canGet(7, SUBWAY)
    ),
 
    'vas'   =>  array(
        'spo'   =>  canGet(10, BUS),
        'gos'   =>  canGet(7, SUBWAY),
        'nov'   =>  canGet(11, FOOT)
    ),
 
    'kre'   =>  array(
        'gor'   =>  canGet(5, FOOT)
    ),
 
    'let'   =>  array(
        'dvo'   =>  canGet(6, FOOT),
        'gos'   =>  canGet(7, FOOT)
    ),
 
    'dvo'   =>  array(
        'isa'   =>  canGet(6, FOOT),
        'gos'   =>  canGet(6, FOOT),
        'let'   =>  canGet(6, FOOT)
    ),
 
    'isa'   =>  array(
        'dvo'   =>  canGet(6, FOOT),
        'nov'   =>  canGet(5, FOOT)
    ),
 
    'nov'   =>  array(
        'vas'   =>  canGet(11, FOOT),
        'isa'   =>  canGet(5, FOOT),
        'ras'   =>  canGet(7, BUS)
    ),
 
    'ras'   =>  array(
        'nov'   =>  canGet(7, BUS),
        'sen'   =>  canGet(3, FOOT)
    ),
 
    'gos'   =>  array(
        'vas'   =>  canGet(7, SUBWAY),
        'sen'   =>  canGet(3, SUBWAY),
        'dvo'   =>  canGet(6, FOOT),
        'gor'   =>  canGet(6, SUBWAY),
        'let'   =>  canGet(7, FOOT),
        'vla'   =>  canGet(7, FOOT)        
    ),
 
    'sen'   =>  array(
        'ras'   =>  canGet(3, FOOT),
        'spo'   =>  canGet(7, SUBWAY),
        'gos'   =>  canGet(3, SUBWAY),
        'vla'   =>  canGet(4, SUBWAY),
        'vit'   =>  canGet(2, SUBWAY),
        'teh'   =>  canGet(3, SUBWAY)
    ),
 
    'vla'   =>  array(
        'sen'   =>  canGet(4, SUBWAY),
        'gos'   =>  canGet(7, FOOT),
        'vit'   =>  canGet(3, SUBWAY)
    ),
 
    'vit'   =>  array(
        'sen'   =>  canGet(2, SUBWAY),
        'teh'   =>  canGet(2, SUBWAY),
        'vla'   =>  canGet(3, SUBWAY)
    ),
 
    'teh'   =>  array(
        'sen'   =>  canGet(3, SUBWAY),
        'vit'   =>  canGet(2, SUBWAY)        
    )
);
 
/* Чтобы не писать много раз array('time' => ..., 'by' => ...), используем функцию. 
    «canGet» переводится как «можно попасть» */
function canGet($time, $byWhat) {
    return array('time'     =>  $time, 'by' =>  $byWhat);
}

// Сымитируем следующую ситуацию
// Мы находимся в точке гостиный двор
// teh -> sen -> gos
// Найдем время затраченное на этом пути:
$time = $paths['teh']['sen']['time'] + $paths['sen']['gos']['time'];
// И пройденный путь:
$pathDone[] = 'teh';
$pathDone[] = 'sen';
$pathDone[] = 'gos';
// Где мы сейчас находимся:
$point = "teh";
// Наша цель:
$target = 'vla';

// Теперь напишем функцию которая добавляет последний шаг
// upd2.0 Теперь пилим функцию которая ищет вглубь
$res = makeOneStap($paths, $pathDone, $time, $point, $target);      
function makeOneStap($paths, $pathDone, $time, $point, $target){
    if (!array_key_exists($target, $paths[$point])){        // Если мы не находим нужную точку в текущей ветке
        foreach ($paths[$point] as $key => $value) {        // Значит начинаем перебирать точки текущей ветки
            makeOneStap($paths, $pathDone, $time, $key, $target);     // И для каждой вызывать эту же функцию
                     // Но как это заонтроллить хз, так как эта поебота может циклиться изи
        }
    }
    $result = array();  // Запишем все необходимое в массив
    $result['time'] = $time + $paths[$point][$target]['time'];      // Добавляем новое время для последнего шага
    $result['path'] = array_merge($pathDone);                       // Сливаем массив с путем в наш результирующий массив
    array_push($result['path'], $target);                           // И добавляем последнюю точку
    return $result;
}

var_dump($res);
?>  
<!-- Не решил, потратил 5 часов -->