/**
 * Created by Seweryn on 2015-12-16.
 */
jQuery(function($) {
    var script = document.createElement('script');
    script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&callback=initialize";
    document.body.appendChild(script);
});
function initialize() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    map.setTilt(45);
    var markers = [
        ['<strong>Siedziba główna</strong><br/>ul. Pogonowskiego 40 lok 1<br/>01-577 Warszawa', 52.2677868,20.9836674],
        ['<strong>Filia</strong><br/>ul. Gersona 9<br/>03-307 Warszawa', 52.2780305,21.0115111],
        ['<strong>Rejon Żyrardowski i Skierniewicki</strong><br/>ul. Graniczna 6<br/>96-332 Grabina Radziwiłłowska', 52.001266,20.2855512]
    ];
    var infoWindowContent = [
        ['<div class="info_content">' +
        '<h3>Siedziba główna</h3>' +
        '<p>ul. Pogonowskiego 40 lok 1<br/>01-577 Warszawa<br/><br/>tel. 22 839-00-81<br/>tel./fax 22 633-71-74<br/>08:00 - 16:00</p>' +
        '</div>'],
        ['<div class="info_content">' +
        '<h3>Filia</h3>' +
        '<p>ul. Gersona 9<br/>03-307 Warszawa<br/><br/>tel. 22 675 04 56<br/>fax 22 676 91 99<br/>06:00 - 16:00</p>' +
        '</div>'],
        ['<div class="info_content">' +
        '<h3>Rejon Żyrardowski i Skierniewicki</h3>' +
        '<p>ul. Graniczna 6<br/>96-332 Grabina Radziwiłłowska<br/><br/>tel. 507 060 837</p>' +
        '</div>']
    ];
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));
        map.fitBounds(bounds);
    }
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(9);
        google.maps.event.removeListener(boundsListener);
    });
}