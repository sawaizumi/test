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
	$eString_Debug = "";

	$eString_JSON = "{\"stations\":[{\"id\": 9931109, \"name\": \"テレコムセンター\", \"lat\": 35.617593, \"lon\": 139.779327}]}";
	$eJSON = json_decode( $eString_JSON );

	$eString_Latitude = "35.617593";
	$eString_Longitude = "139.779327";
	if ( $_REQUEST["lat"] )
	{
		$eString_Latitude = $_REQUEST["lat"];
	}
	if ( $_REQUEST["lon"] )
	{
		$eString_Longitude = $_REQUEST["lon"];
	}

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
			$rDistance = ( $eString_Longitude - $eRow["c__lon"] ) * ( $eString_Longitude - $eRow["c__lon"] ) + ( $eString_Latitude - $eRow["c__lat"] ) * ( $eString_Latitude - $eRow["c__lat"] );
			$eRow["distance"] = $rDistance;
			$arStrings_Distance[] = $rDistance;
			$arStrings[] = $eRow;
		}
		$arStrings_Sorted = $arStrings;
		array_multisort( $arStrings_Distance, $arStrings_Sorted, SORT_NUMERIC );
		$arStations = array();
		foreach ( $arStrings_Sorted as $eRow )
		{
			$aaStation = array();
			$aaStation["id"] = $eRow["c__station_cd"];
			$aaStation["name"] = $eRow["c__station_name"];
			$aaStation["lat"] = $eRow["c__lat"];
			$aaStation["lon"] = $eRow["c__lon"];
			$arStations[] = $aaStation;
		}
		$eJSON->stations = $arStations;

/*		$eString_Debug .= print_r( $arStrings, TRUE );
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
*/
	}
	catch ( PDOException $e )
	{
		$eJSON->error_message = $e->getMessage();
	}

	$eJSON->debug = $eString_Debug;
	$eString_JSON = json_encode( $eJSON );
	header( "Content-type: text/html; charset=UTF-8" );
	echo $eString_JSON;
}


?>