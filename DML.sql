/*administrator*/
	Insert into administrator  values('arosterne2@studiopress.com','Amandie','Rosterne', 'H0Qzs7c8TUX');
	Insert into administrator  values('cfitzer4@nationalgeographic.com','Carie','Fitzer', 'jqOzbK9p');
	Insert into administrator  values('gandrich3@zdnet.com','Goldy','Andrich', 'N1FBscg');
	Insert into administrator  values('gspadoni0@trellian.com','Geralda','Spadoni', 'VoWNh542');
	Insert into administrator  values('orowatt1@istockphoto.com','Onida','Rowatt', 'Wx4LlJOuy');

/*suffering_account*/
	/*employer*/
		insert into suffering_account(sa_ID) values(1167);
		insert into suffering_account(sa_ID) values(191);
		insert into suffering_account(sa_ID) values(5328);
		insert into suffering_account(sa_ID) values(681);
		insert into suffering_account(sa_ID) values(8034);
	/*Employee*/
		insert into suffering_account(sa_ID) values(1000);
		insert into suffering_account(sa_ID) values(181);
		insert into suffering_account(sa_ID) values(5000);
		insert into suffering_account(sa_ID) values(600);
		insert into suffering_account(sa_ID) values(8000);

/*user_account*/
	/*Employer accounts*/
		insert into user_account (user_ID,sa_ID,password,first_name,last_name,balance,email) values(1167,1167,'SOGpfKJoW','Leeland','Ovington',0,'lovington0@apple.com');
		insert into user_account (user_ID,sa_ID,password,first_name,last_name,balance,email) values(191,191,'MFkaCS','Ettie','Luce',0,'eluce1@wikia.com');
		insert into user_account (user_ID,sa_ID,password,first_name,last_name,balance,email) values(5328,5328,'pUtqb3uPb','Porter','MacColm',3.15,'pmaccolm2@pcworld.com');
		insert into user_account (user_ID,sa_ID,password,first_name,last_name,balance,email) values(681,681,'3MseNB','Ammamaria','Ellor',9.89,'aellor3@blogger.com');
		insert into user_account (user_ID,sa_ID,password,first_name,last_name,balance,email) values(8034,8034,'hvBqfK2G0Uu','Gerick','Klee',1.98,'gklee4@time.com');

	/*Employee accounts*/
		insert into user_account (user_ID,sa_ID,password,first_name,last_name,balance,email) values(1000,1000,'ASDqwe','Lee','Bond',0,'Bond@apple.com');
		insert into user_account (user_ID,sa_ID,password,first_name,last_name,balance,email) values(181,181,'XCAsad','Rach','El',0,'el@gmail.com');
		insert into user_account (user_ID,sa_ID,password,first_name,last_name,balance,email) values(5000,5000,'asd2321ASD','Potter','Harry',5.00,'potter@gmail.com');
		insert into user_account (user_ID,sa_ID,password,first_name,last_name,balance,email) values(600,600,'FASDcdas','Amma','Elle',10.00,'elle@gmail.com');
		insert into user_account (user_ID,sa_ID,password,first_name,last_name,balance,email) values(8000,8000,'KJBDasd','Gonzo','Wat',2.00,'gonzo@gmail.com');
        
/*payment_method*/
	/*Employer*/
		insert into payment_method(id_ref,user_ID) values(14608,1167);
		insert into payment_method(id_ref,user_ID) values(18226,191);
		insert into payment_method(id_ref,user_ID) values(14790,5328);
		insert into payment_method(id_ref,user_ID) values(16343,681);
		insert into payment_method(id_ref,user_ID) values(11195,8034);

	/*Employee*/
		insert into payment_method(id_ref,user_ID) values(15039,1000);
		insert into payment_method(id_ref,user_ID) values(17829,181);
		insert into payment_method(id_ref,user_ID) values(13858,5000);
		insert into payment_method(id_ref,user_ID) values(19238,600);
		insert into payment_method(id_ref,user_ID) values(12356,8000);
        
/*credit_card*/
	/*Employer*/
		insert into credit_card(id_ref,card_number,credit_card_name,exp_date,cvc) values(14608,'5020718368983288','Leeland Ovington','2020-08-30',447);
		insert into credit_card(id_ref,card_number,credit_card_name,exp_date,cvc) values(18226,'3578183235465325','Ettie Luce','2023-10-16',774);
		insert into credit_card(id_ref,card_number,credit_card_name,exp_date,cvc) values(14790,'6706599349547183','Porter MacColm','2021-03-25',350);
		insert into credit_card(id_ref,card_number,credit_card_name,exp_date,cvc) values(16343,'5100133261539412','Ammamaria Ellor','2022-09-20',341);
		insert into credit_card(id_ref,card_number,credit_card_name,exp_date,cvc) values(11195,'5602255396525397','Gerick Klee','2020-09-30',383);

	/*Employee*/
		insert into credit_card(id_ref,card_number,credit_card_name,exp_date,cvc) values(15039,'5020718368983388','Lee Bond','2022-08-30',417);
		insert into credit_card(id_ref,card_number,credit_card_name,exp_date,cvc) values(17829,'3578183235465435','Rach El','2024-11-16',724);
		insert into credit_card(id_ref,card_number,credit_card_name,exp_date,cvc) values(13858,'6706599349547565','Potter Harry','2020-10-25',330);
		insert into credit_card(id_ref,card_number,credit_card_name,exp_date,cvc) values(19238,'5100133261539311','Amma Elle','2022-11-20',311);
		insert into credit_card(id_ref,card_number,credit_card_name,exp_date,cvc) values(12356,'5602255396525973','Gonzo Wat','2024-11-30',303);


/*checking_account*/
	/*Employer*/
		insert into checking_account (bank_account_num, id_ref, name_of_assoc_acct) values ('2497087768', 14608, 'Leeland Ovington');
		insert into checking_account (bank_account_num, id_ref, name_of_assoc_acct) values ('3177692696', 18226, 'Ettie Luce');
		insert into checking_account (bank_account_num, id_ref, name_of_assoc_acct) values ('4025657589', 14790, 'Porter MacColm');
		insert into checking_account (bank_account_num, id_ref, name_of_assoc_acct) values ('6012490410', 16343, 'Ammamaria Ellor');
		insert into checking_account (bank_account_num, id_ref, name_of_assoc_acct) values ('5757225904', 11195, 'Gerick Klee');

	/*Employee*/
		insert into checking_account (bank_account_num, id_ref, name_of_assoc_acct) values ('2497087876', 15039, 'Lee Bond');
		insert into checking_account (bank_account_num, id_ref, name_of_assoc_acct) values ('3177692969', 17829, 'Rach El');
		insert into checking_account (bank_account_num, id_ref, name_of_assoc_acct) values ('4025657985', 13858, 'Potter Harry');
		insert into checking_account (bank_account_num, id_ref, name_of_assoc_acct) values ('6012490014', 19238, 'Amma Elle');
		insert into checking_account (bank_account_num, id_ref, name_of_assoc_acct) values ('5757225409', 12356, 'Gonzo Wat');
        
/*employer*/
	insert into employer (user_id, employer_membership_type) values (191, 'gold');
	insert into employer (user_id, employer_membership_type) values (681, 'gold');
	insert into employer (user_id, employer_membership_type) values (1167, 'gold');
	insert into employer (user_id, employer_membership_type) values (5328, 'prime');
	insert into employer (user_id, employer_membership_type) values (8034, 'prime');
    
/*category*/
	insert into category (category_name, user_ID) values ('Engineering', 191);
	insert into category (category_name, user_ID) values ('Marketing', 681);
	insert into category (category_name, user_ID) values ('Finance', 1167);
	insert into category (category_name, user_ID) values ('Arts', 5328);
	insert into category (category_name, user_ID) values ('Health', 8034);
    
/*job*/
	insert into job (job_ID, category_name, user_ID, num_of_workers_needed, date_posted, job_title, job_status, description) values (44, 'Engineering', 191, 2, '6/11/2020', 'Civil Engineer', 'open', 'id nisl venenatis lacinia aenean sit amet justo morbi ut odio cras mi pede malesuada in imperdiet et commodo vulputate justo in blandit ultrices enim lorem ipsum dolor sit amet consectetuer adipiscing elit proin interdum mauris non ligula pellentesque ultrices phasellus id sapien in sapien iaculis congue vivamus metus');
	insert into job (job_ID, category_name, user_ID, num_of_workers_needed, date_posted, job_title, job_status, description) values (66, 'Marketing', 681, 4, '5/4/2020', 'Content Manager', 'open', 'nullam porttitor lacus at turpis donec posuere metus vitae ipsum aliquam non mauris morbi non lectus aliquam sit amet diam in');
	insert into job (job_ID, category_name, user_ID, num_of_workers_needed, date_posted, job_title, job_status, description) values (74, 'Finance', 1167, 2, '5/28/2020', 'Financial Advisor', 'open', 'pretium nisl ut volutpat sapien arcu sed augue aliquam erat volutpat in congue');
	insert into job (job_ID, category_name, user_ID, num_of_workers_needed, date_posted, job_title, job_status, description) values (67, 'Arts', 5328, 5, '8/31/2019', 'Creative Director', 'open', 'ultrices posuere cubilia curae donec pharetra magna vestibulum aliquet ultrices erat tortor sollicitudin mi sit amet lobortis sapien sapien non mi integer ac neque duis bibendum morbi non quam nec dui luctus rutrum nulla tellus in sagittis dui vel nisl duis ac nibh');
	insert into job (job_ID, category_name, user_ID, num_of_workers_needed, date_posted, job_title, job_status, description) values (97, 'Health', 8034, 2, '9/28/2019', 'Nurse', 'open', 'amet diam in magna bibendum imperdiet nullam orci pede venenatis non sodales sed tincidunt eu felis fusce posuere felis sed lacus morbi sem mauris laoreet ut rhoncus');

/*employee*/
	insert into employee (user_id, employee_membership_type) values (1000, 'gold');
	insert into employee (user_id, employee_membership_type) values (181, 'gold');
	insert into employee (user_id, employee_membership_type) values (5000, 'basic');
	insert into employee (user_id, employee_membership_type) values (600, 'prime');
	insert into employee (user_id, employee_membership_type) values (8000, 'prime');

/*choose*/
	insert into choose (user_ID, category_name) values (1000, 'Engineering');
	insert into choose (user_ID, category_name) values (181, 'Marketing');
	insert into choose (user_ID, category_name) values (5000, 'Arts');
	insert into choose (user_ID, category_name) values (600, 'Finance');
	insert into choose (user_ID, category_name) values (8000, 'Health');

/*give_offer*/
	insert into give_offer (employee_user_ID, employer_user_ID, job_ID) values (1000, 191, 44);
	insert into give_offer (employee_user_ID, employer_user_ID, job_ID) values (181, 681, 66);
	insert into give_offer (employee_user_ID, employer_user_ID, job_ID) values (5000, 1167, 67);
	insert into give_offer (employee_user_ID, employer_user_ID, job_ID) values (600, 5328, 74);
	insert into give_offer (employee_user_ID, employer_user_ID, job_ID) values (8000, 8034, 97);

/*updates*/
	insert into updates (employee_user_ID, employer_user_ID) values (1000, 191);
	insert into updates (employee_user_ID, employer_user_ID) values (181, 681);
	insert into updates (employee_user_ID, employer_user_ID) values (5000, 1167);
	insert into updates (employee_user_ID, employer_user_ID) values (600, 5328);
	insert into updates (employee_user_ID, employer_user_ID) values (8000, 8034);

/*apply*/
insert into apply (employee_user_ID, job_ID, app_status, date_applied) values (1000, 44, 'accepted', '2020-05-28');
insert into apply (employee_user_ID, job_ID, app_status, date_applied) values (181, 66, 'accepted', '2020-01-25');
insert into apply (employee_user_ID, job_ID, app_status, date_applied) values (5000, 67, 'accepted', '2019-08-24');
insert into apply (employee_user_ID, job_ID, app_status, date_applied) values (600, 74, 'accepted', '2019-09-12');
insert into apply (employee_user_ID, job_ID, app_status, date_applied) values (8000, 97, 'applied', '2020-05-11');






