

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Save as html</title>
</head> 
<body>
<div class="box">
<div class="heading">Convert to Html</div>
<div class="msg"><?php if($myMsg) echo "<p>$myMsg</p>"; ?></div>
<div class="form_field">
<form enctype="multipart/form-data" method="post" action="upload2.php">
<label>Save Zip File: </label> <input type="file" name="zip_file">
<br><br>
<input type="submit" name="submit" value="Save" class="upload"> <br><br>
</form>
</div>
</div>
</body>
</html>
