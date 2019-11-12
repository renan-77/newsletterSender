<?php
        $loginusr = $_GET['username'];
        $loginpass = $_GET['password'];
        //Data for connection.
        $servername = "localhost";
        $username = "renan";
        $password = "000";
        $dbname = "renan";
        $isLoginSuccessful = false;
        
        // Connection statement.
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }echo 'Connection Success!<br>';

        //Statement for login in where login and password are surrounded with "".
        $stmt = 'SELECT * FROM users WHERE userName ='."\"$loginusr\"".' AND userPassword='."\"$loginpass\"".';';

        //Creating response for the query based on $stmt. 
        $res = $conn->query($stmt);

        //Calling function mysqli_num_rows with response as argument.
        $rows = mysqli_num_rows($res);

        //Evaluating if $rows function is positive if it is returns successful login.
        if($rows === 1){
            $isLoginSuccessful = true;
            echo 'SUCESSFULL LOGIN';
        
            //Returns fail login in case it is not.
        }else{
            $isLoginSuccessful = false;
            echo "Wrong Credentials";
}     
?>
<html>
    <header>
        <style>
        body{
            margin-top: 30vh;
            text-align: center;
            /**margin: 0 auto;*/
            background-color: #2d2d2d;
            color: white;
            font-family: arial;
        }
        </style>
    </header>
    <body>
    <?php
    /**
     * The installation of PEAR has to be done in here and referenced in php.ini file:
     * $ wget http://pear.php.net/go-pear.phar
     * $ php go-pear.phar
     * 
     * After that, Mail has to be installed with PEAR:
     * pear install Mail-1.4.1
     * 
     * At last, net_SMTP needs also to be installed with PEAR:
     * pear install Net_SMTP.
     * 
     * Mailjet is being used to deliver the emails.
     * https://www.mailjet.com/
     * 
     */
        // Pear Mail Library
        require_once "Mail.php";

        $from = 'Fenix Team Corp <fenixteamcorporation@gmail.com>';
        $to = '<renanmonteiroft@gmail.com>';
        $subject = 'Hi!';
        $body = "Hi,$loginusr How are you?";

        $headers = array(
            'From' => $from,
            'To' => $to,
            'Subject' => $subject
        );

        $smtp = Mail::factory('smtp', array(
                'host' => 'in-v3.mailjet.com',
                'port' => '25',
                'auth' => true,
                'username' => 'b7e32e4a86776c60a4fff3215b055a44',
                'password' => 'e6f8618e45c6d856dc098b5fd4187182'
            ));

        $mail = $smtp->send($to, $headers, $body);

        if (PEAR::isError($mail)) {
            echo('<p>' . $mail->getMessage() . '</p>');
        } else {
            echo('<p>Message successfully sent!</p>');
        }
    ?>
    </body>
</html>