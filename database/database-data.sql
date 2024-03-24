-- -- Create the users table
-- create table users(
--  username varchar(50) PRIMARY KEY,
--  password varchar(100) NOT NULL);
--  INSERT INTO users(username,password) VALUES ('admin',md5('MyPa$$w0rd'));

-- Create the messages table
CREATE TABLE messages (
    message_ID INT PRIMARY KEY AUTO_INCREMENT,
    content TEXT,
    type VARCHAR(20),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    sender_username VARCHAR(50),
    FOREIGN KEY (sender_username) REFERENCES users(username)
);

-- Create the sends relationship table
CREATE TABLE sends (
    message_ID INT,
    sender_username VARCHAR(50),
    PRIMARY KEY (message_ID),
    FOREIGN KEY (message_ID) REFERENCES messages(message_ID),
    FOREIGN KEY (sender_username) REFERENCES users(username)
);

-- Create the receives relationship table
CREATE TABLE receives (
    message_ID INT,
    receiver_username VARCHAR(50),
    PRIMARY KEY (message_ID, receiver_username),
    FOREIGN KEY (message_ID) REFERENCES messages(message_ID),
    FOREIGN KEY (receiver_username) REFERENCES users(username)
);

GRANT ALL ON messages TO 'waph_team16'@'localhost';
GRANT ALL ON sends TO 'waph_team16'@'localhost';
GRANT ALL ON receives TO 'waph_team16'@'localhost';
