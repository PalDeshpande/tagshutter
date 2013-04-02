<html>
<head>
    <title>Home Page</title>
</head>
<body background="bg.jpg">
<div style="position: absolute;top: 160px;left: 130px;">
    <iframe width="560" height="315" src="http://www.youtube.com/embed/VUPzr2MGKMs" frameborder="0" allowfullscreen></iframe>
</div>
<form style="position: absolute;top: 20px;right: 150px;" action="" method="post">
    <p>User Name <input type="text" name="txtUserName" /><br />
        Password&nbsp;&nbsp; <input type="password" name="txtPassword" /><br />
        <input type="submit" value="Login" />
    </p>
</form>
<?php
ob_start();
include 'init.php';
?>
<?php
if(isset($_POST['txtUserName'],$_POST['txtPassword']))
{
    $indexUserName=$_POST['txtUserName'];
    $indexPassword=$_POST['txtPassword'];
    if(empty($indexUserName)&& empty($indexPassword))
    {
        echo '<p>Username and password should not be empty</p>';
    }
    else{
        if(login_check($indexUserName,$indexPassword)==true)
        {
            //$_SESSION['userid']=$_POST['txtUserName'];
            //header('Location:first.php');
            //setcookie("userid", $_POST['txtUserName'], time()+3600);
            //echo $_COOKIE['userid'];
            //echo '<META HTTP-EQUIV="refresh" content="0;URL=\'first.php\'">'; 
            //ob_end_flush();
session_register("indexUserName");
echo '<META HTTP-EQUIV="refresh" content="0;URL=\'first.php\'">';
        }
        else{
            echo '<p>Username ',$indexUserName,' and password ',$indexPassword,' didn\'t matched</p>';
        }
    }
}
ob_end_flush();
?>
</body>
</html>