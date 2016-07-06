<?php
/*
This is a USSD  application for Hostel booking done at MERU university
It is a simple application that queries a database and makes validation.

INSTALLATION STEPS:
1. create a database called "ussd"
2. import the ussd.sql file
3. clone this project in htdocs/www  folder depending on which server you are using.
 //http://localhost/ussd/test.php?SERVICE_CODE=&SESSION_ID=&MSISDN=&USSD_STRING= 
 4. use the above link in any browser. or postman API client in chrome(i prefer this)
 5. enjoy!

TEST DATA registration numbers can be found in database students table. its dummy data. Never mind!
*/

include('connection.php');//including the database connection script.
//to get information
$phonenumber= $_GET['MSISDN']; //0726410942
$session_id=$_GET['SESSION_ID']; //123DF12
$service_code=$_GET['SERVICE_CODE'];//*335#
$ussd_string=$_GET['USSD_STRING']; 
//http://localhost/ussd/test.php?SERVICE_CODE=&SESSION_ID=&MSISDN=&USSD_STRING=

//set number of ussd string element to 0, since you have nothing dialed yet
$number_of_elements=0; 

if($ussd_string != ""){
	$ussd_string=str_replace("#","*", $ussd_string); //replace all '#' elements with '*'
	$ussd_string_explode=explode("*", $ussd_string); //explode out '*' => this is an array 123 elements


	$number_of_elements=count($ussd_string_explode);
}
if($number_of_elements==0){
	display_first_menu();
}
	//function executed after entering service
function display_first_menu(){
	$ussd_text="Welcome to MUST USSD application for Hostel Booking.<br/> Please reply with:-<br/>1: Book Hostel<br/>2: Check your Booked room";
	display_text($ussd_text);
	}

if($number_of_elements>0){
	switch($ussd_string_explode[0]){ 
		case 1:
			book_hostel($ussd_string_explode,$phonenumber);
			break;
		case 2:
			check_booked($ussd_string_explode,$phonenumber);			
			break;
	}
	
}
function book_hostel($event,$phonenumber){	
	if(count($event)==1){ // if one element has been returned.
			$ussd_text="<br/>To book a Hostel, Please enter your Registration Number:";
				display_text($ussd_text);
	}
	else if(count($event)==2){
		$RegNo=strtoupper($event[1]);
		$query="SELECT Sex FROM students WHERE RegNo='$RegNo'";
				define("x","Sex");
				$stud = mysql_query($query);
				$student = mysql_fetch_array($stud);
				$stdnt_sex = $student[x];					
					//ensures hostel is respective to sex...
					//sex variable in every function.
			if($stdnt_sex=='F'){//if sex is FEMALE
				$ussd_text="Please reply with...<br/>1 Ladies Hostel BLOCK B<br/>2 Ladies Hostel BLOCK C<br/>";
				display_text($ussd_text);
			}else if($stdnt_sex=='M'){ //if SEX is MALE
				$ussd_text="Please reply with...<br/>3 Mens Hostel BLOCK A <br/>4 Mens Hostel MT. KENYA<br/>";
				display_text($ussd_text);
			}else{
			$ussd_text="Sorry, You are not a registered student. Please Register as a Meru University student first.<br/>Thank you for using this service.";
			display_text($ussd_text);
			}
	}
	else if(count($event)==3){
		$ussd_text="<br/>1: Confirm <br/>0: exit";
		display_text($ussd_text);
	}
	else if(count($event)==4){
	
	
		$ed=$event[3];
		if($ed==1){
			$l=$event[2];
			$RegNo=strtoupper($event[1]);
			$query="SELECT RegNo FROM book_hostel WHERE RegNo='$RegNo'";
				define("reg","RegNo");
				$stud = mysql_query($query);
				$student=mysql_fetch_array($stud);
				$stdnt=$student[reg];					
					//ensure no one books more than once
			if($stdnt==$RegNo){ //if a record is found
					$ussd_text="Sorry. You have already booked a room.<br/>0: exit";
					display_text($ussd_text);
			}else if($stdnt!==$RegNo){//if no record exists
				
				if($l==1){	//select block B					
					 
			//assign room randomly selecting from available_hostels table and adding into book_hostel table
					$query="INSERT INTO book_hostel(Name, RegNo, room)
						values
						((SELECT Name FROM students WHERE RegNo='$RegNo'),
						(SELECT RegNo FROM students WHERE RegNo='$RegNo'), 
						(SELECT  block_b FROM available_hostels WHERE block_b NOT IN (SELECT room FROM book_hostel AS compare_table)ORDER BY RAND() LIMIT 1))";
					
					$query_full="SELECT COUNT(block_b) AS rem FROM `available_hostels` WHERE block_b NOT IN (SELECT room FROM `book_hostel`)";
					insert_data($RegNo,$query,$query_full);
					
					
				
				}else if($l==2){
					$query="INSERT INTO book_hostel(Name, RegNo, room)
						values
						((SELECT Name FROM students WHERE RegNo='$RegNo'),
						(SELECT RegNo FROM students WHERE RegNo='$RegNo'), 
						(SELECT  block_c FROM available_hostels WHERE block_c NOT IN (SELECT room FROM book_hostel AS compare_table)ORDER BY RAND() LIMIT 1))";
					$query_full="SELECT COUNT(block_c) AS rem FROM `available_hostels` WHERE block_c NOT IN (SELECT room FROM `book_hostel`)";
					//execute the insert query.
					
					insert_data($RegNo,$query,$query_full);
				}else if($l==3){

					$query="INSERT INTO book_hostel(Name, RegNo, room)
						values
						((SELECT Name FROM students WHERE RegNo='$RegNo'),
						(SELECT RegNo FROM students WHERE RegNo='$RegNo'), 
						(SELECT  block_a FROM available_hostels WHERE block_a NOT IN (SELECT room FROM book_hostel AS compare_table)ORDER BY RAND() LIMIT 1))";
					$query_full="SELECT COUNT(block_a) AS rem FROM `available_hostels` WHERE block_a NOT IN (SELECT room FROM `book_hostel`)";
					//execute the insert query.
					
					insert_data($RegNo,$query,$query_full);
				}else if($l==4){
					$query="INSERT INTO book_hostel(Name, RegNo, room)
						values
						((SELECT Name FROM students WHERE RegNo='$RegNo'),
						(SELECT RegNo FROM students WHERE RegNo='$RegNo'), 
						(SELECT  mt_kenya FROM available_hostels WHERE mt_kenya NOT IN (SELECT room FROM book_hostel AS compare_table)ORDER BY RAND() LIMIT 1))";
					$query_full="SELECT COUNT(mt_kenya) AS rem FROM `available_hostels` WHERE mt_kenya NOT IN (SELECT room FROM `book_hostel`)";
					
					//execute the query.
					insert_data($RegNo,$query,$query_full);
				}else if($l==0){
					$ussd_text="Thank you for using this service!";
					display_text($ussd_text);
				}else{
					$ussd_text="Sorry, Wrong HOSTEL selection. Please try again.<br/>0: exit";
					display_text($ussd_text);
				}
			}
		}	
		if($ed==0){
			$ussd_text="Thank you for using this service!";
			display_text($ussd_text);
		}
		
	}
	else if(count($event)==5){
		$ex=$event[4];
		$ex2=$event[2];
		
		if(($ex==0)||($ex2==0)){
			$ussd_text="Thank you for using this service!";
			display_text($ussd_text);
		}	
	}
}


function check_booked($event,$phonenumber){
	if(count($event)==1){	//if one element has been returned.
		$ussd_text="To check your booked room, Please enter your Registration number.";
		display_text($ussd_text);
	}
	else if(count($event)==2){
		//get registration number from array and convert it into upper_case
		$RegNo=strtoupper($event[1]);

		$query="SELECT * FROM book_hostel WHERE RegNo='$RegNo'";

		define("nm","Name");
		define("reg","RegNo");
		define("r","room");
		$stud = mysql_query($query);
		$student=mysql_fetch_array($stud);
		$stdnt=$student['RegNo'];					
		if($stdnt!==$RegNo){ 
			$ussd_text="You have not yet booked a room. Select option '1: Book Hostel' to book a room. <br/>0: exit";
			display_text($ussd_text);
		}if($stdnt==$RegNo){
			$ussd_text= "Dear ".$student[nm]." Registration number ".$student[reg].", you have been assigned room ".$student[r].".<br/>
				Remember to pay the Hostel fee soon to complete the Process.<br/>Thankyou.<br/>0: exit";
			display_text($ussd_text);
			
		}				
				
	}
	else if(count($event)==3){
		$ed=$event[2];
		if($ed==0){
			$ussd_text="Thank you for using this service.";
					display_text($ussd_text);
		}
		
	}	
}
function display_text($ussd_text){
	echo $ussd_text;					
	exit(0);
}
function insert_data($RegNo,$query,$query_full){
	$result=mysql_query($query);
		if($result){//if query was executed without any problem, echo success and select from database the values inserted*******
		$query="SELECT * FROM book_hostel WHERE RegNo='$RegNo'";

		define("n","Name");//define("variable name","column name");
		define("rg","RegNo");
		define("r","room");

		$result=mysql_query($query);

			while($student=mysql_fetch_array($result)){
				echo "Congratulations, ".$student[n]." Registration number ".$student[rg].", you have been assigned room ".$student[r].".<br/>
				Please pay via the respective bank to complete the Process.<br/>Thankyou.<br/>0: exit";
			}
		}else if(!$result){
			if_full($query_full);
			}
}
function if_full($query_full){
	$if_full=mysql_query($query_full);
	define("rm","rem");
	$remaining_room=mysql_fetch_array($if_full);
	$result_full=$remaining_room[rm];
	
	if($result_full==0){
		$ussd_text="Sorry, the Hostel is full. Please try another Block.<br/>0: exit";
		display_text($ussd_text);
	}
						
}



?>