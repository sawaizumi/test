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
	try
	{
		$eDB = new PDO( "mysql:dbname=d__train;host=tcth2014-den2.cloudapp.net", "test", "password" );

		$eString_SQL = "SET NAMES utf8;";
		$arArguments_SQL = array();
		$eStatement = $eDB->prepare( $eString_SQL );
		$eStatement->execute( $arArguments_SQL );
		$arStrings = array();
		while ( $eRow = $eStatement->fetch( PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT ) )
		{
			$arStrings[] = $eRow;
		}

		$eString_Debug = "";
		$eString_Debug .= print_r( $arStrings, TRUE );
		$eString_Debug .= "<br />";

		$eString_SQL = "SELECT COUNT( * ) FROM `d__train`.`t__station`;";
		$arArguments_SQL = array();
		$eStatement = $eDB->prepare( $eString_SQL );
		$eStatement->execute( $arArguments_SQL );
		$arStrings = array();
		while ( $eRow = $eStatement->fetch( PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT ) )
		{
			$arStrings[] = $eRow;
		}

		$eString_Debug .= print_r( $arStrings, TRUE );
		$eString_Debug .= "<br />";

		if ( $_GET[latitude] )
		{
			$eString_Latitude = $_GET[latitude];
		}
		else
		{
			$eString_Latitude = "35.617593";
		}
		if ( $_GET[longitude] )
		{
			$eString_Longitude = $_GET[longitude];
		}
		else
		{
			$eString_Longitude = "139.779327";
		}

		$eString_SQL = "SELECT * FROM `d__train`.`t__station` WHERE `c__lon` > ( ? - 0.05 ) AND `c__lon` < ( ? + 0.05 ) AND `c__lat` > ( ? - 0.05 ) AND `c__lat` < ( ? + 0.05 );";
		$arArguments_SQL = array();
		$arArguments_SQL[] = $eString_Longitude;
		$arArguments_SQL[] = $eString_Longitude;
		$arArguments_SQL[] = $eString_Latitude;
		$arArguments_SQL[] = $eString_Latitude;
		$eStatement = $eDB->prepare( $eString_SQL );
		$eStatement->execute( $arArguments_SQL );
		$arStrings = array();
		while ( $eRow = $eStatement->fetch( PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT ) )
		{
			$arStrings[] = $eRow["c__station_name"];
		}

		$eString_Debug .= print_r( $arStrings, TRUE );
	}
	catch ( PDOException $e )
	{
		echo $e->getMessage();
		die();
	}

	$eString_Submit = $_POST["test"];

	if ( $eString_Submit )
	{
		$eString_HTML = $eString_Submit;
		$eString_HTML .= "<br />";
		$eString_HTML .= $_POST["position_l"];
	}
	else
	{
		$eString_HTML = local_BuildHTML();

		$eString_Lines = "<option value = \"1\" >ゆりかもめ</option><option value = \"etc\" >...</option>";

		$eString_HTML = str_replace( "__LINES__", $eString_Lines, $eString_HTML );
		$eString_HTML = str_replace( "__DEBUG__", $eString_Debug, $eString_HTML );
	}

	echo $eString_HTML;
}


function local_BuildHTML()
{
	$eString_HTML = <<<EOHTML
<html>
<head>
	<meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8" />

	<script type = "text/javascript" src = "./osawa.js" ></script>
</head>


<body>
	<form name = "test" action = "osawa.php" method = "POST" >
		<input type = "hidden" name = "test" value = "test" />
		<input type = "hidden" name = "position_l" value = "test" />
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
					<input type = "submit" value = "いいね" onclick = "local_OnClick( 'good' )" />
					<input type = "submit" value = "だめね" onclick = "local_OnClick( 'bad' )" />
				</td>
			</tr>
		</table>
	</form>
__DEBUG__
</body>
</html>
EOHTML;

	return $eString_HTML;
}


?>