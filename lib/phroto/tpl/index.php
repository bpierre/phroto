<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $project_name ?></title>
		<style>
			body{width:400px;margin:40px auto;font:14px sans-serif;color:#333;}
			h1{text-align:center;}
			ul{margin:40px 0;}
		</style>
	</head>
	<body>
		<h1><?php echo $project_name ?></h1>
		<ul>
<?php foreach ($pages as $p): ?>
			<li><a href="<?php echo page($p) ?>"><?php echo $p ?></a></li>
<?php endforeach ?>
		</ul>
	</body>
</html>