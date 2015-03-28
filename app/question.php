<?php

namespace App;

use App\RandomStringGenerator;

class Question
{
	private $id;
	private $question;
	private $urlComponent;
	private $database;

	public function __construct($database)
	{
		$this->database = $database;
	}

	public function getQuestion()
	{
		return $this->question;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getUrlComponent()
	{
		return $this->urlComponent;
	}

	public function create($question)
	{
		$urlComponent = self::createUrlComponent();
		$insertSql = 'INSERT INTO questions (question_value, url_component) VALUES (?, ?)';
		$insert = $this->database->executeUpdate($insertSql, array($question, $urlComponent));

		if ($insert) {
			$selectSql = 'SELECT * FROM questions WHERE url_component = ?';
			$question = $this->database->fetchAssoc($selectSql, array($urlComponent));

			$this->id = $question['id'];
			$this->question = $question['question_value'];
			$this->urlComponent = $question['url_component'];
		} else {
			return false;
		}
	}

	private function createUrlComponent()
	{
		$urlComponent = RandomStringGenerator::generateString(20);

		$selectSql = 'SELECT * FROM questions WHERE url_component = ?';
		$question = $this->database->fetchAssoc($selectSql, array($urlComponent));

		if (empty($question)) {
			return $urlComponent;
		} else {
			$this->createUrlComponent();
		}
	}
}