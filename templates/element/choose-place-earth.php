<!-- <link rel="stylesheet" href="/miniature-earth/examples/assets/example.css"> -->
<link rel="stylesheet" href="/miniature-earth/demo/world-news/style.css">

<link rel="stylesheet" href="/miniature-earth/demo/flight-time/style.css">
<link rel="stylesheet" href="/miniature-earth/demo/photo-locations/style.css">
<!-- <script src="/miniature-earth/miniature.earth.js"></script> -->
<script src="/miniature-earth/miniature.earth.js"></script>
<!-- <script src="/miniature-earth/demo/world-news/countries.js"></script> -->

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

    #tip-layer {
        border-radius: 10%;
        padding: 5px;
    }
</style>

<script>
    var myearth;
    var localNewsMarker;
    var news = [];

    var markers = [];
    var airports = <?= json_encode($countriesEarth, true) ?>;
    var custom_regions_image;

    var selected_countries = [];
    var redirectUrl = '<?= $redirectUrl ?>';

    window.addEventListener("earthjsload", function() {

        // parse plane mesh from string in airports-and-plane-mesh.js	
        // Earth.addMesh(airplaneMesh);


        myearth = new Earth('myearth', {

            mapHitTest: true,
            autoRotate: true,
            zoom: 1.15,
            zoomMin: 1,
            zoomMax: 3,
            quality: (window.innerWidth <= 1024) ? 4 : 5,
            zoomable: true,
            location: {
                lat: 50,
                lng: 10
            },
            mapBorderColor: '#66d8ff',
            mapBorderWidth: 0.4,

            mapLandColor: '#FFF',
            mapSeaColor: '#66D8FF',
        });


        // var fading_images = [];




        myearth.addEventListener("ready", function() {


            photo_overlay = this.addOverlay({
                content: '<div id="photo"><div id="close-photo" onclick="closePhoto(); event.stopPropagation();"></div></div>',
                visible: false,
                containerScale: 1,
                depthScale: 0.5
            });

            // add airport pins from airports array in airports-and-plane-mesh.js
            for (var i = 0; i < airports.length; i++) {
                // add photo overlay


                // add photo pins


                var marker = this.addMarker({

                    // mesh: "Marker",
                    mesh: ["Pin", "Needle"],
                    color: '#00A8FF',
                    location: {
                        lat: airports[i]['latitude'],
                        lng: airports[i]['longitude']
                    },

                    scale: 0.01,
                    offset: 1.6,
                    visible: false,
                    transparent: true,
                    hotspot: true,
                    hotspotRadius: 0.75,
                    hotspotHeight: 1.3,

                    image: "/img/flags/" + airports[i]['flag'],

                    airportCode: airports[i]['code'],
                    airportName: airports[i]['country_name'],
                    airportFlag: "<img width='40' src='/img/flags/" + airports[i]['flag'] + "' />",


                    // custom property
                    title: airports[i]['country_name'],
                    link: (redirectUrl == 'destination' ? '/country-details/' + airports[i]['permalink'] : '/universities/' + airports[i]['id'] + '/' + airports[i]['permalink']),

                    // custom property
                    photo_info: "/img/flags/" + airports[i]['flag']

                });

                marker.addEventListener('click', function() {

                    // alert('sssssssssss');
                    window.open(this.link);
                });

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

                marker.addEventListener('mouseover', function() {
                    // rotate earth if needed

                    myearth.autoRotate= false;

                    document.getElementById('tip-layer').style.opacity = 0.7;
                    document.getElementById('tip-big').innerHTML = this.airportFlag;
                    document.getElementById('tip-small').innerHTML = this.airportCode + ' - ' + this.airportName.split(',').join('<br>');
                    // this.color = 'red';
                });

                marker.addEventListener('mouseout', function() {

                    // if (this != startMarker && this != endMarker) {
                    // this.color = '#00a8ff';
                    // }
                    document.getElementById('tip-layer').style.opacity = 0;
                    
                    myearth.autoRotate= true;
                });

            }


        });
    });

    /*marker = this.addSprite({

        // mesh: "Marker",
        location: {
            lat: airports[i]['latitude'],
            lng: airports[i]['longitude']
        },

        visible: false,
        hotspot: true,
        hotspotRadius: 0.5,
        hotspotHeight: 1,
        // image: "/img/flags/" + airports[i]['flag'],

        // mesh: ["Pin", "Needle"],
        // color: 0x30b81f,

        // transparent: true,

        airportCode: airports[i]['code'],
        airportName: airports[i]['country_name'],
        airportFlag: "<img width='40' src='/img/flags/" + airports[i]['flag'] + "' />",

        // custom properties
        title: airports[i]['country_name'],
        link: (redirectUrl == 'destination' ? '/country-details/' + airports[i]['permalink'] : '/universities/' + airports[i]['id'] + '/' + airports[i]['permalink']),

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

    // this.addOverlay({
    //     content: '<div id="photo"><div id="close-photo" onclick="closePhoto(); event.stopPropagation();"></div></div>',
    //     visible: true,
    //     containerScale: 1,
    //     depthScale: 0.5
    // });

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
    // pin events

    marker.addEventListener('mouseover', function() {
        document.getElementById('tip-layer').style.opacity = 0.7;
        document.getElementById('tip-big').innerHTML = this.airportFlag;
        document.getElementById('tip-small').innerHTML = this.airportCode + ' - ' + this.airportName.split(',').join('<br>');
        // this.color = 'red';
    });

    marker.addEventListener('mouseout', function() {

        // if (this != startMarker && this != endMarker) {
        // this.color = '#00a8ff';
        // }
        document.getElementById('tip-layer').style.opacity = 0;
    });
    markers.push(marker);

    }
    // restorePins();


    });



    });    */
</script>
<!-- Start choose place-->
<section class="choose-place">
    <div class="container">
        <div class="row">
            <?php if (isset($left_html)) {
                echo $left_html;  ?>
                <div class="col-md-4">
                    <div class="green-box-earth">
                        <p>BESA is proud to work with over 400 institutions worldwide</p>
                    </div>

                    <div class="blue-box-earth">
                        <p>Our global presence allows you to access international universities, schools and programs.</p>
                    </div>
                </div>


            <?php } else {
            ?>
                <div class="col-md-3">
                    <h2 class="title-choose-place">CHOOSE <span>WHERE</span> <br>TO STUDY</h2>
                    <a href="#" class="btn btn-aqua">EXPLORE STUDYING <br> ABROAD</a>
                </div>
            <?php } ?>
            <div class="col-md-<?= $colWidth ?>">
                <div class="background-earth">

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

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End choose place-->