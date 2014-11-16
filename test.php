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
	header( "Content-type: text/html; charset=UTF-8" );
	echo "{\"stations\":false}";
}


?>