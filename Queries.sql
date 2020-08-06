i.
	/*create an employer*/ /*to create an employer or an employee, we have to create a user_account first*/
		INSERT INTO user_account (user_ID,sa_ID,password,first_name,last_name,balance,email) values(9999,NULL,'testing','Ramy','Elhoufy',0,'r.elhoufy@gmail.com');
		INSERT INTO employer(user_ID, employer_membership_type) values(9999, 'prime');

	/*display an employer*/
		SELECT *
		FROM user_account UA, employer E
		WHERE UA.first_name = "Ramy" AND UA.last_name = "Elhoufy" AND UA.user_ID = E.user_ID

	/*edit an employer*/
		UPDATE employer
		SET employer_membership_type = "gold"
		WHERE user_ID IN (SELECT UA.user_ID FROM user_account UA WHERE UA.first_name = "Ramy" AND UA.last_name = "Elhoufy");

	/*delete*/ /*have to delete from employer and user_account*/
		DELETE FROM employer
		WHERE user_ID = 9999 AND employer_membership_type = "gold"
		DELETE FROM user_account
		WHERE user_ID = 9999
        
ii. 
	/*create a category by an employer*/
		insert into category (category_name, user_ID) values ('testing_category', 191);
    
	/*edit a category by an employer*/
		UPDATE category
		SET category_name = "testing_category_altered"
		WHERE category_name = "testing_category"

	/*display a category by an employer*/
		SELECT *
		FROM category C
		WHERE category_name = "testing_category_altered" AND user_ID = 191

	/*delete a category by an employer*/
		DELETE FROM category
		WHERE category_name = "testing_category_altered" 

iii.
	/*post a new job by an employer*/
		insert into job (job_ID, category_name, user_ID, num_of_workers_needed, date_posted, job_title, job_status, job_description) values (9999, 'Engineering', 191, 1, '2020/5/8', 'Test Engineer', 'open', 'for testing purposes only');

iv. 
	/*provide a job offer for an employee by an employer*/
		insert into give_offer (employee_user_ID, employer_user_ID, job_ID) values (181, 191, 9999);
        
v.
	waiting for the apply relation table
    
vi. 
	waiting for the apply relation table

vii.
	/*create an employee*/ /*to create an employer or an employee, we have to create a user_account first*/
		INSERT INTO user_account (user_ID,sa_ID,password,first_name,last_name,balance,email) values(8888,NULL,'testing','Ramy','Elhoufy',0,'r.elhoufy@gmail.com');
		INSERT INTO employee(user_ID, employee_membership_type) values(8888, 'prime');

	/*display an employee*/
		SELECT *
		FROM user_account UA, employee E
		WHERE UA.first_name = "Ramy" AND UA.last_name = "Elhoufy" AND UA.user_ID = E.user_ID

	/*edit an employee*/
		UPDATE employee
		SET employee_membership_type = "basic"
		WHERE user_ID IN (SELECT UA.user_ID FROM user_account UA WHERE UA.first_name = "Ramy" AND UA.last_name = "Elhoufy");

	/*delete*/ /*have to delete from employee and user_account*/
		DELETE FROM employee
		WHERE user_ID = 8888 AND employee_membership_type = "basic"
		DELETE FROM user_account
		WHERE user_ID = 8888
        
viii.
	/*Search for a job by an employee*/
		SELECT *
		FROM job
		WHERE job_title = "Civil Engineer"
        
ix.
	waiting for the apply relation table

x.
	waiting for the apply relation table

xi.
	waiting for the apply relation table

xii.
		/*delete a profile*/ /*have to delete from employee and user_account*/
		DELETE FROM employee
		WHERE user_ID = some_ID
		DELETE FROM user_account
		WHERE user_ID = some_ID

xiii.
	waiting for the apply relation table
    
xiv.
	/*add method of payment*/
		insert into payment_method(id_ref,user_ID) values(99999,1167);
		insert into credit_card(id_ref,card_number,credit_card_name,exp_date,cvc) values(99999,'5020718311111111','test man','2020-08-30',557);

	/*edit method of payment*/
		UPDATE credit_card
		SET cvc = 567
		WHERE cvc = 557

	/*delete method of payment*/ /*have to delete from credit_card or checking_account and delete from payment_method id_ref not found in either credit_card or checking_account*/
		DELETE FROM credit_card
		WHERE id_ref = 99999
		DELETE FROM payment_method
		WHERE id_ref NOT IN (SELECT CC.id_ref FROM credit_card CC, checking_account CA WHERE CC.id_ref = CA.id_ref);
        
xv.
	/*edit an automatic payment by a user*/
		UPDATE payment_method
		SET payment_type = "automatic"
		WHERE id_ref = 11195
    
xvi.
	/*isn't this a front end thing?*/

xvii.
	/*report of all employees*/
		SELECT UA.user_ID,first_name,last_name,balance,email, EE.employee_membership_type
		FROM user_account UA, employee EE
		WHERE UA.user_ID = EE.user_ID

	/*report of all employers*/
		SELECT UA.user_ID,first_name,last_name,balance,email, ER.employer_membership_type
		FROM user_account UA, employer ER
		WHERE UA.user_ID = ER.user_ID
		

xviii.
	/*Report of all suffering accounts*/
		SELECT SA.months, UA.email, UA.balance
		FROM suffering_account SA, user_account UA
		WHERE SA.sa_ID = UA.sa_ID

        



	
	
