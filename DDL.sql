CREATE TABLE administrator (
email varchar(100),
first_name varchar(45),
last_name varchar(45),
password varchar(45),
PRIMARY KEY (email)
);

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

CREATE TABLE payment_method (
id_ref integer,
user_ID integer, 
selected boolean default 1,
payment_type varchar(100) default 'manual',
primary key(id_ref),
foreign key(user_ID) references user_account(user_ID)
);

CREATE TABLE credit_card (
card_number varchar(16), 
id_ref integer, 
cvc varchar(45),
credit_card_name varchar(100),
exp_date date, 
primary key(card_number),
foreign key(id_ref) references payment_method(id_ref)
);

CREATE TABLE checking_account (
bank_account_num varchar(10), 
id_ref integer, 
name_of_assoc_acct varchar(100), 
primary key(bank_account_num),
foreign key(id_ref) references payment_method(id_ref)
);

CREATE TABLE deactivate (
admin_email varchar(100),
user_ID int(11),
foreign key(admin_email) references administrator(email),
foreign key(user_ID) references user_account(user_ID)
);

CREATE TABLE category (
category_name varchar(100),
user_ID integer,
primary key(category_name),
foreign key(user_ID) references user_account(user_ID)
);

CREATE TABLE job (
job_ID integer,
category_name varchar(100),
user_ID integer,
num_of_workers_needed integer,
date_posted date,
job_title varchar(100),
job_status varchar(100) default 'open',
description varchar(5000), 
PRIMARY KEY (job_ID),
FOREIGN KEY (category_name) REFERENCES category(category_name),
FOREIGN KEY (user_ID) REFERENCES employer(user_ID)
);

CREATE TABLE updates (
employee_user_ID integer,
employer_user_ID integer,
primary key(employee_user_ID,employer_user_ID),
foreign key(employee_user_ID) references employee(user_ID),
foreign key(employer_user_ID) references employer(user_ID)
);

CREATE TABLE give_offer (
employee_user_ID integer,
employer_user_ID integer,
job_ID integer,
primary key(employee_user_ID,employer_user_ID,job_ID),
foreign key(employee_user_ID) references employee(user_ID),
foreign key(employer_user_ID) references employer(user_ID),
foreign key(job_ID) references job(job_ID)
);

CREATE TABLE choose (
employee_user_ID integer,
category_name varchar(100),
primary key(employee_user_ID,category_name),
foreign key(employee_user_ID) references employee(user_ID),
foreign key(category_name) references category(category_name)
);

CREATE TABLE apply (
employee_user_ID integer,
job_ID integer,
app_status varchar(100) default 'pending',
date_applied date,
primary key(employee_user_ID,job_ID),
foreign key(employee_user_ID) references employee(user_ID),
foreign key(job_ID) references job(job_ID)
);
