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

		$eString_SQL = "SELECT `at__S`.`c__station_cd` AS `ac__station_cd`, `at__S`.`c__station_name` AS `ac__station_name`, `at__S`.`c__lon` AS `ac__lon`, `at__S`.`c__lat` AS `ac__lat`, `at__L`.`c__line_cd` AS `ac__line_cd`, `at__L`.`c__line_name` AS `ac__line_name` FROM `d__train`.`t__station` AS `at__S` INNER JOIN `d__train`.`t__line` AS `at__L` ON `at__S`.`c__line_cd` = `at__L`.`c__line_cd` WHERE `at__S`.`c__lon` > ( ? - 0.02 ) AND `at__S`.`c__lon` < ( ? + 0.02 ) AND `at__S`.`c__lat` > ( ? - 0.02 ) AND `at__S`.`c__lat` < ( ? + 0.02 );";
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
			$rDistance = ( $eString_Longitude - $eRow["ac__lon"] ) * ( $eString_Longitude - $eRow["ac__lon"] ) + ( $eString_Latitude - $eRow["ac__lat"] ) * ( $eString_Latitude - $eRow["ac__lat"] );
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
			$aaStation["id"] = $eRow["ac__station_cd"];
			$aaStation["name"] = $eRow["ac__station_name"] . "(" . $eRow["ac__line_name"] . ")";
			$aaStation["lat"] = $eRow["ac__lat"];
			$aaStation["lon"] = $eRow["ac__lon"];
			$arStations[] = $aaStation;
		}
		$eJSON->stations = $arStations;

		$eString_SQL = "SELECT * FROM `d__train`.`t__line` WHERE `c__line_cd` IN ( SELECT `c__line_cd` FROM `d__train`.`t__station` WHERE `at__S`.`c__lon` > ( ? - 0.02 ) AND `at__S`.`c__lon` < ( ? + 0.02 ) AND `at__S`.`c__lat` > ( ? - 0.02 ) AND `at__S`.`c__lat` < ( ? + 0.02 ) );";
		$arArguments_SQL = array();
		$arArguments_SQL[] = $eString_Longitude;
		$arArguments_SQL[] = $eString_Longitude;
		$arArguments_SQL[] = $eString_Latitude;
		$arArguments_SQL[] = $eString_Latitude;
		$eStatement = $eDB->prepare( $eString_SQL );
		$eStatement->execute( $arArguments_SQL );
		$arStrings = array();
		$arStrings_Debug = array();
		while ( $eRow = $eStatement->fetch( PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT ) )
		{
			$arStrings[] = $eRow;
		}
		$arLines = array();
		$arStrings_Sorted = $arStrings;
		foreach ( $arStrings_Sorted as $eRow )
		{
			$aaLine = array();
			$aaLine["id"] = $eRow["c__line_cd"];
			$aaLine["name"] = $eRow["c__line_name"];
			$arLines[] = $aaLine;
		}
		$eJSON->lines = $arLines;
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