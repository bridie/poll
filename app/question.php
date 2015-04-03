<?php

namespace App;

use App\RandomStringGenerator;

class Question
{
	private $id;
	private $question;
	private $urlComponent;
	private $database;

	public function __construct($question)
	{
		global $database;
		$this->question = $question;
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

	public function create()
	{
		$urlComponent = self::createUrlComponent();
		$insertSql = 'INSERT INTO questions (question_value, url_component) VALUES (?, ?)';
		$insert = $this->database->executeUpdate($insertSql, array($this->question, $urlComponent));

		if ($insert) {
			$this->id = $this->database->lastInsertId();
			$this->urlComponent = $urlComponent;
		}

		return $insert;
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

	public static function getQuestionFromUrlComponent($urlComponent)
	{
		global $database;
		$sql = 'SELECT * FROM questions WHERE url_component = ?';
		$questionData = $database->fetchAssoc($sql, array($urlComponent));

		$question = new Static($questionData['question_value']);
		$question->id = $questionData['id'];
		$question->urlComponent = $questionData['url_component'];

		return $question;
	}
}