var div = document.getElementById("demo");
window.onload = getLocation;
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    div.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  $.get(
    "https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/reverseGeocode?location=" +
      position.coords.longitude +
      "%2C" +
      position.coords.latitude +
      "&langCode=fr&outSR=&forStorage=false&f=pjson",
    function(response) {
      var obj = JSON.parse(response);
      const p = document.getElementById("location");
      p.textContent = obj.address.City;
      const r = document.getElementById("region");
      r.textContent = obj.address.ShortLabel;
    }
  );
  $.get(
    "https://api.openweathermap.org/data/2.5/weather?lat=" +
      position.coords.latitude +
      "&lon=" +
      position.coords.longitude +
      "&appid=bf030c0952521d748acff736ac6d2f5c",
    function(response) {
      const kelvin = response.main.temp;
      const celsj = kelvin - 273.15;
      const newcelsj = Math.round(celsj);
      const temp = document.getElementById("temperature");
      temp.innerHTML = newcelsj + "&#176 C ";
      const press = document.getElementById("pressure");
      press.textContent = response.main.pressure + " hPa";
      const img = document.getElementById("symbol");
      img.src =
        "https://openweathermap.org/img/wn/" +
        response.weather[0].icon +
        "@2x.png";
      const desc = document.getElementById("desc");
      desc.textContent = response.weather[0].description;
    }
  );
}
