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
	echo local_BuildHTML();
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
			<option value = "1" >line1</option>
			<option value = "2" >line2</option>
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