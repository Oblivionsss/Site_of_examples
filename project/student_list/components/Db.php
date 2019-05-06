<?php

class Db
{
		public static function getConnection()
		{
			$paramsPath = ROOT . '/config/db_params.php';
			$params = include($paramsPath);

			$sql = "mysql:host={$params['host']};dbname={$params['dbname']}";
			$opt = array(
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			);
			
			try {
				$db = new PDO($sql, $params['user'], $params['password'], $opt);
				return $db;
			} catch (PDOException $e) {
				return $e->getMessage();
			}
		}
}