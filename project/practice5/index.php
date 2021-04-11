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

/* Чтобы не писать много раз array('time' => ..., 'by' => ...), используем функцию. 
     «canGet» переводится как «можно попасть» */
     function canGet($time, $byWhat) {
        return array('time'     =>  $time, 'by' =>  $byWhat);
    }
    
   // Текущий путь
   $currentPath        = []; 
   $currentPath[]      = $startPoint;
   // Время, затраченное на текущий путь
   $time               = 0;
    
   //Самый быстрый путь 
   $winPath            = [];
   // Его время (по умолчанию рандом большое число)
   $winTime            = 999999;
    
    
   // Основная функция расчета, которая проходит по всему усл. графу
   function oneStep ($currentPath, $startPoint, $endPoint, $paths, $time){
    
       // Обращаемся к глобальным переменным
       global $winPath;
       global $winTime;
       // Счетчик, который позволяет понять, к какому элементу мы обращаемся (для проверки, не является ли элемент последним)
       $count = 0;
    
       // Перебор всех возможных путей
       foreach ($paths[$startPoint] as $changeStation => $value) {
           $count++;
    
           // Если мы уже были на станции, на которую собираемся пойти
           if ( in_array ( $changeStation, $currentPath) ) {
               // Если эта станция не последняя в текущем списке
               if ( ! ($count == count ($paths[$startPoint])) ){
                   continue;
               }
               else {
                   return;
               } 
           }
    
           // Обновляем текущий список и время
           $currentPath    []= $changeStation;    
           $time           += $value['time'];
    
           // Если нашли выигрышный путь
           if ( $changeStation == $endPoint ){
               // Время выигрышного путя меньше, чем выигрышнуй путь по умолч.
               if ($winTime > $time) {
                   $winPath    = $currentPath;
                   $winTime    = $time;
               }
    
               // Сбрасываем последнюю переменную, так как мы не "пойдем" на эту станцию
               $bif    = array_pop ($currentPath);
    
               // Если  это не последний элемент списка
               if ( ! ($count == count ($paths[$startPoint])) ){
                   continue;
               }
               else {
                   return;
               } 
           }
    
           oneStep ($currentPath, $changeStation, $endPoint, $paths, $time); 
    
           // После вовзрата из "стека", необходимо отбросить последнюю переменную, так как она записана в текущий путь ($currentPath)
           $bif    = array_pop ($currentPath);
           // Аналогичным образом сбрасываем время
           $time   -= $value['time'];
       }
   }
    
   oneStep ($currentPath, $startPoint, $endPoint, $paths, $time);
    
    
   // Выводим информацию
    
   // Вспомогательная переменная, которая запоминает предыдущую станцию
   $beforeStation;
    
   echo "Чтобы добраться с {$pointNames[$startPoint]} до {$pointNames[$endPoint]} за {$winTime} минут, вам нужно: <br>";
   foreach ($winPath as $count => $value) {
    
       if ($count == 0) {
           $beforeStation = $value;
           continue;
       }
    
       echo "От {$pointNames[$beforeStation]} " . 
           $transportName[$paths[$beforeStation][$value]['by']] .
           " до " . $pointNames[$beforeStation] . " за " .
           $paths[$beforeStation][$value]['time'] . " минуты.<br>";
    
       $beforeStation = $value;
   }
    
?>