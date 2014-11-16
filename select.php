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
	$eJSON = json_decode( "{\"analyze_request\":false}" );

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

	}
	catch ( PDOException $e )
	{
		$eJSON->error_message = $e->getMessage();
	}

	$eJSON->debug = $eString_Debug;
	$eString_JSON = json_encode( $eJSON );
	header( "Content-type: text/html; charset=UTF-8" );
	echo $g_eString_JSON;
}


?>