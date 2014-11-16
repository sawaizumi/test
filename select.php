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
	$eString_JSON = $_REQUEST( "json" );
	$eJSON = json_decode( rawurldecode( $eString_JSON ) );

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
	}
	catch ( PDOException $e )
	{
		$eJSON["error"] = $e->getMessage();
	}

	$eJSON["debug"] = $eString_Debug;
	$eString_JSON = json_encode( $eJSON );
	header( "Content-type: text/html; charset=UTF-8" );
	echo $g_eString_JSON;
}


?>