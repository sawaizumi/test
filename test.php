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
	$eString_JSON = "{\"stations\":[{\"id\": 9931109, \"name\": \"テレコムセンター\", \"lat\": 35.617593, \"lon\": 139.779327},{\"id\": 9931108, \"name\": \"船の科学館\", \"lat\": 35.621462, \"lon\": 139.773157},{\"id\": 9931110, \"name\": \"青海\", \"lat\": 35.624670, \"lon\": 139.781132}]}";
	header( "Content-type: text/html; charset=UTF-8" );
	echo $eString_JSON;
}


?>