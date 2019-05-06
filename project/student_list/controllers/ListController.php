<?php

class ListController 
    {
        public function __construct()
        {
            $list           = [];
            $result         = $this->getInfoFromDatabase();
            if ($result) {
                $studentsList   = new StudentList($result);
                $list           = $studentsList->getAddNewUserInfo();        
            }   
        
            $viewReg        = ROOT.'/views/StudentList/index.php'; 
            include($viewReg);
        }

        public function getInfoFromDatabase()
        {      
            $post           = $this->getInfo();
            if ($post) {
                return InfoAllStudents::getSortInfoAboutStudents($post);
            }
            else {
                return InfoAllStudents::getInfoAboutStudents();
            }
        }
        
        public function getInfo()
        {   
            $mas            = [];
            if (isset($_GET['search'])) {
                $mas['search'] = $_GET['search'];

                if (isset($_GET['sort'])) {
                    $mas['sort'] = $_GET['sort'];

                    if (isset($_GET['dir'])) {
                        $mas['dir'] = $_GET['dir'];
                    }
                    
                    return $mas;
                }
                
                return $mas;
            }

            return false;
        }
    }
    