<?php
//en.php - english language file

/*Login/register page translation*/
$message['login']='LOGIN';
$message['register']='REGISTER';
$message['email']='EMAIL ADDRESS';
$message['firstname']='FIRSTNAME';
$message['lastname']='LASTNAME';
$message['password']='PASSWORD';
$message['password2']='REPEAT PASSWORD';
$message['notamember']='NOT A MEMBER?';
$message['alreadymember']='ALREADY A MEMBER?';
$message['logininfo']="If you are already a user you can use the button below to login to your account";
$message['registerinfo']='Registered users are notified about upcoming events and discounts. By registering you also receive a 5% cost bonus for your next booking!';
$message['registerbutton']='REGISTER';
$message['redirected']='You need to be logged in first!';

$message['emailnotcorrect']='Email is not correct';
$message['firstnameempty']='Firstname may not be empty';
$message['lastnameempty']='Lastname may not be empty';
$message['passwordempty']='Password may not be empty';
$message['passwordrepeat']='Password repeat may not be empty';
$message['passwordnotmatch']='Passwords do not match';
$message['emailtoolong']='Email is too long';
$message['firstnametoolong']='Firstname is too long';
$message['lastnametoolong']='Lastname is too long';
$message['passwordtoolong']='Password is too long';
$message['emailinuse']='This email is already in use, try another email.';
$message['accountregister']='Account registered, you may now log in.';

$message['']='';
$message['']='';
$message['']='';
//Placeholders
$message['lastname']='Last Name';
$message['firstname']='First Name';
$message['password1']='password';


/*Index page translation*/
//Header buttons translation
$message['home']='HOME';
$message['gallery']='GALLERY';
$message['aboutus']='ABOUT US';
$message['rooms']='ROOMS';
$message['booking']='BOOKING';
$message['contact']='CONTACT';
$message['loginregister']='LOGIN/REGISTER';
$message['admin-panel']='ADMIN-PANEL';
$message['logout']='LOGOUT';
//Main page translations
$message['experience']='A NEW WAY TO EXPERIENCE SPACE AS NEVER BEFORE';
$message['learnmore']='LEARN MORE';
$message['instagram']='INSTAGRAM';
$message['twitter']='TWITTER';

/*About page translations*/
$message['about']='ABOUT';
$message['aim']='WHAT WE AIM TO DO';
$message['aboutusinfo']="We want to give mankind a way to experience space as never done before! Feel what it's like to be in a zero gravity surrounding or what it's like to wake up in space with your beloved ones or as a solo adventurer!";

/*Errors*/
$message['database_error']="There was an issue with loading data from the server.";
$message['message_delete_error']="There was an issue with deleting the message.";
$message['reservation_delete_error']="There was an issue with deleting the reservation.";
//This message is more transparent about what is going on, but it should only happen when the database is not reachable at all.
//Which should never happen.
$message['database_connect_error']="There was an issue with connecting to the database.";

/*Rooms page translations*/
//Search translations
$message['search']='SEARCH';
$message['layer']='Layer';
$message['checkin']='Check in date';
$message['checkout']='Check out date';
$message['check']='CHECK';
//Rooms translations
$message['bookNow']='BOOK NOW!';

/*Booking page translations*/
$message['booking_page_title']='Booking Confirmation';
$message['bookingtitle']='BOOKING';
$message['availability']='AVAILABILITY';
$message['booking_confirm_title']='Booking Confirmation';
$message['error_title']='Something went wrong';
$message['booking_confirm']='CONFIRM';
$message['booking_cancel']='CANCEL';
$message['error_contact']='LEAVE A MESSAGE';
$message['booking_back']='GO BACK';
$message['error_back']='GO BACK';
$message['booking_confirmed_title']="Reservation placed";
$message['booking_confirmed_message']="Your reservation has been made successfully";

$message['booking_user']='User';
$message['booking_firstname']='Firstname: ';
$message['booking_lastname']='Lastname: ';
$message['booking_email']='Email-address: ';

$message['booking_suite']='Suite';
$message['booking_suite_name']='Name: ';
$message['booking_suite_size']='Size: ';
$message['booking_suite_rooms']='Rooms: ';
$message['booking_suite_price']='Price: ';
$message['booking_period']='Booking Period: ';

/*Booking errors*/
$message['incorrect_start_date']='The given start date for this reservation is invalid.';
$message['incorrect_end_date']='The given end date for this reservation is invalid.';
$message['no_information_passed']='There was an issue loading the reservation information.';
$message['reservation_save_error']='There was an issue saving the reservation information.';
$message['user_load_error']='There was an issue loading the user information.';
$message['invalid_suite_id']='There was an issue loading the suite information.';
$message['error_contact_message']='Please inform us using the contact form if the issue persists.';

/*Gallery page translations*/
$message['gallerytitle']='GALLERY';
$message['viewmore']='VIEW MORE';

/*Contact page translations*/
$message['othercontact']='OTHER CONTACT?';
$message['contactusinfo']='You can always contact us through phone or visit us.';
$message['contactform']='CONTACT';
$message['contactformname']='NAME';
$message['contactformsubject']='SUBJECT';
$message['contactformemail']='EMAIL';
$message['contactformmessage']='MESSAGE';
$message['sendmessage']='SEND';
//Placeholders
$message['contactformname2']='Name';
$message['contactformsubject2']='Problem';
$message['contactformmessage2']='I have a problem';

/*Footer translations*/
$message['nebulaxmotto']='Space as never before!';
//Explore
$message['explore']='EXPLORE';
$message['explorerooms']='Rooms';
$message['exploregallery']='Gallery';
$message['exploreaboutus']='About us';
$message['explorebooking']='Booking';
$message['explorecontact']='Contact';
$message['loginregister2']='Login/Register';
$message['admin-panel2']='Admin-panel';
$message['logout2']='Logout';
//Visit and HQ
$message['visit']='VISIT';
$message['hq']='HQ';
//Legal
$message['legal']='LEGAL';
$message['trademark']='Trademark';
$message['privacy']='Privacy';

/*Adminpanel translations*/
//Reservations
$message['reservations']='Reservations';
$message['id']='ID';
$message['userid']='User ID';
$message['suiteid']='Suite ID';
$message['startdate']='Start date';
$message['enddate']='End date';
$message['details']='Details';
//Contact Messages
$message['contactmessages']='Contact Messages';
$message['name']='Name';
$message['email']='Email';
$message['subject']='Subject';
$message['message']='Message';

$message['deleteConfirm']='Delete Confirmation';
$message['deleteMesssage']='Are you sure you want to delete the Message?';
$message['deleteMesssageWarning']='WARNING: MAKE SURE TO SEND AN EMAIL TO THE USER BEFORE DELETING THE Message IT WILL BE GONE FOREVER!';
$message['delete']='Delete';
$message['cancel']='Cancel';
$message['admingallery']='Gallery';

$message['errortryagain']='Something went wrong. Please try again.';
$message['filename']='File Name';
$message['fileexist']='already exists. Please upload a file with a different name.';
$message['filetolong']='The name of the file is to long. This should be 50 characters or less.';
$message['filedifferent']='Something went wrong. Please try a different file';
$message['filetype']='This filetype is not correct. Please upload a jpg/jpeg/png.';
$message['filetolarge']='This file is to large. Please upload a file of 3MB or less.';
$message['nofile']='Nothing has been uploaded. Please try again.';

$message['filesucces']='File has been succesfully uploaded!';
$message['filemanipulated']='This file has an manipulated filetype!';
$message['fileremove']='The file has been removed';
$message['nothingfound']='No file found.';
$message['uploadedimages']='Uploaded images';


?>