var CriticalMass = CriticalMass || {};

CriticalMass.loadModule = function(name, context, options, callback) {
    var modulePathPrefix = 'js/modules/';
    var type = '';

    if (name.search('Page') > 0) {
        type = 'page/';
    }

    if (name.search('Entity') > 0) {
        type = 'entity/';
    }

    if (name.search('Map') > 0) {
        type = 'map/';
    }

    if (name.search('Marker') > 0) {
        type = 'map/marker/';
    }

    var moduleName = modulePathPrefix + type + name;

    require([moduleName], function(Module) {
        var module = new Module(context, options);

        if (callback) {
            callback(module);
        }
    });
};

require.config({
    baseUrl: '/bundles/calderacriticalmasssite/',
    paths:
    {
        "CityEntity": "/bundles/calderacriticalmasssite/js/modules/entity/CityEntity",
        "WritePost": "/bundles/calderacriticalmasssite/js/modules/WritePost",
        "RideEntity": "/bundles/calderacriticalmasssite/js/modules/entity/RideEntity",
        "NoLocationRideEntity": "/bundles/calderacriticalmasssite/js/modules/entity/NoLocationRideEntity",
        "TrackEntity": "/bundles/calderacriticalmasssite/js/modules/entity/TrackEntity",
        "TimelapseTrackEntity": "/bundles/calderacriticalmasssite/js/modules/entity/TimelapseTrackEntity",
        "SubrideEntity": "/bundles/calderacriticalmasssite/js/modules/entity/SubrideEntity",
        "PositionEntity": "/bundles/calderacriticalmasssite/js/modules/entity/PositionEntity",
        "BaseEntity": "/bundles/calderacriticalmasssite/js/modules/entity/BaseEntity",
        "MarkerEntity": "/bundles/calderacriticalmasssite/js/modules/entity/MarkerEntity",
        "PhotoEntity": "/bundles/calderacriticalmasssite/js/modules/entity/PhotoEntity",
        "Container": "/bundles/calderacriticalmasssite/js/modules/entity/Container",
        "ClusterContainer": "/bundles/calderacriticalmasssite/js/modules/entity/ClusterContainer",
        "EditCityPage": "/bundles/calderacriticalmasssite/js/modules/page/EditCityPage",
        "EditRidePage": "/bundles/calderacriticalmasssite/js/modules/page/EditRidePage",
        "LivePage": "/bundles/calderacriticalmasssite/js/modules/page/LivePage",
        "RegionPage": "/bundles/calderacriticalmasssite/js/modules/page/RegionPage",
        "StravaImportPage": "/bundles/calderacriticalmasssite/js/modules/page/StravaImportPage",
        "FacebookImportRidePage": "/bundles/calderacriticalmasssite/js/modules/page/FacebookImportRidePage",
        "RidePage": "/bundles/calderacriticalmasssite/js/modules/page/RidePage",
        "PhotoViewModal": "/bundles/calderacriticalmasssite/js/modules/PhotoViewModal",
        "Notification": "/bundles/calderacriticalmasssite/js/modules/Notification",
        "Timelapse": "/bundles/calderacriticalmasssite/js/modules/map/Timelapse",
        "TrackRangePage": "/bundles/calderacriticalmasssite/js/modules/page/TrackRangePage",
        "TrackUploadPage": "/bundles/calderacriticalmasssite/js/modules/page/TrackUploadPage",
        "TrackViewPage": "/bundles/calderacriticalmasssite/js/modules/page/TrackViewPage",
        "ViewPhotoPage": "/bundles/calderacriticalmasssite/js/modules/page/ViewPhotoPage",
        "UploadPhotoPage": "/bundles/calderacriticalmasssite/js/modules/page/UploadPhotoPage",
        "CityStatisticPage": "/bundles/calderacriticalmasssite/js/modules/page/CityStatisticPage",
        "StatisticPage": "/bundles/calderacriticalmasssite/js/modules/page/StatisticPage",
        "Map": "/bundles/calderacriticalmasssite/js/modules/map/Map",
        "AutoMap": "/bundles/calderacriticalmasssite/js/modules/map/AutoMap",
        "Geocoding": "/bundles/calderacriticalmasssite/js/modules/Geocoding",
        "Modal": "/bundles/calderacriticalmasssite/js/modules/Modal",
        "MapLayerControl": "/bundles/calderacriticalmasssite/js/modules/map/MapLayerControl",
        "MapLocationControl": "/bundles/calderacriticalmasssite/js/modules/map/MapLocationControl",
        "MapPositions": "/bundles/calderacriticalmasssite/js/modules/map/MapPositions",
        "Marker": "/bundles/calderacriticalmasssite/js/modules/map/marker/Marker",
        "CityMarker": "/bundles/calderacriticalmasssite/js/modules/map/marker/CityMarker",
        "LocationMarker": "/bundles/calderacriticalmasssite/js/modules/map/marker/LocationMarker",
        "PhotoMarker": "/bundles/calderacriticalmasssite/js/modules/map/marker/PhotoMarker",
        "PositionMarker": "/bundles/calderacriticalmasssite/js/modules/map/marker/PositionMarker",
        "SubrideMarker": "/bundles/calderacriticalmasssite/js/modules/map/marker/SubrideMarker",
        "SnapablePhotoMarker": "/bundles/calderacriticalmasssite/js/modules/map/marker/SnapablePhotoMarker",
        "leaflet": "/bundles/calderacriticalmasssite/js/external/leaflet/leaflet",
        "leaflet-activearea": "/bundles/calderacriticalmasssite/js/external/leaflet/L.activearea",
        "leaflet-locate": "/bundles/calderacriticalmasssite/js/external/leaflet/L.Control.Locate",
        "leaflet-sidebar": "/bundles/calderacriticalmasssite/js/external/leaflet/L.Control.Sidebar",
        "leaflet-geometry": "/bundles/calderacriticalmasssite/js/external/leaflet/leaflet.geometryutil",
        "leaflet-groupedlayer": "/bundles/calderacriticalmasssite/js/external/leaflet/leaflet.groupedlayercontrol",
        "leaflet-snap": "/bundles/calderacriticalmasssite/js/external/leaflet/leaflet.snap",
        "leaflet-hash": "/bundles/calderacriticalmasssite/js/external/leaflet/leaflet-hash",
        "leaflet-polyline": "/bundles/calderacriticalmasssite/js/external/leaflet/leaflet-polyline",
        "leaflet-extramarkers": "/bundles/calderacriticalmasssite/js/external/leaflet/ExtraMarkers",
        "leaflet-markercluster": "/bundles/calderacriticalmasssite/js/external/leaflet/leaflet-markercluster",
        "bootstrap-slider": "/bundles/calderacriticalmasssite/js/external/bootstrap/bootstrap-slider",
        "dropzone": "/bundles/calderacriticalmasssite/js/external/dropzone/dropzone.min",
        "typeahead": "/bundles/calderacriticalmasssite/js/external/typeahead/typeahead",
        "bloodhound": "/bundles/calderacriticalmasssite/js/external/typeahead/bloodhound",
        "jquery": "/bundles/calderacriticalmasssite/js/external/jquery/jquery-2.1.4.min",
        "dateformat": "/bundles/calderacriticalmasssite/js/external/dateformat/dateformat",
        "socketio": "https://cdn.socket.io/socket.io-1.4.5",
        "chartjs": "/bundles/calderacriticalmasssite/js/external/chartjs/chartjs"

    },
    shim: {
        'leaflet-locate': {
            deps: ['leaflet'],
            exports: 'L.Control.Locate'
        },
        'leaflet-groupedlayer': {
            deps: ['leaflet'],
            exports: 'L.Control.GroupedLayers'
        },
        'leaflet-snap': {
            deps: ['leaflet'],
            exports: 'L.Handler.MarkerSnap'
        },
        'leaflet-hash': {
            deps: ['leaflet'],
            exports: 'L.Hash'
        },
        'leaflet-polyline': {
            deps: ['leaflet'],
            exports: 'L.PolylineUtil'
        },
        'leaflet-playback': {
            deps: ['leaflet'],
            exports: 'L.Playback'
        },
        'leaflet-extramarkers': {
            deps: ['leaflet'],
            exports: 'L.ExtraMarkers'
        },
        'leaflet-markercluster': {
            deps: ['leaflet'],
            exports: 'L.MarkerClusterGroup'
        },
        typeahead:{
            deps: ['jquery'],
            init: function ($) {
                return require.s.contexts._.registry['typeahead.js'].factory( $ );
            }
        },
        bloodhound: {
            deps: [],
            exports: 'Bloodhound'
        }
    }
});
