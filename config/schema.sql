CREATE DATABASE task_force_1
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE UTF8_GENERAL_CI;

USE task_force_1;

CREATE TABLE tasks (
	id INT AUTO_INCREMENT PRIMARY KEY,
	customer_id INT REFERENCES users(id),
	executant_id INT REFERENCES users(id),
	city_id INT REFERENCES cities(id),
	posting_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- какой тип данных лучше выбрать, datetime или timezone..
	status VARCHAR(50),
	name VARCHAR(1000),
	description VARCHAR(3000),
	helpful_files VARCHAR(3000),
	location VARCHAR(500),
	payment VARCHAR(500),
	deadline_date TIMESTAMP
);

CREATE TABLE users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	city_id INT REFERENCES cities(id),
	signing_up_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	role VARCHAR(50),
	name VARCHAR(300),
	email VARCHAR(300),
	password VARCHAR(3000),
	avatar VARCHAR(1000),
	birthday DATE,
	self_description VARCHAR(3000),
	accomplished_tasks_photos VARCHAR(5000),
	phone VARCHAR(100),
	skype VARCHAR(100),
	telegram VARCHAR(100),
	is_hidden_contacts BOOLEAN,
	is_hidden_account BOOLEAN,
	is_subscribed_messages BOOLEAN,
	is_subscribed_actions BOOLEAN,
	is_subscribed_reviews BOOLEAN,
	favorite_count INT,
	failure_count INT
);

CREATE TABLE notifications (
	id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT REFERENCES users(id),
	task_id INT REFERENCES tasks(id),
	type VARCHAR(100)
);

CREATE TABLE cities (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100)
);

CREATE TABLE responses (
	id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT REFERENCES users(id),
	task_id INT REFERENCES tasks(id),
	payment INT,
	comment VARCHAR(3000)
);

CREATE TABLE messages (
	id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT REFERENCES users(id),
	task_id INT REFERENCES tasks(id),
	message VARCHAR(3000)
);

CREATE TABLE reviews (
	id INT AUTO_INCREMENT PRIMARY KEY,
	task_id INT REFERENCES tasks(id),
	customer_id INT REFERENCES users(id),
	executant_id INT REFERENCES users(id),
	completion VARCHAR(100),
	comment VARCHAR(3000),
	rating INT
);

CREATE TABLE specializations (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(500)
);





CREATE TABLE lots (
	id INT AUTO_INCREMENT PRIMARY KEY,
	dt_start TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	author INT REFERENCES users(id),
	winner INT REFERENCES users(id)
);

CREATE UNIQUE INDEX lot_id ON lots(id);
CREATE UNIQUE INDEX user_id ON users(id);
CREATE UNIQUE INDEX rate_id ON rates(id);

CREATE INDEX lot_description ON lots(description(128));
CREATE INDEX lot_name ON lots(name);


CREATE FULLTEXT INDEX name_description ON lots (name, description);