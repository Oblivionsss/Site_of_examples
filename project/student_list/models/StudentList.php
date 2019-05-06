    <?php

    class StudentList
    {   
        public $array  = [];

        public function __construct($param) 
        {
            foreach ($param as $key => $value) {
                $this->array[$key]    = $value;
            }

        }

        public function getAddNewUserInfo()
        {
            return $this->array;
        }
    }