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
	$eString_JSON = "{\"stations\":[{\"id\": 9931109, \"name\": \"テレコムセンター\", \"lat\": 35.617593, \"lon\": 139.779327}]}";
//	$eJSON = json_decode( "{\"analyze_request\":false}" );
//	$eJSON = json_decode( $eString_JSON );

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

//	$eString_JSON = json_encode( $eJSON );
	header( "Content-type: text/html; charset=UTF-8" );
	echo $eString_JSON;
}


function local_JSON_Encode( $eJSON )
{
	if ( is_array( $eJSON ) )
	{
		$eString_JSON = local_JSON_Encode_Array( $eJSON );
	}
	else
	{
		$eString_JSON = "{" . $eJSON . "}";
	}

	return $eString_JSON;
}


function local_JSON_Encode_Array( $eJSON )
{
	if ( array_diff_key( $eJSON, array_keys( array_keys( $eJSON ) ) ) )
	{
		$eString_JSON = local_JSON_Encode_Assoc( $eJSON );
	}
	else
	{
		$eString_JSON = "[";
		foreach ( $eJSON as $eValue )
		{
			if ( is_array( $eJSON ) )
			{
				$eString_JSON = local_JSON_Encode_Array( $eValue ), ",";
			}
			else
			{
				$eString_JSON .= $eValue . ",";
			}
		}
		$eString_JSON .= "]";
	}

	return $eString_JSON;
}


function local_JSON_Encode_Assoc( $eJSON )
{
	$eString_JSON = "{";
	foreach ( $eJSON as $eKey => $eValue )
	{
		if ( is_array( $eJSON ) )
		{
			$eString_JSON = "\"" . $eKey . "\":" . local_JSON_Encode_Array( $eValue ), ",";
		}
		else
		{
			$eString_JSON .= "\"" . $eKey . "\":" . $eValue . ",";
		}
	}
	$eString_JSON .= "}";

	return $eString_JSON;
}


?>