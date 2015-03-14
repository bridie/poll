create TABLE IF NOT EXISTS options (
	id int(11) NOT NULL AUTO_INCREMENT,
	question_id int(11) NOT NULL,
	option_value varchar(255) DEFAULT '',
	PRIMARY KEY (id)
) ENGINE=InnoDB