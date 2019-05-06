<?php

class RegisterController 
    {
        public function __construct()
        {

            if (!empty($_COOKIE)) {
                $cookies        = $this->getCookie();
                $infoStudents   = $this->checkCookies($cookies);

                if ($infoStudents) {

                    if (empty($_POST)) {
                        $obj2       = new Student ($this->getInfoUser($infoStudents));
                        $user       = $obj2->getAddNewUserInfo();
                        $view_Reg   = ROOT.'/views/auth/index.php';
                        include($view_Reg);
                    }

                    else if (!empty($_POST)) {
                        $obj2       = new Student ($this->getPost());
                        Register::setInfo($obj2->getAddNewUserInfo(), $cookies[0][0]);
                        echo header("location: index.php");
                    }

                }      
                else $this->actionRegister();              
            }

            else if (empty($_COOKIE)) {

                if (!empty($_POST)) {

                    $obj2       = new Student($this->getPost());
                    $lastId     = Register::addNewUser($obj2->getAddNewUserInfo());

                    if ($lastId) { 
                        $this->addCookie($lastId);
                        echo header("location: index.php");
                    }
                }

                else if (empty($_POST)) {
                    $this->actionRegister();
                }
            }
        }

        // Include defaultView
        public function actionRegister() 
        {
            $viewReg        = ROOT.'/views/register/index.php'; 
            include($viewReg);
        }

        // Get Post-Mass-data
        public function getPost() 
        {   
            $param          = [];                           // Массив, которые будет содержть аргументы для запроса в БД
            foreach ($_POST as $key => $value){
                if($key == 'confirm')
                    break;
                $param[$key]    = $value;
            }
            return $param;
        }
        
        // Validations info about Users
        public function getInfoUser($userInfo)
        {
            $param          = [];
            foreach ($userInfo[0] as $key => $value) {
                if ($key == 'ID')
                    continue;
                if ($key == "cookie")
                    break;
                $param[$key]    = $value;
            }
            return $param;
        }

        // Add Cookie in DataBases and cookies users Browsers
        public function addCookie($lastId)
        {
            $key            = Auth::generateSalt();

            Register::addCookieBase($key, $lastId);
            Auth::setCookie($key, $lastId);
        }

        // Get cookie
        public function getCookie()
        {
            if (!empty($_COOKIE['ID']) && !empty($_COOKIE['key'])){
                $param      = [];
                array_push($param, array($_COOKIE['ID'], $_COOKIE['key']));
                return $param;
            }
            else return false;
        }

        public function checkCookies($param)
        {   
            if($param) {
                $result     = Register::checkCookie($param[0][0], $param[0][1]);
                return $result;
            }
            else return false; 
        }
    }