<?php

class ListController 
    {
        public $pages       = [];       // Здесь будем хранить данные

        public function __construct()
        {
            $list           = [];                       
            $result         = $this->getInfoFromDatabase(true, 0);     // Принимаем количество строк

            if (empty($result)) {
                $studentsList   = new StudentList($result);         // Вариант при котором ничего не найдено по запросу
                $list           = $studentsList->getAddNewUserInfo();

            }
            else {
                $page           = $result[0]['COUNT(*)'];
                $cnt            = ceil($page / 6); // Параметры округления

                
                if ($cnt == 0) {
                    $list           = [];
                }
                else if ($cnt <= 1) {
                    $this->pages    = [];
                    $studentsList   = new StudentList($this->getInfoFromDatabase(false, 0));         // Вариант при котором ничего не найдено по запросу
                    $list           = $studentsList->getAddNewUserInfo();
                }
                else {
                    for ($j = 1; $j <= $cnt; $j++)
                        $this->pages[$j-1]  = $j;
                    $studentsList   = new StudentList($this->getInfoFromDatabase(false, $cnt));         // Вариант при котором ничего не найдено по запросу
                    $list           = $studentsList->getAddNewUserInfo();

                }

            }

            $viewReg        = ROOT.'/views/StudentList/index.php'; 
            include($viewReg);
        }

        public function getInfoFromDatabase($bool, $numbOfPage)
        {      
            $post           = $this->getInfo();
            if ($post) {
                return InfoAllStudents::getSortInfoAboutStudents($post, $bool, $numbOfPage);
            }
            else {
                return InfoAllStudents::getInfoAboutStudents($bool, $numbOfPage);
            }
        }
        
        public function getInfo()
        {   
            $mas            = [];

            if (!empty($_GET)) {
                foreach ($_GET as $key => $value)
                    $mas[$key] = $value;
                return $mas;
            }

            return false;

        }
    }
    