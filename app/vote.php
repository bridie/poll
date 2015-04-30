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

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setOptionId($optionId)
	{
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

	public function delete()
	{
		$deleteSql = 'DELETE FROM votes WHERE id = ?';
		$delete = $this->database->executeUpdate($deleteSql, array($this->id));
		return $delete;
	}

	public static function getVoteFromId($id)
	{
		global $database;
		$selectSql = 'SELECT * FROM votes where id = ?';
		$stmt = $database->executeQuery($selectSql, array($id));
		$result = $stmt->fetch();

		$vote = new Static($result['option_id']);
		$vote->setId($result['id']);
		return $vote;
	}

	public static function getVotesFromOptionId($optionId)
	{
		global $database;
		$votes = array();
		$selectSql = 'SELECT * FROM votes WHERE option_id = ?';
		$stmt = $database->executeQuery($selectSql, array($optionId));
		while ($result = $stmt->fetch()) {
			$vote = new Static($result['option_id']);
			$vote->setId($result['id']);
			$votes[] = $vote;
		}
		return $votes;
	}

	public static function countVotes($optionId)
	{
		global $database;
		$selectSql = 'SELECT count(*) as total FROM votes where option_id = ?';
		$stmt = $database->executeQuery($selectSql, array($optionId));
		$result = $stmt->fetch();
		return $result;
	}
}