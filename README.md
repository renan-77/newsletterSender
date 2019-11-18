# Newsletter Sender System

Newsletter Sender is a system developed for both the customers and the administrators, it has both the
registering customer part, which will register it in a database and a panel for sending the custom message.

## Database Configuration

The database has to have the following:

TABLE       |   COLUMNS\
loginToken  => tknID(int, primary key), token(varchar), user(varchar);\
Newsletter  => userID(int, primary key), userFullName(varchar), userEmail(varchar);\
users       => userID(int, primary key), userName(varchar), userPassword(varchar);

## Pear Mail Install
        The installation of PEAR has to be done in here and referenced in php.ini file:

        $ wget http://pear.php.net/go-pear.phar

        $ php go-pear.phar

        After that, Mail has to be installed with PEAR:

        $ pear install Mail-1.4.1

        At last, net_SMTP needs also to be installed with PEAR:
        
        $ pear install Net_SMTP.

        Mailjet is being used to deliver the emails.
        https://www.mailjet.com/

## Using the software

    The software is pretty much straight foward and easy to use.

    User Part:

    The user will get to a link in which will be to the home.php file and fill with his/her
    details and click Register in order to register to the newsletter.

    Admin Part:

    The admin is going to login on the mail-sender-login.php page, after the login, if successful,
    the admin will be redirected to mail-sender-auth.php in which in the first input area he/her will 
    be allowed to type the subject of the email and in the second is the body of the message.

    TO ADD THE CUSTOM USER NAME IN THE EMAIL: Where is to be the name of the person, $name has to be written.  

## License
[MIT](https://choosealicense.com/licenses/mit/)