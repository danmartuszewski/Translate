<?php
	$string = isset($_GET['string']) ? htmlentities(strip_tags(trim($_GET ['string'])), ENT_QUOTES, 'utf-8') : '';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Translator - bases on Google Translate AJAX API</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		
	</head>
	<body>
		<div id="container">
			
			<form name="translateForm" action="system/translate.php" method="post" onsubmit="stopForm(event);">
				<p>
					<input type="text" name="text" id="text" value="<?php echo $string; ?>"  />
					<input type="submit" value="Tłumacz" id="submit" onclick="process();" />
				</p>
				<p class="langSettings"> Język orginału: 
					<select name="langFrom" id="langFrom">
						<option value="pl">Polish</option>
						<option value="en">English</option>
						<option value="de">German</option>
					</select>
				</p>
				<input type="button" class="changeImg" value="Zamień" onclick="replaceL();"/>
				<p class="langSettings"> Język docelowy: 
					<select name="langTo" id="langTo">
						<option value="en">English</option>
						<option value="pl">Polish</option>
						<option value="de">German</option>
					</select>
				</p>
				
			</form>
			
			<p id="result"></p>


		</div><!-- end #container -->
		<div id="footer">
			Google Translate API | PHP | JavaScript | SQL <br />
			by <strong>gcdreak</strong>			
		</div>
		<!-- JavaScript -->
		<script type="text/javascript" src="init.js"></script>
		
		<?php
		
			if(isset($_GET['string'])) {
echo <<<SCRIPT
<script>
	document.getElementById('submit').click();
</script>
SCRIPT;
			}
		?>
	</body>
</html>
