<?php

namespace App;

class Option
{
	private $id;
	private $questionId;
	private $option;
	private $database;

	public function __construct($option)
	{
		global $database;
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

	public static function getOptionsFromQuestionId($questionId)
	{
		global $database;
		$sql = 'SELECT * FROM options WHERE question_id = ?';
		$optionData = $database->fetchAll($sql, array($questionId));
		$options = array_map(array(self, 'getOptionObjects'), $optionData);
		return $options;
	}

	private static function getOptionObjects($optionData)
	{
		$option = new Static($optionData['option_value']);
		$option->id = $optionData['id'];
		$option->questionId = $optionData['question_id'];
		return $option;
	}
}