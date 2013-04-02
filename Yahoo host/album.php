<?php
include 'init.php';
?>
<h3>View Albums</h3>
<?php
$albums=get_album();
if(empty($albums))
{
    echo '<p>No albums found.</p>';
}
else
{
    //albums present here
    foreach($albums as $list)
    {
        echo '<p><a href="viewalbum.php?albumid=',$list['id'],'">',$list['name'],'</a> (',$list['imagecount'],' images)<a href="uploadimage.php">Upload Image</a> <br/>';
        echo $list['description'];
        echo '<br /><a href="editalbum.php?albumid=',$list['id'],'">Edit</a>',' / ','<a href="deletalbum.php?albumid=',$list['id'],'">Delete</a></p>';
        //echo $album['id'];
    }
    //for(int i=0;i<)
}


?>