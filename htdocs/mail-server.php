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
        <input type="text" name="username" value="username" onclick="value=''"><br>
        <input type="password" name="password" value="password" onclick="value=''"><br>
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

        if($isLoginSuccessful == true){
            include 'login-page.php';
            sendEmail($loginusr);
        }
    ?>
</body>
</html>