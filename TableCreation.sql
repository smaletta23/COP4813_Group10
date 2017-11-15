use group10;

CREATE TABLE accounts(
username varchar(20) NOT NULL,
password varchar(20) NOT NULL,
date_created date NOT NULL,
-- Keys
PRIMARY KEY(username)
);

CREATE TABLE discussionBoards(
board_id int NOT NULL,
name varchar(15) NOT NULL,
-- Keys
PRIMARY KEY(board_id)
);

CREATE TABLE posts(
post_id int NOT NULL AUTO_INCREMENT,
board int NOT NULL,
made_by varchar(20) NOT NULL,
made_on datetime NOT NULL, 
contents varchar(750) NOT NULL, -- enough?
-- Keys
PRIMARY KEY(post_id),
FOREIGN KEY(board) REFERENCES discussionBoards(board_id),
FOREIGN KEY(made_by) REFERENCES accounts(username)
);

