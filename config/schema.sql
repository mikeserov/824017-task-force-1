CREATE DATABASE yeti_cave
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE UTF8_GENERAL_CI;

USE yeti_cave;

CREATE TABLE Tasks (
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	author INT REFERENCES users(id),
	author INT REFERENCES users(id),
	author INT REFERENCES cities(id),
	posting_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
)





CREATE TABLE lots (
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	dt_start TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	name VARCHAR(128),
	description TEXT(128),
	img TEXT(128),
	start_price DECIMAL,
	dt_end TIMESTAMP,
	rate_step DECIMAL,
	category_id INTEGER REFERENCES categories(id),
	author INT REFERENCES users(id),
	winner INT REFERENCES users(id)
);

CREATE UNIQUE INDEX lot_id ON lots(id);
CREATE UNIQUE INDEX user_id ON users(id);
CREATE UNIQUE INDEX rate_id ON rates(id);

CREATE INDEX lot_description ON lots(description(128));
CREATE INDEX lot_name ON lots(name);


CREATE FULLTEXT INDEX name_description ON lots (name, description);