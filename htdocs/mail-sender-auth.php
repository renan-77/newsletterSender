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
    <title>Mail Sender</title>
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
            function getNames(){
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
    
                //Sql statement.
                $sql = "SELECT * FROM Newsletter;";
    
                //Sql Query.
                $result = mysqli_query($conn,$sql);
    
                //Checking if the query returns any result.
                if ($row = mysqli_num_rows($result) > 0) {
                    $name = [];
                    $email = [];
                    $counter = 0;

                    //Running while condition to create array $row_print.
                     while($row_print = mysqli_fetch_array($result)){
                       /* print_r("Name: " . $row_print['userFullName']);

                        echo "<br>";

                        print_r("Email: " . $row_print['userEmail']);

                        echo "<br>";  */

                        //Creating array $name with the registers of names in the $row_print array.
                        $name[$counter] = $row_print['userFullName'];

                        //Creating array $email with the registers of names in the $row_print array.
                        $email[$counter] = $row_print['userEmail'];

                        //Increasing counter for array population
                        $counter++;
                    }
                    //Calling writeMessage function.
                    writeMessage($name,$email);

                //Returns no results if there's none.
                }else {
                    echo "No results";
                }
            }
        /**
         * The emails(both the subject and the message) will be written with that function,
         * $name is the argument and also, it has to be written in where the names of the user will be.
         */
            function writeMessage($registers,$mail_list){  
                $subjects = [];
                $messages = [];

                //Checks the form submission.
                if(isset($_GET['submit'])){  
                    //Variables based on the input fields.  
                    $subject = $_GET['subject'];
                    $message = $_GET['message'];

                    /* Printing values of the array name in a loop based on input with $name as the field in where the names will be 
                    customised for each subscriber. */
                    for($i = 0; $i < sizeof($registers); $i++){
                        /* echo str_replace('$name',$registers[$i],$subject) . "<br>" . str_replace('$name',$registers[$i],$message . "<br>"); */
                        //Adding the registers to a subject list for each of the users.
                        $subjects[$i] = str_replace('$name',$registers[$i],$subject);
                         //Adding the registers to a message list for each of the users.
                        $messages[$i] = str_replace('$name',$registers[$i],$message);
                    }
                    print_r($subjects);
                    echo "<br>";
                    print_r($messages);
                    echo "<br>";
                    print_r($mail_list);
                }
            }
            //Calling getNames() to start the code when getting to this page.
            getNames();
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

            //Sql statement.
            $sql = "SELECT * FROM loginToken WHERE token=\"$token\";";

            //Sql Query.
            $result = mysqli_query($conn,$sql);

            //Checking if the query returns any result.
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $dbuser = $row["user"];

                //Checking if the user is the same as the one on the database.
                if($dbuser == $loginuser){
                    header('Location: login-page.php');  
                }
            //Returns no results if there's none.
            } else {
                echo "No results";
            }
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

                //Setting variables for mail sending.
                $from = 'Fenix Team Corp <fenixteamcorporation@gmail.com>';
                $to = '<renanmonteiroft@gmail.com>';
                $subject = 'Hi!';
                $body = "Hi, $user How are you?";

                //Populating array with mail specifications.
                $headers = array(
                    'From' => $from,
                    'To' => $to,
                    'Subject' => $subject
                );

                //Smtp connection fields.
                $smtp = Mail::factory('smtp', array(
                        'host' => 'in-v3.mailjet.com',
                        'port' => '587',
                        'auth' => true,
                        'username' => 'b7e32e4a86776c60a4fff3215b055a44',
                        'password' => 'e6f8618e45c6d856dc098b5fd4187182'
                    ));

                //Send email function execution. 
                $mail = $smtp->send($to, $headers, $body);

                //Email sent with success checks.
                if (PEAR::isError($mail)) {
                    echo('<p>' . $mail->getMessage() . '</p>');
                } else {
                    echo('<p>Message successfully sent!</p>');
                }
        }
    ?>
    </body>
</html>