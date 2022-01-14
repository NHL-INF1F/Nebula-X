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

/*About page translations*/
$message['about']='ABOUT';
$message['aim']='WHAT WE AIM TO DO';
$message['aboutusinfo']="We want to give mankind a way to experience space as never done before! Feel what it's like to be in a zero gravity surrounding or what it's like to wake up in space with your beloved ones or as a solo adventurer!";

/*Rooms page translations*/
//Search translations
$message['search']='SEARCH';
$message['layer']='Layer';
$message['checkin']='Check in date';
$message['checkout']='Check out date';
$message['check']='CHECK';
//Rooms translations
$message['bookNow']='BOOK NOW!';

/*Errors*/
$message['database_error']="There was an issue with loading data from the server.";
$message['message_delete_error']="There was an issue with deleting the message.";
$message['reservation_delete_error']="There was an issue with deleting the reservation.";
//This message is more transparent about what is going on, but it should only happen when the database is not reachable at all.
//Which should never happen.
$message['database_connect_error']="There was an issue with connecting to the database.";

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
$message['contactustitle']='CONTACT US';
$message['help']='HOW CAN WE HELP?';
$message['contactusinfo']='We want to hear from you, please feel free to email us or just speak your mind below, please allow up to 1 business day to respond.';
$message['contactform']='CONTACT';
$message['contactformname']='NAME';
$message['contactformemail']='EMAIL';
$message['contactformmessage']='MESSAGE';
$message['sendmessage']='SEND MESSAGE';

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
$message['admin_file_exist_error']='Oops! An error occurred. Please try again..'
?>