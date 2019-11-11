<?php 
    //Generating variables from the user input.
    $nameInput = $_GET['userName'];
    $emailAddress = $_GET['email'];
?>
<html>
    <header>
        <style>
        body{
            margin-left: 3%;
            background-color: #2d2d2d;
            color: white;
        }
        </style>
    </header>
    <body>
        <h1>
            <?php
            //Generating a Greeting based on the name of the user.
                if($nameInput == ""){
                    echo 'Hi, user.';
                }else{
                    echo "Hi, $nameInput.";
                }
            ?>
        </h1>
        <!-- Generating form to get the user inputs from text with submit button. -->
        <form name="form" action="" method="get">
        <p class="pname">
            <?php
            //Checking if name was altered with something, If not returns a red warning.
                if($nameInput == "name" || $nameInput == ""){
                    echo '<style>
                            .pname{
                                color: red;
                            }
                        </style>';
                    echo 'Please Insert Your Name!';
                //Giving output of name in case that it was altered.
                }else if($emailAddress != "email" && $nameInput != "name"){
                    echo $nameInput;
                }
            ?>
        </p>
        <input type="text" name="userName" value="name">
        <br>
        <br>
        <p class="pemail"><?php
            ////Checking if email was altered with something, If not returns a red warning.
            if($emailAddress == "email" || $emailAddress == ""){
                echo '<style>
                        .pemail{
                            color: red;
                        }
                      </style>';
                echo 'Please Insert Your Email!';
            //Giving output of email in case that it was altered.
            }else if($emailAddress != "email" && $nameInput != "name"){
                echo $emailAddress;
            }
        ?></p>
        <input type="text" name="email" value="email">
        <br>
        <br>
        <input type="submit" value="Submit"> 
        </form>
        <h2>
            <?php
                //Checking if the fields are altered to start connection.
                if($emailAddress != "email" && $nameInput != "name"){
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
                    if($emailAddress != "email" && $nameInput != "name" && $emailAddress != "" && $nameInput != ""){
                        if ($conn->query($stmt) === TRUE) {
                            echo "You've Succefully registred for our newsletter!";
                        } else {
                            echo "Error: " . $stmt . "<br>" . $conn->error;
                        }
                    }
                }
                //Closing Connection.
                $conn->close();
            ?>
        </h2>
    </body>
</html>