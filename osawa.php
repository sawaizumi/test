<?php
// 日本語UTF-8, LF


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
	$eString_Submit = $_POST["submit"];

	if ( defined( $eString_Submit ) )
	{
		$eString_HTML = $eString_Submit;
	}
	else
	{
		$eString_HTML = local_BuildHTML();

		$eString_Lines = "<option value = \"1\" >ゆりかもめ</option><option value = \"etc\" >...</option>";

		$eString_HTML = str_replace( "__LINES__", $eString_Lines, $eString_HTML );
	}

	echo $eString_HTML;
}


function local_BuildHTML()
{
	$eString_HTML = <<<EOHTML
<html>
<head>
	<script type = "text/javascript" src = "./osawa.js" ></script>
</head>


<body>
	<form name = "test" action = "osawa.php" method = "POST" >
		<table>
			<tr>
				<td>
					<select name = "line" >
__LINES__
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<select name = "station" >
						<option value = "1" >station1</option>
						<option value = "2" >station2</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<input type = "submit" value = "いいね" onclick = "local__OnClick( 'good' )" />
					<input type = "submit" value = "だめね" onclick = "local__OnClick( 'bad' )" />
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