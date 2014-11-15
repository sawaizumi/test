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

	function callback_getCurrentPosition( ePosition )
	{
		alert( ePosition.coords.latitude );
		document[g_eString_FormName].position_l.value = "";
	}
	function callback_getCurrentPosition__Failure( eError )
	{
		alert( eError.code );
	}
}


