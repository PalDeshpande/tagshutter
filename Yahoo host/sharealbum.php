<html>
<head>
        
 <title>Curl Implementation</title>

</head>
<body>

<?

$ch = curl_init("http://www.gateway18.com/domainimages.php");

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);

?>

</body>
</html>



