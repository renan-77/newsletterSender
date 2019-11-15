<html>
    <header>
        <title>Mail Server</title>
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
    <h1>Welcome to <font color= red>Mail Server</font></h1>
    <h2 style="color: grey">Please Login:</h2>
    <form name="form" action="">
        <input type="text" name="username" value="username" onfocus="value=''"><br>
        <input type="password" name="password" value="password" onfocus="value=''"><br>
        <input type="submit" name="submit" value="Submit" style="border: none;
            background-color: #f1f1f1;
            color: red;
            padding: 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            border-radius: 8px;"> 
    </form>
    <?php
        session_start();
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
        }

        //Statement for login in where login and password are surrounded with "".
        $checkLogin = 'SELECT * FROM users WHERE userName ='."\"$loginusr\"".' AND userPassword='."\"$loginpass\"".';';

        //Creating response for the query based on $checkLogin. 
        $res = $conn->query($checkLogin);

        //Calling function mysqli_num_rows with response as argument.
        $rows = mysqli_num_rows($res);

        //Evaluating if $rows function is positive if it is returns successful login.
        if($rows === 1){
            $isLoginSuccessful = true;
            echo 'SUCESSFULL LOGIN';
        
        //Returns fail login in case it is not.
        }else{
            $isLoginSuccessful = false;
            if (isset($_GET['submit'])) {
                echo "<font color= red>Wrong Credentials</font>";
            }
        }

        //In case that the login is successfull.
        if($isLoginSuccessful == true){
            
            //Generating unique token based on $loginusr.
            $token = sha1(uniqid($loginusr, true));

            //Creating statement to insert token.
            $insertToken = "INSERT INTO loginToken(token, user) VALUES('$token', '$loginusr')";
            
            //Re-declaring $conn variable due to mysqli:::query error.
            $conn = new mysqli($servername, $username, $password, $dbname);

            //Checking input of data.
            if ($conn->query($insertToken) === TRUE) {
                echo "token $token generated.";
                $_SESSION['LOGON'] = true;
                $_SESSION['refresh'] = 0;
            }else{
                echo "database insert error";
            }

            //Including login-page;
            include 'login-page.php';

            //Calling function to get the data from mail-server to login-page.php
            checkData($loginusr,$token);

            //Redirects to login-page.php
            header('Location: login-page.php');

        }$conn->close();
    ?>
</body>
</html>