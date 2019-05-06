<!DOCTYPE html>
<!-- <html xmlns="http://www.w3.org/1999/xhtml"> -->
<head>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<title>Register</title>
	<link href="/study/student_list/template/css/main/reset.css" rel="stylesheet"  type="text/css" media="screen" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
	<link href="/study/student_list/template/css/main/style.css" rel="stylesheet"  type="text/css" media="screen" />
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
	<script src="/study/student_list/template/js/validateForm.js"></script>
	<script>
		function validate(form) {
			fail = validateForename(form.name.value);
			fail += validateSurname(form.surname.value);

			fail += validatedateBrth(form.dateOfBirth.value);
	
			fail += validateNumberOfGr(form.numberOfGroups.value);
			fail += validateBalls(form.balls.value);
			fail += validateEmail(form.e_mail.value);
			fail += validateNumberOfTel(form.number.value);

			if (fail == "") 
				return true;

			else { alert(fail); return false };	
		}
	</script>
	

</head>
<body>
	<div class="footer">
		<h1 class="text_welcome">	
			Добро пожаловать!
		</h1>
		<p>
			Вы попали на страницу регистрации, пожалуйста, введите / или обновите свои данные, либо перейдите к списку студентов
		</p>
	</div>
	<div class="container">


		<div class="row main-form">
			<form class="" method="post" action="" onSubmit="return validate(this)">

			<div class="form-group">
				<label for="name" class="cols-sm-2 control-label">Имя</label>
				<div class="cols-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
						<input type="text" class="form-control" name="name" placeholder="Введите Ваше имя"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="name" class="cols-sm-2 control-label">Фамилия</label>
				<div class="cols-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
						<input type="text" class="form-control" name="surname" placeholder="Введите Вашу фамилию"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<!--  -->
					<div class="cols-sm-10 float-left">
							<label for="email" class="cols-sm-2 control-label">Укажите ваш пол</label>
						<div class="input-group">
							<span class="input-group-addon input-group-half"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
							<input type="radio"  name="radio" 	value="man" checked> Man<br>
							<input type="radio"  name="radio" 	value="woman"> Woman<br>
						</div>
					</div>

				<div class="input_block">
					<div class="cols-sm-10 float-left">
							<label for="username" class="cols-sm-2 control-label">Год рождения</label>
						<div class="input-group">
							<span class="input-group-addon input-group-half"><i class="fa fa-users fa" aria-hidden="true"></i></span>
							<input type="date" class="form-control" name="dateOfBirth"/>
						</div>
					</div>
				</div>
				<!--  -->
			</div>

			<div class="form-group">
				<label for="password" class="cols-sm-2 control-label">Номер группы</label>
				<div class="cols-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
						<input type="text" class="form-control" name="numberOfGroups"  placeholder="Введите номер группы"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="confirm" class="cols-sm-2 control-label">Баллы ЕГЭ</label>
				<div class="cols-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
						<input type="text" class="form-control" name="balls" placeholder="Укажите сумму баллов ЕГЭ"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="confirm" class="cols-sm-2 control-label">E-mail</label>
				<div class="cols-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
						<input type="text" class="form-control" name="e_mail" placeholder="Укажите ваш е-мэйл"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="confirm" class="cols-sm-2 control-label">Номер телефона</label>
				<div class="cols-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
						<input type="text" class="form-control" name="number"  placeholder="Действующий номер телефона (формат ввода 89776812222)"/>
					</div>
				</div>
			</div>

			<div class="form-group ">
				<input type="submit" class="btn btn-primary btn-lg btn-block login-buttonl" name="confirm"  placeholder="Зарегестрироваться"/>
			</div>

		</form>
		
		<div class="form-group ">
				<!-- <input type="submit" class="btn btn-primary btn-lg btn-block login-buttonl" name="confirm"  placeholder="Зарегестрироваться"/> -->
				<a href="/study/student_list/list/" class="btn btn-primary btn-lg btn-block login-buttonl">К списку студентов</a>
		</div>

</body>
</html>

