// 日本語UTF-8, LF


// global
var g_eString_FormName = "test";
var g_eString_URL_Default = "http://tcth2014-den-test.azurewebsites.net/select.php";


// -------------------------------------------------------------------
// event ( onclick )

function local_OnLoad()
{
	if ( navigator.geolocation )
	{
		navigator.geolocation.getCurrentPosition( callback_getCurrentPosition__Success, callback_getCurrentPosition__Failure );
	}
	else
	{
		alert( "navigator.geolocation : false" );
	}

	function callback_getCurrentPosition__Success( ePosition )
	{
		eSender = 
		{
			positions : ePosition,
		};

		local_SendRequest_JSON( eSender, callback_SendRequest_JSON__Success );
	}
	function callback_getCurrentPosition__Failure( eError )
	{
		alert( eError.code );
	}
	function callback_SendRequest_JSON__Success( eXMLHttpRequest )
	{
		try
		{
			eReceiver = JSON.parse( eXMLHttpRequest.responseText );

			var eElement;

			eElement = document.getElementById( "id__select__station" );
			if ( eElement )
			{
				if ( !( eReceiver.stations == undefined ) )
				{
					for ( var i = 0; i < eReceiver.stations.length; i++ )
					{
						eElement.options[i] = new Option( eReceiver.stations[i].name, eReceiver.stations[i].code );
					}
				}
			}
		}
		catch ( eError )
		{
			alert( eError.code );
			alert( eXMLHttpRequest.responseText );
		}
	}
}


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


// -------------------------------------------------------------------
// send request

function local_SendRequest_JSON( eSender, fpCallBack__Succeed, fpCallBack__Failure, eString_URL )
{
	if ( eSender == undefined )
	{
		eSender = 
		{
			mode : "get",
			category : "test",
		};
	}

	eString_Sender = "json=";
	eString_Sender += encodeURIComponent( JSON.stringify( eSender ) );
	eString_Sender += "&json_send=true";

	local_SendHttpRequest_Asynchronous( eString_Sender, fpCallBack__Succeed, fpCallBack__Failure, eString_URL );
}


function local_SendHttpRequest_Asynchronous( eString_Sender, fpCallBack__Succeed, fpCallBack__Failure, eString_URL )
{
	var eXMLHttpRequest;

	if ( fpCallBack__Succeed == undefined )
	{
		fpCallBack__Succeed = callback_SendHttpRequest_Asynchronous__Succeed;
	}
	if ( fpCallBack__Failure == undefined )
	{
		fpCallBack__Failure = callback_SendHttpRequest_Asynchronous__Failure;
	}
	if ( eString_URL == undefined )
	{
		eString_URL = g_eString_URL_Default;
	}

	eXMLHttpRequest = new XMLHttpRequest();
	eXMLHttpRequest.abort();
	eXMLHttpRequest.open( "POST", eString_URL, true );
	eXMLHttpRequest.onreadystatechange = callback_SendHttpRequest_Asynchronous;
	eXMLHttpRequest.setRequestHeader( "Content-Type", "application/x-www-form-urlencoded" );
	eXMLHttpRequest.send( eString_Sender );


	function callback_SendHttpRequest_Asynchronous()
	{
		if ( eXMLHttpRequest.readyState == 4 )
		{
			if ( eXMLHttpRequest.status == 200 || eXMLHttpRequest.status == 201)
			{
				// リクエストの処理
				fpCallBack__Succeed( eXMLHttpRequest );
			}
			else
			{
				// エラー処理
				fpCallBack__Failure( eXMLHttpRequest );
			}
		}
	}


	function callback_SendHttpRequest_Asynchronous__Succeed( eXMLHttpRequest )
	{
		var eElement;

		eElement = document.getElementById( "id__debug" );
		if ( eElement )
		{
			eElement.innerHTML = eXMLHttpRequest.responseText;
		}
	}


	function callback_SendHttpRequest_Asynchronous__Failure( eXMLHttpRequest )
	{
		var eElement;

		eElement = document.getElementById( "id__debug" );
		if ( eElement )
		{
			eElement.innerHTML = "error.<br />\n";
			eElement.innerHTML += eString_Sender;
		}
	}
}


