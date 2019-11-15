<?php
    //Starting session
   session_start();

   //Checking if logon session variable is true to supply the page.
   if($_SESSION['LOGON'] != true){
       header('Location: error.php');
       die();
   }
   //Increasing session timesRefreshed variable.
   $_SESSION['refresh']++;

   //If refresh greater or equals five, end's session.
   if($_SESSION['refresh'] >= 5){
       session_destroy();
   }
?>
<html>
    <header>
        <style>
        body{
            margin-top: 20vh;
            text-align: center;
            /**margin: 0 auto;*/
            background-color: #2d2d2d;
            color: white;
            font-family: arial;
        }
        </style>
    </header>
    <body>
    <h1 style="font-size: 10vh; padding: 0px; margin: 0px;"><font color= red>Mail</font> Sender</h1>
    <form name="form" action="">
    <input type="text" name="subject" value="Type subject in here!" size="107" style="font-family: arial; font-size: 1em;" onfocus="value=''"><br>
    <textarea name="message" rows="15" cols="105" onfocus="value=''" style="font-family: arial">Type the mail in here!</textarea><br>
    <input type="submit" name="submit" value="Submit" style="border: none;
            background-color: #f1f1f1;
            color: red;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
            margin: 4px 2px;
            border-radius: 8px;">
    </form>
    <p>
        <?php
            function writeMessage(){    
                if(isset($_GET['submit'])){    
                    $subject = $_GET['subject'];
                    $message = $_GET['message'];
                    $name = "Renan";

                    echo str_replace('$name',$name,$subject) . "<br>" . str_replace('$name',$name,$message);
                }
            }
            writeMessage();
        ?>
    </p>
    <?php
        /**
         * Checks if the generated token is in the database
         * Params -> $loginuser = The user used to login.
         *           $token = Unique token generated.
         */
        function checkData($loginuser, $token){
            $servername = "localhost";
            $username = "renan";
            $password = "000";
            $dbname = "renan";
            
            // Connection statement.
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM loginToken WHERE token=\"$token\";";

            $result = mysqli_query($conn,$sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $dbuser = $row["user"];

                if($dbuser == $loginuser){
                    header('Location: login-page.php');  
                }

            } else {
                echo "0 results";
            }$conn->close();
        }

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
        function sendEmail($user, $token){
                // Pear Mail Library
                require_once "Mail.php";

                $from = 'Fenix Team Corp <fenixteamcorporation@gmail.com>';
                $to = '<renanmonteiroft@gmail.com>';
                $subject = 'Hi!';
                $body = "Hi, $user How are you?";

                $headers = array(
                    'From' => $from,
                    'To' => $to,
                    'Subject' => $subject
                );

                $smtp = Mail::factory('smtp', array(
                        'host' => 'in-v3.mailjet.com',
                        'port' => '587',
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
            }
    ?>
    </body>
</html>