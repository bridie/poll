create TABLE IF NOT EXISTS questions (
	id int(11) NOT NULL AUTO_INCREMENT,
	question_value varchar(255) DEFAULT '',
	url_component varchar(255) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE KEY (url_component)
) ENGINE=InnoDB