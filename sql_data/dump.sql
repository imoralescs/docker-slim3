CREATE TABLE users (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	firstname VARCHAR(255) NOT NULL,
	lastname VARCHAR(255) NOT NULL,
	username VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL,
	password VARCHAR(255) NULL,
	balance DECIMAL(15,2),
	reg_date TIMESTAMP
);

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `balance`, `reg_date`) VALUES ('1', 'Alex', 'Jones', 'alex_707', 'alex.jones@gmail.com', '', '100', CURRENT_TIMESTAMP);
INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `balance`, `reg_date`) VALUES ('2', 'Bob', 'Cooper', 'cooper_b', 'bob.cooper@gmail.com', '', '102', CURRENT_TIMESTAMP);
INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `balance`, `reg_date`) VALUES ('3', 'Cassidy', 'Grayson', 'gray', 'cassidy.grayson@gmail.com', '', '121', CURRENT_TIMESTAMP);
INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `balance`, `reg_date`) VALUES ('4', 'Daniella', 'Georgette', 'dani_86', 'daniella.georgette@gmail.com', '', '200', CURRENT_TIMESTAMP);
INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `balance`, `reg_date`) VALUES ('5', 'Steve', 'Manette', 'smanette', 'steve.manette@gmail.com', '', '130', CURRENT_TIMESTAMP);

CREATE TABLE topics (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(30) NOT NULL,
	body TEXT NOT NULL,
	reg_date TIMESTAMP
);

INSERT INTO `topics` (`id`, `title`, `body`, `reg_date`) VALUES ('1', 'Topic 1', 'Topic 1 Text Body', CURRENT_TIMESTAMP);
INSERT INTO `topics` (`id`, `title`, `body`, `reg_date`) VALUES ('2', 'Topic 2', 'Topic 2 Text Body', CURRENT_TIMESTAMP);
INSERT INTO `topics` (`id`, `title`, `body`, `reg_date`) VALUES ('3', 'Topic 3', 'Topic 3 Text Body', CURRENT_TIMESTAMP);
INSERT INTO `topics` (`id`, `title`, `body`, `reg_date`) VALUES ('4', 'Topic 4', 'Topic 4 Text Body', CURRENT_TIMESTAMP);
