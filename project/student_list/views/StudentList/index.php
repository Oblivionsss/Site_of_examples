<!DOCTYPE html>
<!-- <html xmlns="http://www.w3.org/1999/xhtml"> -->
<head>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link href="/study/student_list/template/css/main/reset.css" rel="stylesheet"  type="text/css" media="screen" />
    <link href="/study/student_list/template/css/studentList/style.css" rel="stylesheet"  type="text/css" media="screen" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
	<title>Student List</title>
</head>
<body>

	<div class="footer">
		<h1 class="text_welcome">	
			Добро пожаловать!
		</h1>
		<p>
			Это страница со списком студентов
		</p>
	</div>
    <?include(ROOT.'/config/sorting.php')?>


    <div class=" container navigator_menu">
        <div class="link-register">
            <a href="/study/student_list/">На страницу регистрации</a>
        </div>

        <div class="search-result">
            <p><?=(!empty($search) && !empty($list))? "Показаны студенты соответствующие запросу '".h($search)."'" : ''; ?></p>
            <?php if (empty($list)) : ?>
                <p><?= "Студент с такими данными не найден в базе"?></p>
            <?php endif; ?>
        </div>

        <div class="input-block">
            <form class="input-cont" method="get">
                <input type="text" class="" placeholder="Введите имя студента здесь " value="<?=h($search)?>"
                name="search" type="text" size="40">
            </form>
        </div>
    </div>


	<div class="container">
        <table class="table">   
            <thead>
                <tr>

                    <th><a href="<?=getSortingLink('Name', $sort, $dir, $search)?>">Имя<?=getArrow('Name', $sort, $dir)?></a></th>
                    <th><a href="<?=getSortingLink('Surname', $sort, $dir, $search)?>">Фамилия<?=getArrow('Surname',$sort,$dir)?></a></th>
                    <th><a href="<?=getSortingLink('Sex', $sort, $dir, $search)?>">Пол<?=getArrow('Sex',$sort,$dir)?></a></th>
                    <th><a href="<?=getSortingLink('Dateofbirth', $sort, $dir, $search)?>">Год рождения<?=getArrow('Dateofbirth',$sort,$dir)?></a></th>
                    <th><a href="<?=getSortingLink('Groupss', $sort, $dir, $search)?>">Группа<?=getArrow('Groupss',$sort,$dir)?></a></th>
                    <th><a href="<?=getSortingLink('Balls', $sort, $dir, $search)?>">Баллы<?=getArrow('Balls',$sort,$dir)?></a></th>
                    <th><a href="<?=getSortingLink('Email', $sort, $dir, $search)?>">E-mail<?=getArrow('Email',$sort,$dir)?></a></th>
                    <th><a href="<?=getSortingLink('Number', $sort, $dir, $search)?>">Номер телефона<?=getArrow('Number',$sort,$dir)?></a></th>

                </tr>
            </thead>
            <tbody>
                <?php if (!isset($list['Name'])) { 
                foreach ($list as $userInfo){ 
                echo<<<_END
                <tr>
                    <th>{$userInfo['Name']}</th>
                    <td>{$userInfo['Surname']}</td>
                    <td>{$userInfo['Sex']}</td>
                    <td>{$userInfo['Dateofbirth']}</td>
                    <td>{$userInfo['Groupss']}</td>
                    <td>{$userInfo['Balls']}</td>
                    <td>{$userInfo['Email']}</td>
                    <td>{$userInfo['Number']}</td>
                </tr>
_END;
                }}
?> 
                
            </tbody>
        </table>
    </div>
        
</body>
</html>

