// 日本語UTF-8, LF


// global
var g_eString_FormName = "test";


// -------------------------------------------------------------------
// event ( onclick )

function local_OnClick( eString_Submit )
{
	if ( navigator.geolocation )
	{
		navigator.geolocation.getCurrentPosition( callback_getCurrentPosition__Success, callback_getCurrentPosition__Failure );
		document[g_eString_FormName].test.value = eString_Submit;
	}
	else
	{
		alert( "navigator.geolocation : false" );
		return false;
	}

	function callback_getCurrentPosition__Success( ePosition )
	{
		document[g_eString_FormName].position_latitude.value = ePosition.coords.latitude;
		document[g_eString_FormName].position_longitude.value = ePosition.coords.longitude;
		document[g_eString_FormName].position_altitude.value = ePosition.coords.altitude;
		document[g_eString_FormName].position_accuracy.value = ePosition.coords.accuracy;
		document[g_eString_FormName].position_altitudeaccuracy.value = ePosition.coords.altitudeAccuracy;
		document[g_eString_FormName].position_heading.value = ePosition.coords.heading;
		document[g_eString_FormName].position_speed.value = ePosition.coords.speed;
	}
	function callback_getCurrentPosition__Failure( eError )
	{
		alert( eError.code );
	}
}


