<?php 
	header('Content-Type: text/html; charset=utf-8');
    echo "Задача про кошек мышек <br>";
    echo "K - Киса, M - Мышка, @ - Спящая мышка <br>";
    echo "Описание смотри на ссылке на гитхаб<br><br>";
    // Есть поле размером N×N (задается в переменной), 
    // на нем есть несколько кошек и несколько мышек (расставляются случайно).
    //  Сама задача взята отсюда https://phpbooktest2.ga/l1/pasta.html (внизу).

    // Получилось сделать модель оценки хода для кошки (видит все поле, выбирает первую попавшуюся мышь, и 
    // идет за ней), для мышки - оценка хода в радиусе 1Х1. Возможно присутствие только одной ко        шки и сколько угодно
    // мышек - по другому не получается, нужен корректный способ выходу из цикла фор
    // Также пришлось применять регулярки - при передачи массива в пост серв триггерился на первую попадавшуюся
    // ковычку json-трансоформированном массиве, и сразу же обрывал на этом моменте. 
    // Поэтому помимо decode и encode добавен дошифратор и дешифратор ковычек в строках.

    // Принцип работы - создаем объект класса oneStep, передаем массив - текущее состояние поля с мышками и кисами
    // Далее последовательяно перебираем зверушек и для каждой в отдельности вызываем функцию оценки хода в зависимости от
    // окружающих факторов. Далее распечатыаем все, и в post передаем текующее состояние поля в виде массива и также возможность сброса значения

    // Баги. При записи значения в 84 и 94 в случае если зверушки просто находятся на одной вертикальной линии - сохраняется последний зверек
    // по правилу записи пар ключ - массив в ассоциативных массивах. 
    // Также мышь ведет себя по дуроёбски, так как нет оценки наиболее выгодной для поедания мышки. Но мне лень :\

    $widthMas   = 15;               // Размер поля
    $mas        = [];               // Массив - в котором будет все храниться

    if (isset($_POST['nextStp'])) {     // Проверяем POST на наличие значения nextStp
        $mas    = ($_POST['mass']);
        $mas    = preg_replace('#U7F#', '"', $mas); // Декодируем ковычки
        $mas    = json_decode($mas);    // Декодируем из строки в массив
    }

    else {
        for ($j = 0; $j < $widthMas; $j++){   // Генерируе пустой поле
            for ($i = 0; $i < $widthMas; $i++){
                $mas[$j][$i] = " . ";     // Заполним для начала пустотой нашу систему
            }
        }

        $mas    = generate(1, '$kats', $widthMas, $mas);
        $mas    = generate(5, '$mouse', $widthMas, $mas);
    }

    function generate($numb, $animal, $widthMas, $mas) {
        if ($animal == '$kats')
            $animal = 'K';
        elseif ($animal == '$mouse') {
            $animal = 'M';
        }
        else return FALSE;

        while ($numb != 0){
            $randX  = rand(0, $widthMas - 1);
            $randY  = rand(0, $widthMas - 1);            
            if ($mas[$randX][$randY] != 'K' && $mas[$randX][$randY] != 'M'){
                $mas[$randX][$randY] = $animal;
            }
            else $numb++;      //В случае если наша клетка уже занята животным еще раз прогоняем \\
            $numb--;
        }
        return $mas;
    }

    for ($j = 0; $j < $widthMas; $j++){
        echo "$j &ensp;&ensp;&ensp;&ensp;";
        for ($i = 0; $i < $widthMas; $i++){
            echo $mas[$j][$i] . "&ensp;&ensp;";   
        }
        echo "<br>";
    }

    $stepAnim   = new oneStep($mas, $widthMas);
    $mas        = json_encode($stepAnim->getMas());

    class oneStep { 
        public $dangerous   = [];
        public function __construct($mas, $widthMas){
            $this->mas      = $mas;

            $help_mas       = [];        // Вспомогательный массив, который будет содержать все координаты наших зверьков
            $help_mas1      = [];

            for ($j = 0; $j < $widthMas; $j++){
                for ($i = 0; $i < $widthMas; $i++){
                    if ($this->mas[$j][$i] == 'M'){ // Для начала ищем всех мышек
                        $help_mas[$j] = $i;         // Сохраняем пару ключ - значение - коорд х и коорд у ИСПРАВИТЬ мышек
                    }
                }
            }
            $this->search($help_mas, 'K');         // Вызываем функцию, в которой будем искать кошку

            for ($j = 0; $j < $widthMas; $j++){
                for ($i = 0; $i < $widthMas; $i++){
                    if ($this->mas[$j][$i] == 'K'){  // Теперь ищем всех кисок
                        $help_mas1[$j] = $i;         // Сохраняем пару ключ - значение - коорд х и коорд у ИСПРАВИТЬ кисок
                    }
                }
            }
            $this->search($help_mas1, 'M');        // Вызываем функцию, в которой будем искать мышку

            echo "<br>";
            for ($j = 0; $j < $widthMas; $j++){
                echo "$j &ensp;&ensp;&ensp;&ensp;";
                for ($i = 0; $i < $widthMas; $i++){
                    echo $this->mas[$j][$i] . "&ensp;&ensp;";
                    if ($this->mas[$j][$i] == ' @ '){
                        $this->mas[$j][$i] = 'K';      // После отдыха киса снова начинает охоту
                    }
                }
                echo "<br>";
            }
        }

        private function search($help_mas, $animal) {
            
            foreach ($help_mas as $key => $value) {            // Последовательно перебираем значения - местоположение наших зверьков
                if ($animal == 'K'){
                    $count  = 1;        // Если мы ищем кошку, значит мы мышь, и наш обзор - 1 клетка
                }

                else{
                    $count  = 14;       // Если мы ищем мышку, значит мы киска, наш обзор - полное поле
                }

                for ($i = $key - $count; $i <= $key + $count; $i++){                  // Задаем последовательный проход по горизонтали в радиусе 1 клетки 
                    if (array_key_exists($i, $this->mas)){                  // Проверка, не дошли ли мы до границы (вверху или внизу например)
                        for ($j = $value - $count; $j <= $value + $count; $j++){      // Последовательный проход по вертикали в радиусе 1 клетки
                            if (array_key_exists($j, $this->mas[$i])){      // Проверка не дошли ли мы до границы (слева, или справа)
                                if ($this->mas[$i][$j] == $animal){
                                    if ($this->mas[$i][$j] == 'K'){              // Если нашли кошку                                                        
                                        $this->mouseStep($key, $value, $i, $j);     
                                    }
                                    elseif ($this->mas[$i][$j] == 'M'){           // Если нашли мышку   
                                        $this->katStep($key, $value, $i, $j);
                                        return;
                                    }
                                }                            
                            }
                            else continue;  
                        }
                    }
                    else continue;
                }
            }
        }

        private function mouseStep($key, $value, $i, $j) {                   // Описываем логику ышки (она видит только в 
                                                                            // радиусе 1 клетки вокруг себя)
            if (($key == 0 && $value == 0) ||
                ($key == 0 && $value == 14) ||
                ($key == 14 && $value == 0) ||
                ($key == 14 && $value == 14)){
                    return;
                }
            elseif ($key == 0 || $key == 14){
                if ($j == $value){
                    $newY = $key;
                    $newX = $value + (rand(-1, 1));     // Имитируем поведение мышки, если она уперлась в стенку
                                                        // и киса на одном уровне с ней                                        
                }
                else {
                    $newY = $key;
                    $newX = $value + ($value-$j);
                }
                $this->mas[$key][$value] = ' . ';
                $this->mas[$newY][$newX] = 'M'; // Меняем позицию нашей мыши
            }
            elseif ($value == 0 || $value == 14){
                if ($i == $key) {
                    $newY = $key + (rand(-1,1));
                    $newX = $value;                     // Имитируем поведение мышки, если она уперлась в стенку
                                                        // и киса в шаге от неё    
                }
                else {
                    $newY = $key + ($key - $i);
                    $newX = $value;
                }
                $this->mas[$key][$value] = ' . ';
                $this->mas[$newY][$newX] = 'M'; // Меняем позицию нашей мышки
            }
            else {
                $newY = $key + ($key - $i);
                $newX = $value + ($value-$j);
                $this->mas[$key][$value] = ' . ';
                $this->mas[$newY][$newX] = 'M'; // Меняем позицию нашей мышки
            }
        }

        private function katStep($key, $value, $i, $j) {
            if ( abs($key - $i) == 1 && abs($value - $j) == 1 ||
            abs($key - $i) == 1 && $value == $j ||
            abs($value - $j) == 1 && $key == $i) {           // Условие при котором мышка находится в радиусе одного шага
                // echo "киса сделала шаг в радиусе  одного шага<br>";
                $this->mas[$key][$value] = ' . ';
                $this->mas[$i][$j] = ' @ ';
            }
            elseif ($key == $i){                            // Мышь и киса на одно горизонтали 
                $newY   = $key; 
                if (($j - $value) > 0)
                    $newX   = $value + 1;
                else ($newX   = $value - 1);
                $this->mas[$key][$value] = ' . ';
                $this->mas[$newY][$newX] = 'K'; // Меняем позицию нашей киски
                // echo "киса сделала шаг в одной горизонтальной линии с мышкой<br>";

            }
            elseif ($value == $j){                          // Мышь и киса на одной вертикали
                $newX   = $value; 
                if (($i - $key) > 0)
                    $newY   = $key + 1;
                elseif (($key - $i) > 0)
                    $newY   = $key - 1;
                $this->mas[$key][$value] = ' . ';
                $this->mas[$newY][$newX] = 'K'; // Меняем позицию нашей киски
                // echo "киса сделала шаг в одной вертикальной линии с мышкой<br>";
            }
            elseif (abs($key - $i) == abs($value - $j)){    // Мышь и киса на одной диагонали
                if ((($key - $i) > 0)   &&
                    ($value - $j) > 0) {
                    $newX   = $value - 1;
                    $newY   = $key - 1;
                }
                elseif ((($key - $i) < 0)   &&
                    ($value - $j) > 0) {
                    $newX   = $value - 1;
                    $newY   = $key + 1;
                }
                elseif ((($key - $i) > 0)   &&
                    ($value - $j) < 0) {
                    $newX   = $value + 1;
                    $newY   = $key - 1;
                }
                else {
                    $newX   = $value + 1;
                    $newY   = $key + 1;
                }
                $this->mas[$key][$value] = ' . ';
                $this->mas[$newY][$newX] = 'K'; // Меняем позицию нашей позициюкиски
            }
            else {
                if (abs($key - $i) < abs($value - $j)){
                    if ($j - $value < 0){
                        $this->mas[$key][$value] = ' . ';
                        $this->mas[$key][$value - 1] = 'K'; 
                    }
                    else {
                        $this->mas[$key][$value] = ' . ';
                        $this->mas[$key][$value + 1] = 'K'; 
                    }
                }
                elseif (abs($key - $i) > abs($value - $j)){
                    if ($i - $key < 0){
                        $this->mas[$key][$value] = ' . ';
                        $this->mas[$key - 1][$value] = 'K'; 
                    }
                    else {
                        $this->mas[$key][$value] = ' . ';
                        $this->mas[$key + 1][$value + 1] = 'K'; 
                    }
                }
            }
        }
        public function getMas() {
            return $this->mas;
        }
    }

$mas    = preg_replace('#\"#', 'U7F', $mas);            // Меняем регуляркой все ковычки, чтобы передать через POST

echo<<<_END
<form action="index.php"method="post">
<input type="submit"    name="nextStp"  value="Следующий ход">
<input type="submit"    name="refresh"  value="Обновить">
<input type="hidden"    name="mass"     value="$mas"></form>
_END;
?>