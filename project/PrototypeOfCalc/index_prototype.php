<?php
	header('Content-Type: text/html; charset=utf-8');
    if (isset($_POST['number'])){
        $input = $_POST['number'];

        $inputLength = strlen($input);
        $result = 0;            // Текущий результат

        function getNumbers($count, $input, $length){                   // Функция вычленения числа
                $numb = '';                                             // Сюда будем "складывать" цифры 
                for (; $count < $length; $count++){                     // Запускаем цикл начинающийся с текущего "указателя"
                    $crNumb = mb_substr ($input, $count, 1);            // Получаем значение цифры
                    if ($crNumb == '+' || $crNumb == '-' || $crNumb == '*'|| $crNumb == '/'){    
                        // Если встретили знак, выходим из функции
                        break;
                    }
                    $numb .= $crNumb;                                   // "Складываем" цифры в число
                }
                return (is_numeric($numb)) ? $numb : 0;                 // Проверяем число 
        }

        for ($i = 0; $i < $inputLength; $i++){      
            $currNumb = mb_substr ($input, $i, 1);                      // Поэлементно перебираем строку

            if ($currNumb == '+' || $currNumb == '-' || $currNumb == '*' || $currNumb == '/' || $i == 0){ 
                
                if ($i == 0)
                    $getNumber = intval (getNumbers($i, $input, $inputLength));
                else
                    $getNumber = intval (getNumbers($i + 1, $input, $inputLength));     // Вызываем функцию, которая вычленяет целое число,
                // идущее за знаком. Передаем "указатель" на номер элемента строки, и саму строку

                switch ($currNumb) {                                // Реализуем мат.операции в зависимости от знака
                    case '+':
                        $result += $getNumber;
                        break;

                    case '-':
                        $result -= $getNumber;
                        break;

                    case '*':
                        $result *= $getNumber;
                        break;

                    case '/':
                        $result /= $getNumber;
                        break;

                    default:
                        $result += $getNumber;
                        break;  
                }
            }
        }     
    }

    else {
        $result = 0;
        $input = 0;
    } 
    // Теперь выведем результат с помощью формы
    echo <<<_END
    Текущий результат: $result
    <br>
    <Данная программа вычисляет значение, введеное в форму ниже><br>
    <Форма ввода: число+знак+число+....+число и нажимайте вычислить><br>
    <Пример ввода: 3-13+2324 ><br>
    <Доступные знаки +-*/>
    <form action="idex_prototype.php" method="post">
    <input type="text" name="number" value="$input">
    <input type="submit" value="Вычислить"></form>
_END;
?>