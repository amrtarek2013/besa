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
        Earth.addMesh(airplaneMesh);


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
            mapBorderWidth: 0.4

        });


        var fading_images = [];
        myearth.addEventListener("ready", function() {


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

                    visible: false,
                    hotspot: true,
                    hotspotRadius: 0.5,
                    hotspotHeight: 1.5,
                    image: "/img/flags/" + airports[i]['flag'],
                    // color: 'red',

                    airportCode: airports[i]['country_code'],
                    airportName: airports[i]['country_name'],

                    // custom properties
                    // title: markers[i].title,
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

                    document.getElementById('tip-layer').style.opacity = 1;
                    document.getElementById('tip-big').innerHTML = this.airportCode;
                    document.getElementById('tip-small').innerHTML = this.airportName.split(',').join('<br>');

                    // this.color = 'red';

                });

                marker.addEventListener('mouseout', function() {

                    // if (this != startMarker && this != endMarker) {
                    this.color = '#00a8ff';
                    // }
                    document.getElementById('tip-layer').style.opacity = 0;

                });
                markers.push(marker);

            }

            // restorePins();



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



    });
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