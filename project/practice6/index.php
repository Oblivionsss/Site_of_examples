<?php
	header('Content-Type: text/html; charset=utf-8');
// Это пример реализации ООП
// Есть два сотрудника которые имеют почасовую оплату труда в месяц
// Создать класс рабочий который будет:
// иметь свойства имя, ставка, кол-во отработанных часов за месяц, количество переработанных часов
// иметь метод getTotalHour....... который возвращает общее количество часов работы каждого рабочего
// метод getNormalHpurs....... который возвращает количество часов для рабочего, который трудится без сверхурочных
// метод getOverTimeHours который вычисляет количество переработок для рабочего, который трудится сверхурочно
// метод GetSolary вычисляющий зарплату (переработки оплачиваются в двойном тарифе)
// и для удобства представления данных метод укорачивающий ф. сотрудника
// Вывести все данные в небольшой табличкой

    class Employee
    {
        public $name;       // имя-фамилия
        public $rate;       // Ставка по часам
        public $hours;      // Часов отработано
        public $overtm = 0; // Учет переработок 
 
        // public function __construct ($name, $rate){
        //  $this->name = $name;
        //  $this->rate = $rate
        // }            // Конструктор который позволит создавать удобнее объекты
 
        // Считает количество часов
        public function getTotalHoursWorked(){
            return array_sum($this->hours);
        }

        // По логике - функция выполняющаяся раз, и несет в себе другой смысл, чем ф-ция выше
        public function getNormalHours(){
            return array_sum($this->hours);
        }

        // Расчет переработки
        public function getOvertimeHours(){
            for ($i=0; $i < count($this->hours); $i++){ 
                if ($this->hours[$i] > 40){             // Если в какую-то неделю переработали больше 
                    $ovr = $this->hours[$i] - 40;       // То прибавляем к общем количеству переработок
                    $this->overtm += $ovr;              // 
                    $this->hours[$i] = 40;              // И обновляем $hours - который по факту может содержать колчиство норм. часов
                }
            }
        }

        // Считает зарплату
        public function getSolary(){
            if ($this->hours > 40){
                $solary = array_sum($this->hours) * $this->rate + $this->overtm * $this->rate * 2;
                return $solary;
            }
            else {
                $hours  = $this->getNormalHours();
                $solary = $hours * $this->rate;
                return $solary;
            }
        }   
        
        // Расчет короткого имени
        public function getShortName(){
            $name = $this->name;
            $regexp = '#([\s][\S])(\S)+#ui';
            return preg_replace($regexp, '$1.', $name);
        }
    }    
 
    $ivan       = new Employee;
    $ivan->name = "Иванов Иван";
    $ivan->rate = 10;    // Иван работает за 10 тугриков в час
    $ivan->hours = array(40, 40, 40, 40);   // Иван работает по 40 часов в неделю
 
    $peter          = new Employee;
    $peter->name    = "Петров Петр";
    $peter->rate    = 8;
    $peter->hours   = array(40, 10, 40, 50);  // Петр взял отгул и потому отработал меньше часов,
                                        // но в  последнюю неделю решил поработать побольше
 
    $employees = array($ivan, $peter);
   
    echo "Исходные данные задачи: Ставка первого сотрудника - Иванова Ивана - 10 тугриков\ч. Работает 
    40, 40, 40, 40 чаосов в месяц. Ставка второго сотрудника Петрова Петра - 8 тугриков\ч. Работает 
    40,10,40,50 ч\месяц. Вывести все в виде красивой табличке, алгоритм решения реализовать с помощью ООП.<br><br>";
 
    $col1 = 20;
    $col2 = $col3 = $col4 = $col5 = 8;
 
    // Заголовок таблицы
    echo padRight("Сотрудник", $col1) .
    padLeft("Часы", $col2) .
    padLeft("Ставка", $col3);
    // Решим таким костылем проблему с сверхурочным временем (больше негде его вызывать, и сработать он должен здесь);
    $ivan-> getOvertimeHours();
    $peter->getOvertimeHours();
    echo padLeft("Сверхур.", $col4) .
    padLeft("З/п", $col5) . "<br><br>";
 
    // Сама таблица
    foreach ($employees as $employee) {
        echo padRight($employee->getShortName(), $col1) .
        padLeft($employee->getTotalHoursWorked(), $col2) .
        padLeft($employee->rate, $col3) .
        padLeft($employee->overtm, $col4) .
        padLeft($employee->getSolary(), $col5) . "<br>";
    }
 
    function padRight($str, $col) {         // Функция отступа справа для первых столбцов
        $count = mb_strlen($str);           // Коротко имеется какая-то константная ширина столбца
        if ($count <= $col){                // Если строка уже столбца - мы добавляем нехватающее количество пустых пробелов
            return $str . str_repeat('&ensp;', $col - $count);  // Иначе - оставляем все как есть
        }
        else return ($str);
    }
 
    function padLeft($str, $col) {          // Функция, аналогичная padRight
        $count = mb_strlen($str);           // только считает отступы слева для второг, третьего...последнего столбцов
        if ($count <= $col){
            return str_repeat('&ensp;', $col - $count) . $str;  //
        }
        else return ($str);
        } 
?>