CREATE DATABASE task_force_1
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE UTF8_GENERAL_CI;

USE task_force_1;


CREATE TABLE cities (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100)
);

CREATE TABLE users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	city_id INT REFERENCES cities(id) ON DELETE RESTRICT,
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
	failure_count INT,
	INDEX city_id (city_id)
);

CREATE TABLE tasks (
	id INT AUTO_INCREMENT PRIMARY KEY,
	customer_id INT REFERENCES users(id) ON DELETE RESTRICT,
	executant_id INT REFERENCES users(id) ON DELETE RESTRICT,
	city_id INT REFERENCES cities(id) ON DELETE RESTRICT,
	posting_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
	status VARCHAR(50),
	name VARCHAR(1000),
	description VARCHAR(3000),
	helpful_files VARCHAR(3000),
	location VARCHAR(500),
	payment VARCHAR(500),
	deadline_date TIMESTAMP,
	FULLTEXT INDEX name_description (name, description),
	INDEX customer_id (customer_id),
	INDEX executant_id (executant_id),
	INDEX city_id (city_id)
);

CREATE TABLE notifications (
	id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT REFERENCES users(id),
	task_id INT REFERENCES tasks(id),
	type VARCHAR(100)
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

CREATE TABLE userSpecialization (
	user_id INT REFERENCES users(id) ON DELETE CASCADE,
	specialization_id INT REFERENCES specializations(id) ON DELETE CASCADE,
	PRIMARY KEY (user_id, specialization_id)
);

CREATE TABLE taskSpecialization (
	task_id INT REFERENCES tasks(id) ON DELETE CASCADE,
	specialization_id INT REFERENCES specializations(id) ON DELETE CASCADE,
	PRIMARY KEY (task_id, specialization_id)
);