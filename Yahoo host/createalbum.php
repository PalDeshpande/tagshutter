<?php
include 'init.php';
?>
<h3>Create Album</h3>
<form action="" method="post">
    <p>Name:<br /><input type="text" name="txtAlbumName" /></p>
    <p>Description:<br/><textarea name="txtDescription" rows="6" cols="35" maxlength="255"></textarea></p>
    <p><input type="submit" value="Create Album" /></p>
</form>
<?php

if(isset($_POST['txtAlbumName'],$_POST['txtDescription']))
{
    $albumerrors=array();
    $txtAlbumName=$_POST['txtAlbumName'];
    $txtDescription=$_POST['txtDescription'];
    
    if(empty($txtAlbumName) && empty($txtDescription))
        $albumerrors='Album Name and Description should not be empty';
    
    if(!empty($albumerrors))
    {
        header('Location:error.php'); 
    }
    else
    {
        create_album($txtAlbumName,$txtDescription);
        header('Location:album.php');
        //exit();
    }
    
}
?>
