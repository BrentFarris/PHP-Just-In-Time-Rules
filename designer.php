<?php

function listFolderFiles(&$components, $current, $dir){
	$ffs = scandir($dir);

	foreach($ffs as $ff) {
		if($ff != '.' && $ff != '..' && $ff != 'Component.php') {
			if(is_dir($dir.'/'.$ff)) {
				$parts = explode('/JITR', $dir);
				$current = '/JITR'.$parts[1].'/'.$ff;
				listFolderFiles($components, $current, $dir.'/'.$ff);
			} else {
				$fileName = str_replace('.php', '', $ff);
				$components[$fileName] = str_replace('/', "\\", $current.'/'.$fileName);
			}
		}
	}
}

$components = array();
listFolderFiles($components, '', __DIR__.'/JITR/Components');

echo '<head>
<style type="text/css">
<!--
* {margin:0; padding:0; }

html, body {
	background-color: #EEEEEE;
	font-family: arial, sans-serif;
	font-size: 16px;
}

#leftBar {
	position: fixed;
	width: 10%;
	right: 0;
	border-left: 1px solid black;
	height: 100%;
	float: left;
	z-index: 99;
	background-color: #FFF;
}

#viewport {
	position: fixed;
	width: 90%;
	height: 100%;
}
-->
</style>
<script type="text/javascript">
var WEB2D_DIR = "Web2D/";
var components = [';
$first = true;
foreach ($components as $key => $value) {
	if (!$first) {
		echo ',';
	}

	echo '["' . $key . '","' . $value . '"]';
}
echo '];</script>';
?>

<body>
	<div id="leftBar">
		<?php
		foreach ($components as $key => $value) {
			echo '<input type="button" value="' . $key . '" name="' . $value . '" /><br />';
		}
		?>
	</div>
	<canvas id="viewport">

	</canvas>
	<script src="Web2D/web2d.js"></script>
	<script src="Web2D/Demo/camera.js"></script>
<script type="text/javascript">
	registerCanvas(document.getElementById("viewport"), 1.0, 1.0);
	Canvas.Scale(1.0, 1.0);
	var camera = new Camera();

	var rect = new $Rectangle(10, 10, 50, 50, new $Color(0, 255, 0, 1));

	function DrawRect(canvas) {
		rect.Draw(canvas);
	}

	function CameraMove(x, y) {
		rect.x += x;
		rect.y += y;
	}

	var previousMouse = new $Vector2();
	function Update() {
		if (Input.mouseIsDown) {
			var distance = new $Vector2(Input.mousePosition.x - previousMouse.x, Input.mousePosition.y - previousMouse.y);
			camera.Move(distance.x, distance.y);
		}

		previousMouse.x = Input.mousePosition.x;
		previousMouse.y = Input.mousePosition.y;
	}

	function KeyPress(keycode) {
		if (keycode == Keys.H) {
			camera.SetPosition(0, 0);
		}
	}

	$Document.onmousemove.Register(Update);
	camera.moved.Register(CameraMove);
	Canvas.drawing.Register(DrawRect);
	Input.keyDown.Register(KeyPress);
</script>
</body>