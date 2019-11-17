<?php 
    //Generating variables from the user input.
    $nameInput = $_GET['userName'];
    $emailAddress =$_GET['email'];
?>
<html>
    <header>
        <title>Newsletter System</title>
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
        <h1>
            <?php
            //Generating a Greeting based on the name of the user.
                if($nameInput == ""){
                    echo 'Hi, <font color=red>user</font>.';
                }else{
                    echo "Hi, <font color=red>$nameInput</font>.";
                }
            ?>
        </h1>
        <!-- Generating form to get the user inputs from text with submit button. -->
        <form name="form" action="" method="get">
        <p class="pname">
            <?php
                //Checks if form is submitted.
                if (isset($_GET['submit'])) {
                    $isUserDataValid = false;
                //Checking if name was altered with something, If not returns a red warning.
                    if($nameInput == "name" || $nameInput == ""){
                        echo '<style>
                                .pname{
                                    color: red;
                                }
                            </style>';
                        echo 'Please insert your name!';
                    //Giving output of name in case that it was altered.
                    }else if($emailAddress != "email" && $nameInput != "name" && strpos($emailAddress,'@')){
                        echo $nameInput;
                        $isUserDataValid = true;
                    }
                }
            ?>
        </p>
        <input type="text" name="userName" value="name" onfocus="value=''">
        <br>
        <p class="pemail"><?php
            //Checks if form is submitted.
            if (isset($_GET['submit'])) {
                ////Checking if email was altered with something, If not returns a red warning.
                if($emailAddress == "email" || $emailAddress == "" || strpos($emailAddress,'@') === false || strpos($emailAddress,'.') === false){
                    echo '<style>
                            .pemail{
                                color: red;
                            }
                        </style>';
                    $isUserDataValid = false;
                    echo 'Invalid email format!';
                //Giving output of email in case that it was altered.
                }else{
                    $isUserDataValid = true;
                    echo $emailAddress;
                }
            }
        ?></p>
        <input type="text" name="email" value="email" onfocus="value=''">
        <br>
        <br>
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
        <input type="button" name="Staff" value="Staff Login" style="border: none;
            background-color: #f1f1f1;
            color: red;
            padding: 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            border-radius: 8px;" onclick="document.location.href='mail-sender-login.php'"> 
        <h2>
            <?php
                //Checks if the form is submitted.
                if (isset($_GET['submit'])) {
                    //Checking if the fields are altered to start connection.
                    if($isUserDataValid){
                        //Data for connection.
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

                        //Inserting onto database statement.
                        $stmt = "INSERT INTO Newsletter (userFullName, userEmail)
                                    VALUES('$nameInput', '$emailAddress');";

                        //Inserting on database in case that the fields were properly altered.
                            if ($conn->query($stmt) === TRUE) {
                                echo '<style>
                                    h2{
                                        color: green;
                                    }
                                </style>';
                                echo "You've Succefully registred for our newsletter!";
                            } else {
                                echo "Error: " . $stmt . "<br>" . $conn->error;
                            }
                        //Closing Connection.
                        $conn->close(); 
                    }//Returns fields are blank in red in case both fields are empty.
                    else{
                        echo '<style>
                                h2{
                                    color: red;
                                }
                            </style>';
                        echo "Fields are blank, please insert the requested data";
                    }
                }
                
            ?>
        </h2>
    </body>
</html>