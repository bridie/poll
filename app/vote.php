<?php

namespace App;

class Vote
{
	private $id;
	private $optionId;
	private $database;

	public function __construct($optionId)
	{
		global $database;
		$this->database = $database;
		$this->optionId = $optionId;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getOptionId()
	{
		return $this->optionId;
	}

	public function create()
	{
		$insertSql = 'INSERT INTO votes (option_id) VALUES (?)';
		$insert = $this->database->executeUpdate($insertSql, array($this->optionId));

		if ($insert) {
			$this->id = $this->database->lastInsertId();
			return $this;
		}

		return $insert;
	}
}