<?php
 $search = $_POST['toreplace'];
 $replacer= $_POST['replacer'];
 $filename=$_POST['file'];
 $contents = file_get_contents($filename);
 $contents = str_replace($search, $replacer, $contents,$count);
 if($count>0)
 {
  file_put_contents($filename,$contents);
  echo "found and removed";
 }
 else
 {
  echo "not found";
 }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>yugiv</title>
	</head>
<body>
	<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
		<input type="text" name="toreplace" />
		<input type="text" name="replacer" />
		<input type="text" name="file" />
		<input type="submit"/>
	</form>
</body>
</html>