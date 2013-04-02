<?php
include 'init.php';
?>
<body>
<?php
$albums=mysql_query("SELECT albumid FROM tbl_albums");


while($albumrow=mysql_fetch_assoc($albums))
{
    $albumid=$albumrow['albumid'];
    $images=mysql_query("SELECT imageid,ext FROM tbl_images where albumid='$albumid'");//.$albumrow['albumid'].");
    while($imagerow=mysql_fetch_assoc($images))
    {
        $imageid=$imagerow['imageid'];
        $ext=$imagerow['ext'];
        echo '<p>';
        echo '<img src="http://www.gateway18.com/uploads/thumbs/'.$albumid.'/'.$imageid.'.'.$ext.'"/><br />';
        //echo '<img src="uploads/thumbs/'.$albumid.'/'.$imageid.'.'.$ext.'"/><br />';
        echo '</p>';
    }
}

?>
</body>