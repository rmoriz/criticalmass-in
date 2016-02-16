define([], function() {

    Geocoding = function(context, options) {
    };

    Geocoding.prototype._country = null;

    Geocoding.prototype.setCountry = function(country) {
        this._country = country;
    };

    Geocoding.prototype._query = function(query, successCallback) {
        var baseUrl = 'https://nominatim.openstreetmap.org/search?';

        var defaultOptions = {
            format: 'json',
            country: this._country
        };

        var jsonQuery = $.extend(query, defaultOptions);
        var params = jQuery.param(jsonQuery);

        var url = baseUrl + params;

        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: url,
            cache: false,
            success: successCallback
        });
    };

    Geocoding.prototype.searchCity = function(cityName, returnCallback) {
        var query = {
            city: cityName
        };

        var successCallback = function(data) {
            var importanceScore = 0.0;
            var bestData = null;

            for (var index in data) {
                if (importanceScore < data[index].importance || !bestData) {
                    importanceScore = data[index].importance;
                    bestData = data[index];
                }
            }

            returnCallback(bestData);
        };

        this._query(query, successCallback);
    };

    return Geocoding;
});