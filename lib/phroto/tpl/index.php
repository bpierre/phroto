<?php
function files_list($pages, $parents = array()) {
	$html = '<ul>';
	foreach ($pages as $p) {
		$html .= '<li>';
		if (isset($p['files'])) {
      $local_parents = $parents;
      array_push($local_parents, $p['name']);
      $html .= $p['name'].'/';
			$html .= files_list($p['files'], $local_parents);
		} else {
      $prefix = '';
      foreach ($parents as $i => $parent) {
        $prefix .= $parent . '/';
      }
			$html .= '<a href="'.page($prefix . $p['name']).'">'.$p['name'].'</a>';
		}
		$html .= '</li>';
	}
	$html .= '</ul>';
	return $html;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $project_name ?></title>
		<style>
			a{color:#333;}
			body{width:400px;margin:40px auto;font:14px/20px sans-serif;color:#333;}
			h1{line-height:normal;text-align:center;padding-bottom:10px;border-bottom:1px solid #333;}
			ul{margin:40px 0;}
			ul ul{margin:0;}
		</style>
	</head>
	<body>
		<h1><?php echo $project_name ?></h1>
		<?php echo files_list($pages) ?>
	</body>
</html>
