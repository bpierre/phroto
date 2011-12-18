<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo (isset($title))? $title : 'Website title' ?></title>
	</head>
	<body>
		<?php echo $content ?>
		<?php echo partial('nav') ?>
	</body>
</html>
