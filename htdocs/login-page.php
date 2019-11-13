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
    <h1><font color= red>Mail</font> Sender</h1>
    <?php
        session_start();
        
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
            $sql = "SELECT * FROM loginToken WHERE user=\"$loginuser\";";

            $result = mysqli_query($conn,$sql);

            if (mysqli_num_rows($result) >= 1) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    echo "Token: " . $row["token"]. " - User: " . $row["user"] . "<br>";
                }
            } else {
                echo "0 results";
            }
        }

        function sendEmail($user, $token){
                // Pear Mail Library
                require_once "Mail.php";

                $from = 'Fenix Team Corp <fenixteamcorp@aol.com>';
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
            $conn->close();
    ?>
    </body>
</html>