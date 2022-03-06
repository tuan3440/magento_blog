define(['jquery', 'mage/translate', 'googleMapPlaceLibrary'], function ($, $t) {
    "use strict";
    $.widget(
            'autofill.click_and_collect',
            {
                _create: function () {
                    var placeSearch, autocomplete;
                    var componentForm = {
                        locality: 'city',
                        administrative_area_level_1: 'state',
                        country: 'country',
                        postal_code: 'postal_code'
                    };
                    initAutocomplete();
                    function fillInAddress()
                    {
                        document.getElementById('lat').value = '';
                        document.getElementById('lng').value = '';
                        var place = autocomplete.getPlace();
                        if (place.hasOwnProperty('geometry')) {
                            var lat = place.geometry.location.lat(), lng = place.geometry.location.lng();
                        } else {
                            var lat = 0, lng = 0;
                        }
                        document.getElementById('lat').value = lat;
                        document.getElementById('lng').value = lng;
                    }
                    function geolocate() {
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(function (position) {
                                var geolocation = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude
                                };
                                var circle = new google.maps.Circle({
                                    center: geolocation,
                                    radius: position.coords.accuracy
                                });
                                autocomplete.setBounds(circle.getBounds());
                            });
                        }
                    }
                    function initAutocomplete() {
                        autocomplete = new google.maps.places.Autocomplete(
                                (document.getElementById('autocomplete')),
                                {types: ['(regions)'], componentRestrictions: {country: 'AU'}});
                        autocomplete.addListener('place_changed', fillInAddress);
                    }
                }
            }
    );
    return $.autofill.click_and_collect;
});