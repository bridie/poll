<?php

namespace App;

class Option
{
	private $id;
	private $questionId;
	private $option;
	private $database;

	public function __construct($option, $database)
	{
		$this->database = $database;
		$this->option = $option;
	}

	public function setQuestionId($questionId)
	{
		$this->questionId = $questionId;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getQuestionId()
	{
		return $this->questionId;
	}

	public function getOption()
	{
		return $this->option;
	}

	public function create()
	{
		$insertSql = 'INSERT INTO options (question_id, option_value) VALUES (?, ?)';
		$insert = $this->database->executeUpdate($insertSql, array($this->questionId, $this->option));

		if ($insert) {
			$this->id = $this->database->lastInsertId();
		}

		return $insert;
	}
}