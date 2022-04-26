
function alertThenReload(msg) {
	alert(msg);
	window.location.reload(false);
}

function acceptEventAjax(EID)
{
	ajax = $.ajax({
			url: 'include/pendingEvents-include.php',
			type: 'POST',
			data: {method: "acceptEvent", EID: EID},
			dataType: 'json',
			success: function(data){
				if (data.status === 'ok') {
					alertThenReload("Event accepted.");
				}
				else {
					var errorMessage = data.statusText;
					alertThenReload('Error - ' + errorMessage);
				}
			}
		});
	return;
}

function denyEventAjax(EID)
{
	ajax = $.ajax({
			url: 'include/pendingEvents-include.php',
			type: 'POST',
			data: {method: "denyEvent", EID: EID},
			dataType: 'json',
			success: function(data){
				if (data.status === 'ok') {
					alertThenReload("Event denied.");
				}
				else {
					var errorMessage = data.statusText;
					alertThenReload('Error - ' + errorMessage);
				}
			}
		});
	return;
}

function acceptEvent(eventID)
{
	EID = JSON.stringify(eventID);
	acceptEventAjax(EID);
}

function denyEvent(eventID)
{
	EID = JSON.stringify(eventID);
	denyEventAjax(EID);
}