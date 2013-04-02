<?php
include 'init.php';
if(logged_in())
{
    //redirect to home page
    header('Location:http://localhost/picup/first.php');
    exit();
}
else{
?>
<form style="position: absolute;top: 20px;right: 150px;" method="post" action="">
    
   <table>
        <tr>
            <td>
                <label name="lblUname">&nbsp;Username</label>
            </td>
            <td>
               <label name="lblPassword">&nbsp;Password</label> 
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="txtUname" />
            </td>
            <td>
                <input type="password" name="txtpswd" />
            </td>
            <td>
                <input type="submit" value="Login" />
            </td>
        </tr>
        <tr>
            <td />
            <td>
                &nbsp;Forgot Password
            </td>
        </tr>
    </table>
    
</form>
<?php
}
//$status=false;
if(isset($_POST['txtUname'],$_POST['txtpswd']) &&($_POST['txtUname']!=null || $_POST['txtpswd']!=null))
{
    
    $login_name=$_POST['txtUname'];
    $login_password=$_POST['txtpswd'];
    if(login_check($login_name,$login_password))
    {
        //$_SESSION['userid']=$login_name;
        header('Location:http://localhost/picup/first.php');//localhost
        //header('Location:http://www.gateway18.com/first.php');//yahoo
        exit();
    }
    else
    {
        echo "not matched";
    }
    //$_SESSION['uname']=$_POST['txtUname'];
    //$_SESSION['password']=$_POST['txtpswd'];
    
}
//else
//{
//    if(isset($_SESSION['userid']))
//    {
//        header('Location:home.php');
//        exit();
//    }
//    //required username and password
//    //elseif($status==false)
//    //    echo "Userid and password are required";
//}
?>

