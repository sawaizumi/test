<?php


// include


// define


// global


// main
{
	Main( $argv );

	exit;
}
function Main( $arStrings_Argument )
{
	$eString_HTML = local_BuildHTML();

	$eString_Lines = "<option value = \"1\" >ゆりかもめ</option><option value = \"etc\" >...</option>";

	$eString_HTML = str_replace( "__LINES__", $eString_Lines, $eString_HTML );

	echo $eString_HTML;
}


function local_BuildHTML()
{
	$eString_HTML = <<<EOHTML
<html>
<body>
<form name = "test" action = "osawa.php" method = "POST" >
<table>
<tr>
	<td>
		<select name = "line" >
__LINES__
		</select>
	</td>
	<td>
		<select name = "station" >
			<option value = "1" >station1</option>
			<option value = "2" >station2</option>
		</select>
	</td>
	<td>
		<input type = "submit" value = "good" />
		<input type = "submit" value = "bad" />
	</td>
</tr>
</table>
</form>
</body>
</html>
EOHTML;

	return $eString_HTML;
}


?>