window.getLocation = function()  {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert('Please use a browser which supports geolocation.');
    }
}

function showPosition(position) {
    console.log(position)
    document.getElementById('lat').value = position.coords.latitude
    document.getElementById('long').value = position.coords.longitude
    document.getElementById('loc-form').submit();
}

var intervalId = setInterval(getLocation, 5000);
clearInterval(intervalId)