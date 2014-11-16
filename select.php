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

		if ( $_REQUEST[latitude] )
		{
			$eString_Latitude = $_REQUEST[latitude];
		}
		else
		{
			$eString_Latitude = "35.617593";
		}
		if ( $_REQUEST[longitude] )
		{
			$eString_Longitude = $_REQUEST[longitude];
		}
		else
		{
			$eString_Longitude = "139.779327";
		}

		$eString_SQL = "SELECT * FROM `d__train`.`t__station` WHERE `c__lon` > ( ? - 0.02 ) AND `c__lon` < ( ? + 0.02 ) AND `c__lat` > ( ? - 0.02 ) AND `c__lat` < ( ? + 0.02 );";
		$arArguments_SQL = array();
		$arArguments_SQL[] = $eString_Longitude;
		$arArguments_SQL[] = $eString_Longitude;
		$arArguments_SQL[] = $eString_Latitude;
		$arArguments_SQL[] = $eString_Latitude;
		$eStatement = $eDB->prepare( $eString_SQL );
		$eStatement->execute( $arArguments_SQL );
		$arStrings = array();
		$arStrings_Distance = array();
		$arStrings_Debug = array();
		while ( $eRow = $eStatement->fetch( PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT ) )
		{
			$arStrings_Debug[] = $eRow["c__station_name"];
			$rDistance = ( $eString_Longitude - $eRow["c__lon"] ) * ( $eString_Longitude - $eRow["c__lon"] ) + ( $eString_Latitude - $eRow["c__lat"] ) * ( $eString_Latitude - $eRow["c__lat"] );
			$eRow["distance"] = $rDistance;
			$arStrings_Distance[] = $rDistance;
			$arStrings[] = $eRow;
		}

		$eString_Debug .= print_r( $arStrings_Debug, TRUE );
		$eString_Debug .= "<br />";
		$arStrings_Sorted = $arStrings;
		array_multisort( $arStrings_Distance, $arStrings_Sorted, SORT_NUMERIC );
		$eString_Debug .= print_r( $arStrings_Sorted, TRUE );
		$eString_Debug .= "<br />";

		$arStrings_Station = array();
		foreach ( $arStrings_Sorted as $eRow )
		{
			$arStrings_Station[] = array( "code" => $eRow["c__station_cd"], "name" => $eRow["c__station_name"] );
		}

		$eJSON["stations"] = $arStrings_Station;

		$eJSON["debug"] = $eString_Debug;
	}
	catch ( PDOException $e )
	{
		$eJSON["error"] = $e->getMessage();
	}

	$eString_JSON = json_encode( $eJSON );
	header( "Content-type: text/html; charset=UTF-8" );
	echo $g_eString_JSON;
}


?>