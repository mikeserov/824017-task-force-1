CREATE DATABASE task_force_1
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE UTF8_GENERAL_CI;

USE task_force_1;


CREATE TABLE cities (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100)
);

CREATE TABLE users (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	city_id INT NOT NULL UNSIGNED REFERENCES cities(id) ON DELETE RESTRICT,
	signing_up_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	role VARCHAR(50) NOT NULL,
	name VARCHAR(300) NOT NULL,
	email VARCHAR(300) NOT NULL,
	password VARCHAR(3000) NOT NULL,
	avatar VARCHAR(1000),
	birthday DATE,
	description VARCHAR(3000),
	accomplished_tasks_photos VARCHAR(5000),
	phone VARCHAR(100),
	skype VARCHAR(100),
	telegram VARCHAR(100),
	favorite_count INT UNSIGNED,
	failure_count INT UNSIGNED,
	INDEX city_id (city_id)
);

CREATE TABLE users_accomplished_tasks_photos (
	user_id INT UNSIGNED PRIMARY KEY REFERENCES users(id) ON DELETE CASCADE --ПРОВЕРИТЬ ЧТО СОЗДАЛСЯ ИНДЕКС
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	accomplished_tasks_photos VARCHAR(5000),
	PRIMARY KEY (user_id, task_id),
	INDEX user_id (user_id),
	INDEX task_id (task_id)
);



CREATE TABLE users_optional_settings (
	user_id INT UNSIGNED PRIMARY KEY REFERENCES users(id) ON DELETE CASCADE --ПРОВЕРИТЬ ЧТО СОЗДАЛСЯ ИНДЕКС
	is_hidden_contacts BOOLEAN,
	is_hidden_account BOOLEAN,
	is_subscribed_messages BOOLEAN,
	is_subscribed_actions BOOLEAN,
	is_subscribed_reviews BOOLEAN
)

CREATE TABLE tasks (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	customer_id INT UNSIGNED REFERENCES users(id) ON DELETE RESTRICT,
	executant_id INT UNSIGNED REFERENCES users(id) ON DELETE RESTRICT,
	city_id INT UNSIGNED REFERENCES cities(id) ON DELETE RESTRICT,
	posting_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
	status VARCHAR(50),
	name VARCHAR(1000) NOT NULL,
	description VARCHAR(3000) NOT NULL,
	helpful_files VARCHAR(3000),
	location VARCHAR(500),
	payment VARCHAR(500),
	deadline_date TIMESTAMP,
	FULLTEXT INDEX name_description (name, description),
	INDEX customer_id (customer_id),
	INDEX executant_id (executant_id),
	INDEX city_id (city_id)
);

CREATE TABLE notifications_history (
	user_id INT UNSIGNED REFERENCES users(id) ON DELETE CASCADE,
	task_id INT UNSIGNED REFERENCES tasks(id) ON DELETE CASCADE,
	type ENUM('message', 'action', 'review'),
	description VARCHAR(500),
	PRIMARY KEY (user_id, task_id),
	INDEX user_id (user_id),
	INDEX task_id (task_id)
);

CREATE TABLE responses (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_id INT UNSIGNED REFERENCES users(id) ON DELETE CASCADE,
	task_id INT UNSIGNED REFERENCES tasks(id) ON DELETE CASCADE,
	payment INT UNSIGNED,
	comment VARCHAR(3000),
	INDEX user_id (user_id),
	INDEX task_id (task_id)
);

CREATE TABLE chat_messages (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_id INT UNSIGNED REFERENCES users(id) ON DELETE SET NULL,
	task_id INT UNSIGNED REFERENCES tasks(id) ON DELETE SET NULL,
	message VARCHAR(3000),
	INDEX user_id (user_id),
	INDEX task_id (task_id)
);

CREATE TABLE reviews (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	task_id INT UNSIGNED REFERENCES tasks(id) ON DELETE SET NULL,
	customer_id INT UNSIGNED REFERENCES users(id) ON DELETE SET NULL,
	executant_id INT UNSIGNED REFERENCES users(id) ON DELETE CASCADE,
	is_accomplished VARCHAR(100) NOT NULL,
	comment VARCHAR(3000),
	rating INT UNSIGNED,
	INDEX task_id (task_id),
	INDEX customer_id (customer_id),
	INDEX executant_id (executant_id)
);

CREATE TABLE specializations (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(500)
);

CREATE TABLE user_specialization (
	user_id INT UNSIGNED REFERENCES users(id) ON DELETE CASCADE,
	specialization_id INT UNSIGNED REFERENCES specializations(id) ON DELETE CASCADE,
	PRIMARY KEY (user_id, specialization_id),
	INDEX user_id (user_id),
	INDEX specialization_id (specialization_id)
);

CREATE TABLE task_specialization (
	task_id INT UNSIGNED REFERENCES tasks(id) ON DELETE CASCADE,
	specialization_id INT NOT NULL UNSIGNED REFERENCES specializations(id) ON DELETE CASCADE,
	PRIMARY KEY (task_id, specialization_id),
	INDEX task_id (task_id),
	INDEX specialization_id (specialization_id)
);