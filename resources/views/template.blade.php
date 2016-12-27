<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">

    <!-- Title -->
    <title>Shop Payments</title>

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/jscrollpane/jquery.jscrollpane.css">

    <!-- custom CSS -->
    <link rel="stylesheet" href="/assets/css/theme.css">

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="fixed-sidebar fixed-header skin-default content-appear">
<div class="wrapper">

    <div class="site-sidebar">
        <div class="custom-scroll custom-scroll-light">
            <ul class="sidebar-menu">
                <li class="menu-title">Menu</li>
                <li class="with-sub">
                    <a href="#" class="waves-effect  waves-light">
                        <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                        <span class="tag tag-purple">3</span>
                        <span class="s-icon"><i class="ti-anchor"></i></span>
                        <span class="s-text">Filters</span>
                    </a>
                    <ul>
                        <li><a href="#">Hotels</a></li>
                        <li><a href="#">Food</a></li>
                        <li><a href="#">Textiles</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <!-- Header -->
    <div class="site-header">
        <nav class="navbar navbar-light">
            <div class="navbar-left">
                <a class="navbar-brand" href="index.html">
                    <div class="logo"></div>
                </a>
                <div class="toggle-button dark sidebar-toggle-first float-xs-left hidden-md-up">
                    <span class="hamburger"></span>
                </div>
            </div>

        </nav>
    </div>

    <div class="site-content">
        <!-- Content -->
        <div class="content-area">
            <div class="container-fluid margin-0 padding-0">
                <div class="custom-content">
                    <div id="maps-container" style="height: 500px;"></div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row text-xs-center">
                    <div class="col-sm-4 text-sm-left mb-0-5 mb-sm-0">
                        2016 ©
                    </div>
                </div>
            </div>
        </footer>
    </div>

</div>

<!-- Plugin JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript" src="/assets/js/detectmobilebrowser/detectmobilebrowser.js"></script>
<script type="text/javascript" src="/assets/js/jscrollpane/jquery.mousewheel.js"></script>
<script type="text/javascript" src="/assets/js/jscrollpane/mwheelIntent.js"></script>
<script type="text/javascript" src="/assets/js/jscrollpane/jquery.jscrollpane.min.js"></script>
<script src="https://maps.google.com/maps/api/js?key=AIzaSyCU3mY5Kq_JlX1KbEiWkoXBd5cXSypf13U"></script>
<script type="text/javascript" src="/assets/js/gmaps/gmaps.min.js"></script>


<!-- Custom JS -->
<script type="text/javascript" src="/assets/js/app.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var userLat, userlng;
        var currentcenterLat, currentcenterLng, zoomLevel, windowHeight, windowWidth;
        var map = new GMaps({
            el: '#maps-container',
            lat: 0,
            lng: 0,
            zoomControl : true,
            zoomControlOpt: {
                style : 'SMALL',
                position: 'TOP_LEFT'
            },
            panControl : false,
            streetViewControl : false,
            mapTypeControl: false,
            overviewMapControl: false,
            dragend: function(e) {
                currentcenterLat = map.getCenter().lat();
                currentcenterLng = map.getCenter().lng();
                windowHeight = $(window).height();
                windowWidth = $(window).width();
                zoomLevel = map.getZoom();
                sendRequest();
            },
            dblclick: function(e){
                currentcenterLat = map.getCenter().lat();
                currentcenterLng = map.getCenter().lng();
                windowHeight = $(window).height();
                windowWidth = $(window).width();
                zoomLevel = map.getZoom();
                sendRequest();
                // console.log(map.zoom);
            },
            zoom_changed: function(e) {
                currentcenterLat = map.getCenter().lat();
                currentcenterLng = map.getCenter().lng();
                windowHeight = $(window).height();
                windowWidth = $(window).width();
                zoomLevel = map.getZoom();
            }

        });
// Define user location
        GMaps.geolocate({
            success: function(position) {
                map.setCenter(position.coords.latitude, position.coords.longitude);
                userLat = position.coords.latitude;
                userLng = position.coords.longitude;
                // Creating marker of user location
                map.addControl({
                    position: 'top_right',
                    content: 'Go To My Location',
                    style: {
                        margin: '5px',
                        padding: '1px 6px',
                        border: 'solid 1px #717B87',
                        background: '#fff'
                    },
                    events: {
                        click: function(){
                            map.setCenter(userLat, userLng);
                        }
                    }
                });
                map.setContextMenu({
                    control: 'map',
                    options: [{
                        title: 'Set My Location here',
                        name: 'add_marker',
                        action: function(e) {
                            userLat = e.latLng.lat();
                            userLng = e.latLng.lng();
                            this.setCenter(userLat, userLng);
                            this.removeMarkers();
                            this.addMarker({
                                lat: userLat,
                                lng: userLng,
                                title: 'New marker',
                                infoWindow: {
                                    content: '<p>You are here!</p>'
                                }
                            });
                            sendRequest();
                        }
                    }]
                });

                map.addMarker({
                    lat: userLat,
                    lng: userLng,
                    title: 'You are here',
                    infoWindow: {
                        content:"<p>You are here!</p>"
                    }
                });
                map.on('marker_added', function (marker) {
                    var index = map.markers.indexOf(marker);

                    if (index == map.markers.length - 1) {
                        //map.fitZoom();
                    }

                });
                sendRequest();
            },
            error: function(error) {
                alert('Geolocation failed: '+error.message);
            },
            not_supported: function() {
                alert("Your browser does not support geolocation");
            }
        });

        function sendRequest() {
            $.ajax({
                url: 'https://raw.githubusercontent.com/jithinjose2/EPaymentShops/master/public/samples/get-shops.json',
                data: {
                    wH: windowHeight,
                    wW: windowWidth,
                    wZ: zoomLevel,
                    uLat: currentcenterLat,
                    uLng: currentcenterLng
                },
                error: function() {
                    alert('Service is not found. Please reload page.');
                },
                dataType: 'json',
                success: function(data) {
                    loadResults(data);
                },
                type: 'GET'
            });
        }
        function loadResults (data) {
            var items, markers_data = [];
            if (data.length > 0) {
                items = data;

                for (var i = 0; i < items.length; i++) {
                    var item = items[i];

                    if (item.lat != undefined && item.lng != undefined) {
                        var icon = 'https://foursquare.com/img/categories/food/default.png';
                        var name = item.name;
                        var addr = item.address;
                        var phone = item.contact_no;
                        var start_time = item.start_time;
                        var close_time = item.end_time;
                        markers_data.push({
                            lat : item.lat,
                            lng : item.lng,
                            title : item.name,
                            infoWindow: {
                                content: '<h6>'+name+'</h6><div>'+addr+'<br/> Ph. No - '+phone+'<br/>'+start_time+' - '+close_time+'<br/><a target="_blank" href="http://maps.google.com/maps?saddr='+userLat+','+userLng+'&daddr='+item.lat+','+item.lng+'">Get Directions</a></div>',
                                maxWidth: 200
                            },
                            icon: {
                                url: icon,
                                labelAnchor: new google.maps.Point(15, 65),
                                labelClass: "labels", // the CSS class for the label
                                labelInBackground: false,
                                icon: pinSymbol('red'),
                                label:'test'
                            }
                        });
                    }
                }
            }

            map.addMarkers(markers_data);
            map.fitZoom();
        }

        function pinSymbol(color) {
            return {
                path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z',
                fillColor: color,
                fillOpacity: 1,
                strokeColor: '#000',
                strokeWeight: 2,
                scale: 2
            };
        }


    });

</script>

</body>
</html>