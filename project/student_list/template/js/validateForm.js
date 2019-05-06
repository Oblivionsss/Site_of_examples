function validateForename(field)                        // Проверка Имени
{
    return (field == "") ? "Не введено Имя.\n" : "";  
}
function validateSurname(field)                         // Проверка Фамилии
{
    return (field == "") ? "Не введена Фамилия.\n" : "";
}

function validatedateBrth (field)
{
    var arr = field.split('-');
    var date = new Date();
    if (field == "")
        return "Не указана дата рождения.\n";

    else if ( arr[0] < 1940 || arr[0] > (date.getFullYear()-16) )       // Минимально допустимый вораст студента
        return "Указана некорректная дата рождения.\n";

    else 
        return "";  
}

function validateNumberOfGr(field)
{
    return (field == "") ? "Не указан номер группы.\n" : "";
}

function validateBalls(field)
{
    if (field == "") return "Не указано количество баллов.\n";

    else if ( field <= 400 && field >= 100 )
        return "";

    else return "Некорректное значение баллов (минимальное  количество баллов должно быть более 100, должно не превышать 400).\n";
}

function validateEmail(field) {
    if (field == "") return "Не введен адрес электронной почты.\n";

    else if (!((field.indexOf(".") > 0) &&
        (field.indexOf("@") > 0)) ||
        /[^a-zA-Z0-9.@_-]/.test(field))
        return "Электронный адрес имеет неверный формат.\n";

    else return "";
}

function validateNumberOfTel(field)
{
    if (field == "") return "Не указан номер телефона.\n";

    else if ( !(/^((\+\s?7)|8)([-\s()]{0,3})(\d[-\s()]{0,3}){10}$/.test(field)) ) 
        return "Некорректный номер телефона.\n";

    else return "";
}