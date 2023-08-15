SHOW TABLES ;

DROP TABLE users;

CREATE TABLE users
(
    user_id VARCHAR(20) PRIMARY KEY ,
    username VARCHAR(15) UNIQUE NOT NULL ,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL ,
    created_at DATETIME NOT NULL ,
    updated_at DATETIME NOT NULL
);


SELECT * FROM users;

CREATE TABLE todolist
(
    todo_id VARCHAR(20) PRIMARY KEY ,
    todo VARCHAR(255) NOT NULL ,
    time DATETIME NOT NULL ,
    created_at DATETIME NOT NULL ,
    updated_at DATETIME NOT NULL,
    user_id VARCHAR(20) NOT NULL ,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

UPDATE todolist
SET status = 'false'
WHERE time < NOW() AND status <> 'yes';

SELECT * FROM todolist;

DELETE FROM todolist WHERE todo_id = 64d887e392fbe;

DROP TABLE todolist;

ALTER TABLE todolist ADD COLUMN status VARCHAR(10) DEFAULT 'no';
