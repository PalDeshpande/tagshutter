<?php
include 'init.php';

if(!logged_in())
{
    header('Location:index.php');
    exit();
}
?>
<?php
$albums=get_album();

if(!empty($albums)){
?>
    <form action="" method="post" enctype="multipart/form-data">
        <p>Choose a file:<br /><input type="file" name="image" /></p>
        <p>
            Choose an album<br />
            <select name="album_id">
                <?php
                    foreach($albums as $album)
                    {
                        echo '<option value="',$album['id'],'">',$album['name'],'</option>';
                    }
                ?>
            </select>
        </p>
        <p><input type="submit" value="Upload" /></p>
    </form>
<?php    
}
else{
    echo '<p>You don\'t have any albums.';
}
?>
<?php
if(isset($_FILES['image'], $_POST['album_id']))
{
    $image_name = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_temp = $_FILES['image']['tmp_name'];
    
    $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
    $var=explode('.', $image_name);
    $image_ext = strtolower(end($var));
    
    $album_id = $_POST['album_id'];
    
    $errors = array();
    
    if (empty($image_name) || empty($album_id)){
        $errors[] = 'image name or album is missing';
    }
    else
    {    
        if(in_array($image_ext, $allowed_ext) === false){
            $errors[] = 'File type not allowed';
        }
    
        if($image_size > 2097152){
            $errors[] = 'Maximum file size is 2MB'; 
        }
    
        //if(album_check($album_id) === false){
        //    $errors[] = 'Couldn\'t upload to that album';
        //}
    
    }
    
    if(!empty($errors)){
        foreach ($errors as $error){
            echo $error, '<br />';
        }
    } else {
        // upload image
        uploadimage($image_temp,$image_ext,$album_id);
        header('Location:viewalbum.php?albumid='.$album_id);
    }
}
?>