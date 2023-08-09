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
