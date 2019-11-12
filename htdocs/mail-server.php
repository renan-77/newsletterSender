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
    <h1>Welcome to <font color= red>Mail Server</font></h1>
    <h2 style="color: grey">Please Login:</h2>
    <form name="form" action="login-page.php">
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
    </body>
    </html>