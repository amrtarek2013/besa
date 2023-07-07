<!-- <link rel="stylesheet" href="/miniature-earth/examples/assets/example.css"> -->
<link rel="stylesheet" href="/miniature-earth/demo/world-news/style.css">

<link rel="stylesheet" href="/miniature-earth/demo/flight-time/style.css">
<link rel="stylesheet" href="/miniature-earth/demo/photo-locations/style.css">
<!-- <script src="/miniature-earth/miniature.earth.js"></script> -->
<script src="/miniature-earth/miniature.earth.js"></script>
<script src="/miniature-earth/demo/world-news/countries.js"></script>

<script src="/miniature-earth/demo/flight-time/airports-and-plane-mesh.js"></script>

<script type="text/javascript" src="/miniature-earth/modules/miniature.earth.textimage.js"></script>


<style>
    @font-face {
        font-family: 'Kalam';
        src: url('assets/Kalam-Bold.ttf') format('truetype');
        font-weight: bold;
    }

    .photo-appear {
        cursor: pointer;
        pointer-events: all;
    }

    #photo {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 10px solid;
        border-color: blueviolet;
    }
</style>

<script>
    var myearth;
    var localNewsMarker;
    var news = [];

    var markers = [];
    airports = <?= json_encode($countriesEarth) ?>;
    var custom_regions_image;

    var selected_countries = [];
    /* load miniature.earth.js after the page is loaded. */

    // window.addEventListener('load', function() {
    //     var script = document.createElement("script");
    //     script.src = "../miniature.earth.js";
    //     document.body.appendChild(script);
    // });

    window.addEventListener("earthjsload", function() {

        // parse plane mesh from string in airports-and-plane-mesh.js	
        Earth.addMesh(airplaneMesh);


        myearth = new Earth('myearth', {

            mapHitTest: true,

            autoRotate: false,
            zoom: 1.15,
            zoomMin: 1,
            zoomMax: 1.8,
            quality: (window.innerWidth <= 1024) ? 4 : 5,

            zoomable: true,

            location: {
                lat: 20,
                lng: 10
            },
            mapBorderColor: '#66d8ff',
            mapBorderWidth: 0.4

        });


        var fading_images = [];
        myearth.addEventListener("ready", function() {



            // add photo overlay

            // photo_overlay = this.addOverlay({
            //     // content: '<div id="photo"><div id="close-photo" onclick="closePhoto(); event.stopPropagation();"></div></div>',
            //     content: '<div id="photo"></div>',
            //     visible: false,
            //     containerScale: 1,
            //     depthScale: 0.5
            // });

            // var last_id = '';

            // document.getElementById('myearth').addEventListener('mousemove', function(event) {

            //     var location = myearth.getLocation({
            //         x: event.pageX,
            //         y: event.pageY
            //     });
            //     var svg_id = myearth.hitTest(location);

            //     if (!svg_id || svg_id == 'SEA') {
            //         myearth.mapStyles = '';
            //     } else {
            //         myearth.mapStyles = '#' + svg_id + ' { fill: #44cc44; }';
            //     }

            //     if (svg_id != last_id) {
            //         myearth.redrawMap();
            //     }

            //     last_id = svg_id;

            // });

            // document.getElementById('myearth').addEventListener('mouseout', function() {

            //     if (!last_id) return;

            //     myearth.mapStyles = '';
            //     myearth.redrawMap();

            //     last_id = '';

            // });



            // add airport pins from airports array in airports-and-plane-mesh.js
            for (var i = 0; i < airports.length; i++) {


                // hotspot
                marker = this.addSprite({

                    location: {
                        lat: airports[i]['latitude'],
                        lng: airports[i]['longitude']
                    },
                    // color: 'red',
                    // hotspot: true,
                    // hotspotRadius: 0.75

                    hotspot: true,
                    hotspotRadius: 1,
                    image: "/img/flags/" + airports[i]['flag'],
                    // color: 'red',

                    airportCode: airports[i]['country_code'],
                    airportName: airports[i]['country_name'],

                    // custom properties
                    // title: markers[i].title,
                    link: '/country-details/' + airports[i]['permalink'],

                    // custom property
                    photo_info: "/img/flags/" + airports[i]['flag']
                });
                marker.addEventListener('click', function() {

                    // alert('sssssssssss');
                    window.open(this.link);
                });

                // this.addOverlay({
                //     content: 'hotspot: true',

                //     location: {
                //         lat: airports[i]['latitude'],
                //         lng: airports[i]['longitude']
                //     },
                //     className: 'docs-tip',
                //     depthScale: 0.5,
                //     airportCode: airports[i]['country_code'],
                //     airportName: airports[i]['country_name'],

                //     // custom properties
                //     // title: markers[i].title,
                //     link: '/country-details/' + airports[i]['permalink'],

                //     // custom property
                //     photo_info: "/img/flags/" + airports[i]['flag']
                // });
                // var marker = this.addMarker({

                //     //mesh: ["Flag", "Needle"],
                //     mesh: "Marker",
                //     color: '#00a8ff',
                //     // color2: '#9f9f9f',
                //     offset: -0.2,
                //     location: {
                //         lat: airports[i]['latitude'],
                //         lng: airports[i]['longitude']
                //     },
                //     scale: 0.01,
                //     visible: false,
                //     hotspot: true,
                //     hotspotRadius: 0.4,
                //     hotspotHeight: 1.5,

                //     // custom properties
                //     index: i,
                //     airportCode: airports[i]['country_code'],
                //     airportName: airports[i]['country_name'],

                //     // custom properties
                //     // title: markers[i].title,
                //     link: '/country-details/' + airports[i]['permalink'],

                //     // custom property
                //     photo_info: "/img/flags/" + airports[i]['flag']

                // });

                // console.log("besa.local/img/flags/" + airports[i]['flag']);

                // marker.addEventListener('click', openPhoto);

                // animate marker
                setTimeout((function() {
                    this.visible = true;
                    this.animate('scale', 0.9, {
                        duration: 140
                    });
                    this.animate('offset', 0, {
                        duration: 1100,
                        easing: 'bounce'
                    });
                }).bind(marker), 280 * i);
                // marker.addEventListener('click', function() {

                //     window.open(this.link);
                // });


                // pin events

                marker.addEventListener('mouseover', function() {

                    document.getElementById('tip-layer').style.opacity = 1;
                    document.getElementById('tip-big').innerHTML = this.airportCode;
                    document.getElementById('tip-small').innerHTML = this.airportName.split(',').join('<br>');

                    this.color = 'red';

                });

                marker.addEventListener('mouseout', function() {

                    // if (this != startMarker && this != endMarker) {
                    this.color = '#00a8ff';
                    // }
                    document.getElementById('tip-layer').style.opacity = 0;

                });
                markers.push(marker);

            }

            restorePins();



            // North America

            var text_image = Earth.TextImage.draw('North\nAmerica', {
                fontFamily: 'Kalam, sans-serif',
                fontWeight: 'bold'
            });

            var image = myearth.addImage({
                location: {
                    lat: 39,
                    lng: -98
                },
                image: text_image.image,
                scale: text_image.scale * 0.8,
                imageResolution: text_image.resolution,
                color: '#333'
            });

            fading_images.push(image);


            // South America

            var text_image = Earth.TextImage.draw('South\nAmerica', {
                fontFamily: 'Kalam, sans-serif',
                fontWeight: 'bold'
            });

            var image = myearth.addImage({
                location: {
                    lat: -15,
                    lng: -57
                },
                image: text_image.image,
                scale: text_image.scale * 0.8,
                imageResolution: text_image.resolution,
                color: '#333'
            });

            fading_images.push(image);



            // Africa

            var text_image = Earth.TextImage.draw('Africa', {
                fontFamily: 'Kalam, sans-serif',
                fontWeight: 'bold'
            });

            var image = myearth.addImage({
                location: {
                    lat: 5,
                    lng: 26
                },
                image: text_image.image,
                scale: text_image.scale * 0.8,
                imageResolution: text_image.resolution,
                color: '#333'
            });

            fading_images.push(image);



            // Europe

            var text_image = Earth.TextImage.draw('Europe', {
                fontFamily: 'Kalam, sans-serif',
                fontWeight: 'bold'
            });

            var image = myearth.addImage({
                location: {
                    lat: 49,
                    lng: 11
                },
                image: text_image.image,
                scale: text_image.scale * 0.8,
                imageResolution: text_image.resolution,
                color: '#333'
            });

            fading_images.push(image);



            // Asia

            var text_image = Earth.TextImage.draw('Asia', {
                fontFamily: 'Kalam, sans-serif',
                fontWeight: 'bold'
            });

            var image = myearth.addImage({
                location: {
                    lat: 41,
                    lng: 87
                },
                image: text_image.image,
                scale: text_image.scale * 0.8,
                imageResolution: text_image.resolution,
                color: '#333'
            });

            fading_images.push(image);



            // Australia

            var text_image = Earth.TextImage.draw('Australia', {
                fontFamily: 'Kalam, sans-serif',
                fontWeight: 'bold'
            });

            var image = myearth.addImage({
                location: {
                    lat: -25,
                    lng: 134
                },
                image: text_image.image,
                scale: text_image.scale * 0.8,
                imageResolution: text_image.resolution,
                color: '#333'
            });

            fading_images.push(image);




            // Atlantic Ocean

            var text_image = Earth.TextImage.draw('Atlantic\nOcean', {
                fontFamily: 'Kalam, sans-serif',
                fontWeight: 'bold'
            });

            var image = myearth.addImage({
                location: {
                    lat: 23,
                    lng: -43
                },
                image: text_image.image,
                scale: text_image.scale * 0.6,
                imageResolution: text_image.resolution,
                color: '#c7e6fb'
            });

            fading_images.push(image);



            // Pacific Ocean

            var text_image = Earth.TextImage.draw('Pacific Ocean', {
                fontFamily: 'Kalam, sans-serif',
                fontWeight: 'bold'
            });

            var image = myearth.addImage({
                location: {
                    lat: 8,
                    lng: -168
                },
                image: text_image.image,
                scale: text_image.scale * 0.6,
                imageResolution: text_image.resolution,
                color: '#c7e6fb'
            });

            fading_images.push(image);



            // Indian Ocean

            var text_image = Earth.TextImage.draw('Indian Ocean', {
                fontFamily: 'Kalam, sans-serif',
                fontWeight: 'bold'
            });

            var image = myearth.addImage({
                location: {
                    lat: -13,
                    lng: 80
                },
                image: text_image.image,
                scale: text_image.scale * 0.6,
                imageResolution: text_image.resolution,
                color: '#c7e6fb'
            });

            fading_images.push(image);

        });




        // close photo overlay when navigating away

        myearth.addEventListener("change", function() {

            if (!current_marker || auto_rotate) return;

            if (Earth.getAngle(myearth.location, current_marker.location) > 45) {
                closePhoto();
            }

        });

    });


    // function highlightBreakingNews(event) {

    //     var overlay = event.target.closest('.earth-overlay').overlay;
    //     var newsId = overlay.newsId;

    //     document.getElementById('breaking-news-' + newsId).classList.add('news-highlight');
    //     setTimeout(function() {
    //         document.getElementById('breaking-news-' + newsId).classList.remove('news-highlight');
    //     }, 500);

    //     myearth.goTo(overlay.location, {
    //         duration: 250,
    //         relativeDuration: 70
    //     });

    //     event.stopPropagation();
    // }


    var pinIndex = 0;
    var pinTime = 0;
    var pinsPerSec = 1000 / 18;

    function shrinkPins() {

        pinIndex = 0;

        var shrinkOnePin = function() {

            markers[pinIndex].animate('scale', 0.01, {
                complete: function() {
                    this.visible = false;
                }
            });

            if (++pinIndex >= markers.length) {
                myearth.removeEventListener("update", shrinkOnePin);
            }

        };

        myearth.addEventListener("update", shrinkOnePin);

    }


    var current_marker, auto_rotate;


    function openPhoto() {

        // close current photo
        if (current_marker) {

            closePhoto();
            window.setTimeout(openPhoto.bind(this), 120);

            return;
        }

        // rotate earth if needed
        if (myearth.goTo(this.location, {
                relativeDuration: 100,
                approachAngle: 12,
                end: function() {
                    auto_rotate = false;
                }
            })) {
            auto_rotate = true;
        }




        // document.getElementById('photo').style.backgroundImage = "url(" + this.photo_info + ")";
        // link = this.link;

        // photo_overlay.location = this.location;
        // photo_overlay.visible = true;


        // $('#photo').on('click', function() {
        //     window.open(link);
        // });
        // document.getElementById('photo').addEventListener('click', function() {
        //     window.open(this.link);
        // });
        // setTimeout(function() {
        //     document.getElementById('photo').className = 'photo-appear';
        // }, 120);

        this.animate('scale', 0.001, {
            duration: 150
        });
        current_marker = this;

    }

    function closePhoto() {

        if (!current_marker) return;

        // document.getElementById('photo').className = '';

        setTimeout((function() {
            // document.getElementById('photo').style.backgroundImage = 'none';
            photo_overlay.visible = false;
            this.opacity = 0.7;
            this.animate('scale', 1, {
                duration: 150
            });
        }).bind(current_marker), 100);

        current_marker = false;

    }


    function restorePins() {


        // shrinkPins();
        pinIndex = 0;
        pinTime = myearth.deltaTime;

        var restoreOnePin = function() {

            pinTime += myearth.deltaTime;
            if (pinTime > pinsPerSec) {
                pinTime -= pinsPerSec;
            } else {
                return;
            }

            if (!markers[pinIndex].visible) {

                markers[pinIndex].visible = true;
                markers[pinIndex].hotspot = true;
                markers[pinIndex].animate('scale', 1, {
                    duration: 560,
                    easing: 'out-back'
                });

            } else {

                // skip wait time
                pinTime = pinsPerSec;

            }

            if (++pinIndex >= markers.length) {
                myearth.removeEventListener("update", restoreOnePin);
            }

        };

        myearth.addEventListener("update", restoreOnePin);

    }

    function gotoBreakingNews(newsId) {

        myearth.goTo(news[newsId].location, {
            duration: 250,
            relativeDuration: 70
        });

    }
</script>
<div id="wrapper">

    <div id="earth-col">

        <div id="tip-layer">
            <div>
                <div id="tip-big"></div>
                <div id="tip-small"></div>
            </div>
        </div>
        <div id="myearth" class="earth-js"></div>
    </div>


    <!-- <div id="local-news">

        <h2 id="country-name" style="color:#257cff">News from around the&nbsp;world</span></h2>

        <p id="please-click">Click a country to show local news.</p>

    </div> -->

</div>