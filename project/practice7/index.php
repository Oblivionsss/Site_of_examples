<?php
    header('Content-Type: text/html; charset=utf-8');
    // Задача 
    // В большой международной перспективной компании «Вектор» есть 4 департамента: 
    // департамент закупок, продаж, рекламы и логистики. 
    // В этих 4 департаментах работают менджеры (ме), 
    // маркетологи (ма), инженеры (ин) и аналитики (ан).

    // Реализовать с помощью классов

    // Краткое описание решения - создаем класс компания, в котором вызываем 4 объекта - департамента
    // являющимися наследниками одного класса, каждый из департаментов содержит определенное количество людей в штате
    // Сотрудники 4 видов также являются наследниками одного общего абстрактного класса.
    // v1.0

    class company {
                                    // Здесь юзаем тайп-хинты, явно задавая тип передаваемого аргумента\c
        public function __construct(pursh $pursh, sales $sales, adve $adve, logist $logist) {   // Композиция - создаваемые объекты хранятся в свойствах класса
            $this->pursh    = $pursh;   // Создаем экз. департамент закупок,
            $this->sales    = $sales;   // экз. департамента продаж,
            $this->adve     = $adve;    // экз. департаменты рекламы,
            $this->logist   = $logist;  // экз. деп. логистики
        }   

        public function print_data() {
            $col1       = 20;           // Отступы для формирования полей таблицы
            $col2       = 12;

            $totalNum   = 0;            // Количество людей по всем департаментам
            $totalSol   = 0;            // Общий фонд зп
            $totalCof   = 0;            // и т.д.
            $totalPag   = 0;

 
            // Заголовок таблицы
            echo $this->padRight("Департамент",$col1) .
            $this->padLeft("Сотрудники",       $col2) .
            $this->padLeft("Тугрики",          $col2) .
            $this->padLeft("Кофе",             $col2) .
            $this->padLeft("Страницы",         $col2) . 
            $this->padLeft("Тугр. / стр.",     $col2) . "<br><br>";

            // Осноная часть таблицы, с выводом данных по каждому департаменту
            $numbOfDep      = 0;                            // Количество департаментов
            foreach ($this as $depart) {
                echo $this->padRight($depart->nameDepart,          $col1) .
                $this->padLeft($depart->getNumbOfDepart(),         $col2) .
                $this->padLeft($depart->getTotalSolary(),          $col2) .
                $this->padLeft($depart->getTotalCoffe(),           $col2) .
                $this->padLeft($depart->getTotalPage(),            $col2) .
                $this->padLeft($depart->getSolaryPerPage(),        $col2) . "<br>";
                $numbOfDep++;
            }

            // Расчитываем значения для среднего значения и для итогового показателя
            // Не додумался как эту шляпу вынести в отдельную функциию
            foreach ($this as $value) {
                $totalNum += $value->getNumbOfDepart();
                $totalSol += $value->getTotalSolary();
                $totalCof += $value->getTotalCoffe();
                $totalPag += $value ->getTotalPage();
            }

            // Завершающая часть таблицы
            // Выводим средние значения
            echo $this->padRight("Среднее",                $col1) .
            $this->padLeft(round($totalNum / $numbOfDep),  $col2) .
            $this->padLeft(round($totalSol / $numbOfDep),  $col2) .
            $this->padLeft(round($totalCof / $numbOfDep),  $col2) .
            $this->padLeft(round($totalPag / $numbOfDep),  $col2) .
            $this->padLeft(round($totalSol / $totalPag, 1),$col2) . "<br><br>";
            // Выводим общее значение
            echo $this->padRight("Всего",                  $col1) .
            $this->padLeft($totalNum,                      $col2) .
            $this->padLeft($totalSol,                      $col2) .
            $this->padLeft($totalCof,                      $col2) .
            $this->padLeft($totalPag,                      $col2) .
            $this->padLeft(round($totalSol / $totalPag, 1),$col2) . "<br>";
        } 

        private function padRight($str, $col) { // Функция отступа справа для первых столбцов
            $count = mb_strlen($str);           // Коротко имеется какая-то константная ширина столбца
            if ($count <= $col){                // Если строка уже столбца - мы добавляем нехватающее количество пустых пробелов
                return $str . str_repeat('&ensp;', $col - $count);  // Иначе - оставляем все как есть
            }
            else return ($str);
        }
     
        private function padLeft($str, $col) {  // Функция, аналогичная padRight
            $count = mb_strlen($str);           // только считает отступы слева для второго, третьего...последнего столбцов
            if ($count <= $col){
                return str_repeat('&ensp;', $col - $count) . $str; 
            }
            else return ($str);
        }
    }

    $comp   = new company(new pursh, new sales, new adve, new logist);          // Создаем главный экземпляр, из которого создадутся остальные
    $comp->print_data();    // Вызываем всю цепочку

    abstract class departament {
        protected $mas = array();                   // Вспомогательный массив, содержащий объекты - где в качестве объектов выступает
                                                    // количество сотрудников определенного ранга
        protected $numbOfEmploee    = 0;            // Количество сотрудников в департаменте
        protected $totalSalary      = 0;            // Фонд з/п  
        protected $totalCofee       = 0;            // Литро кофе, выпитого сотрудниками данного департамента
        protected $totalPage        = 0;            // Страниц документов
        public $nameDepart;                         // Название департамента для финальной таблицы 


        public function getNumbOfDepart() {
            $this->numbOfEmploee    = 0;            // Сбрасываем значение, для повторного вызова
            foreach ($this->mas as $value) {
                $this->numbOfEmploee += $value->number;
            }
            return $this->numbOfEmploee;             // Возвращаем количество сотрудников департамента
        }

        public function getTotalSolary() {
            $this->totalSalary      = 0;
            foreach ($this->mas as $value) {
                $this->totalSalary += $value->getSolary();
            }
            return $this->totalSalary;               // Возвращаем фонд зп департамента
        }

        public function getTotalCoffe() {
            $this->totalCofee      = 0;
            foreach ($this->mas as $value) {
                $this->totalCofee += $value->getCoffe();
            }
            return $this->totalCofee;                // Возвращаем суммарный объем выпитого кофе департамента
        }

        public function getTotalPage() {
            $this->totalPage        = 0;
            foreach ($this->mas as $value) {
                $this->totalPage += $value->getPage();
            }
            return $this->totalPage;                 // Возвращаем суммарный объем напечатанных страниц
        }

        public function getSolaryPerPage() {
            return round($this->totalSalary / $this->totalPage, 1);
        }                                           // Возвращаем ЗП на одну напечатанную страницу
    }

    class pursh extends departament {                   // Определяем класс закупки с необходимы количеством сотрудников
        public $nameDepart  = 'Закупок';
        public function __construct() {                 // Инициализируем конструктором объектов-сотрудников
            $meneg9_1    = new meneger (9, 1, 0);       // 9 менеджеров 1 ранга
            $meneg3_2    = new meneger (3, 2, 0);   
            $meneg2_3    = new meneger (2, 3, 0);
            $market2_2   = new market (2, 2, 0);
            $rdepartmmeneg2 = new  meneger (1, 2, 1);
            array_push($this->mas, $meneg9_1, $meneg3_2, $meneg2_3, $market2_2, $rdepartmmeneg2);
        }   
    } 

    class sales extends departament {                   // класс - департамент продаж
        public $nameDepart = 'Продаж'; 
        public function __construct() { 
            $meneg12_1  = new meneger (12, 1, 0);   
            $market6_1  = new market (6, 1, 0);   
            $analit3_1  = new analit (3, 1, 0);
            $analit2_2  = new analit (2, 2, 0);
            $departmarket2  = new market (1, 2, 1);
            array_push($this->mas, $meneg12_1, $market6_1, $analit3_1, $analit2_2, $departmarket2); 
        }
    }   
    class adve extends departament {                    // класс - департамент рекламы
        public $nameDepart = 'Рекламы'; 
        public function __construct() {
            $market15_1  = new market (15, 1, 0);   
            $market10_2  = new market (10, 2, 0);   
            $meneg8_1    = new meneger (8, 1, 0);
            $ingen2_1    = new ingen (2, 1, 0);
            $departmarket3  = new market (1, 3, 1);
            array_push($this->mas, $market15_1, $market10_2, $meneg8_1, $ingen2_1, $departmarket3); 
        }
    }

    class logist extends departament {                  // класс - департамент логистики
        public $nameDepart = 'Логистики'; 
        public function __construct() {
            $meneg13_1   = new meneger (13, 1, 0);   
            $meneg5_2    = new meneger (5, 2, 0);   
            $ingen5_1    = new ingen (5, 1, 0);
            $rdepartmmeneg1 = new meneger (1, 1, 1);
            array_push($this->mas, $meneg13_1, $meneg5_2, $ingen5_1, $rdepartmmeneg1); 
        }
    }


    abstract class Employee {
        public function __construct($number, $range, $checkBoss) {      // Функция принимающая количество и ранг сотрудников, а также проверку на руководителя
            $this->range    = $range;                       // Ранг сотрудника
            $this->number   = $number;                      // Количество сотрудников этого ранга
            $this->checkBoss = $checkBoss;                  // Проверка на руководителя

            switch ($this->range) {                         // Определяем корректировку ЗП  зависимости от ранга сотрудника
                case '1':
                    $this->range = 1;
                    break;
    
                case '2':
                    $this->range = 1.25;
                    break;
    
                case '3':
                    $this->range = 1.5;
                    break;
            }

            switch ($this->checkBoss) {
                case '1':
                    $this->bossRateCoeff    = 1;
                    $this->bossCoffeCoeff   = 2;
                    $this->bossPagesCoeff   = 0;            // Чтобы не нагружать функцию getPage лишними условиями просто обнулим возвращаемый результат
                    break;
                
                case '0':
                    $this->bossRateCoeff    = 1;
                    $this->bossCoffeCoeff   = 1;
                    $this->bossPagesCoeff   = 1;
                    break;
            }
        }

        public function getSolary() {                       // Функция, возвращающая зп
            return $this->calary * $this->range * $this->number * $this->bossRateCoeff; 
        }

        public function getCoffe() {                        // Функция, возвращающая кофе
            return $this->cofee * $this->number * $this->bossCoffeCoeff;
        }

        public function getPage() {
            return $this->pages * $this->number * $this->bossPagesCoeff;
        }

        protected $сalary;                     // Ставка зп текущего сотрудника
        protected $сofee;                      // Сколько пьет кофе
        protected $pages;                      // Сколько печатает страниц
    }

    class meneger extends Employee {
        protected $calary  = 500;
        protected $cofee   = 20;
        protected $pages   = 200;
    }

    class market extends Employee {
        protected $calary  = 400;
        protected $cofee   = 15;
        protected $pages   = 150;
    }

    class ingen extends Employee {
        protected $calary  = 200;
        protected $cofee   = 5;
        protected $pages   = 50;
    }

    class analit extends Employee {
        protected $calary  = 800;
        protected $cofee   = 50;
        protected $pages   = 5;
    }
?>