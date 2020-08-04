CREATE TABLE suffering_account (
sa_ID integer,
sa_status varchar(100) DEFAULT 'non-suffering',
months integer DEFAULT 0,
PRIMARY KEY (sa_ID)
);

CREATE TABLE user_account (
user_ID integer AUTO_INCREMENT,
email varchar(100),
sa_ID integer,
password varchar(100),
first_name varchar(100),
last_name varchar(100),
status varchar(100) DEFAULT 'active',
balance real DEFAULT 0,
PRIMARY KEY (user_ID),
FOREIGN KEY (sa_ID) REFERENCES suffering_account(sa_ID)
);

CREATE TABLE employee (
user_ID integer,
employee_membership_type varchar(100) DEFAULT 'basic',
PRIMARY KEY (user_ID),
FOREIGN KEY (user_ID) REFERENCES user_account(user_ID)
);

CREATE TABLE employer (
user_ID integer,
employer_membership_type varchar(100) DEFAULT 'prime',
PRIMARY KEY (user_ID),
FOREIGN KEY (user_ID) REFERENCES user_account(user_ID)
);
