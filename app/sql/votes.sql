create TABLE IF NOT EXISTS votes (
	id int(11) NOT NULL AUTO_INCREMENT,
	option_id int(11) NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB