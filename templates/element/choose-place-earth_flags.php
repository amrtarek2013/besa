<link rel="stylesheet" href="/miniature-earth/demo/photo-locations/style.css">
<script src="/miniature-earth/miniature.earth.js" async> </script>

<style>
    .photo-appear {
        cursor: pointer;
        pointer-events: all;
    }

    #photo {
        width: 120px;
        height: 80px;
        /* border-radius: 50%;
        border: 10px solid;
        border-color: blueviolet; */
    }

    #tip-layer {
        border-radius: 10%;
        padding: 5px;
    }


    #earth-link {
        position: absolute;
        right: 2px;
        bottom: 2px;
        filter: drop-shadow(3px 3px 3px black);
        cursor: pointer;
        pointer-events: all;
        color: #fff;
    }

    #photo {
        text-align: center;
    }
</style>
<script async src="https://unpkg.com/es-module-shims@1.8.0/dist/es-module-shims.js"></script>
<script type="importmap">
    {
    "imports": {
      "three": "https://unpkg.com/three@0.155.0/build/three.module.js",
      "three/addons/": "https://unpkg.com/three@0.155.0/examples/jsm/"
    }
  }
</script>

<script type="module">
    import {
        GLTFLoader
    } from 'three/addons/loaders/GLTFLoader.js';
    window.GLTFLoader = GLTFLoader;
</script>
<script>
    var myearth;
    var localNewsMarker;
    var news = [];

    var markers = [];
    var countries = <?= json_encode($countriesEarth, true) ?>;
    var custom_regions_image;

    console.log(countries);

    var selected_countries = [];
    var redirectUrl = '<?= $redirectUrl ?>';
    // Earth.addMesh( 'o Pyramid\nv 0.25 0.0 -0.25\nv 0.25 0.0 0.25\nv -0.25 0.0 0.25\nv -0.25 0.0 -0.25\nv -0.0 0.5 0.0\ns off\nf 2 4 1\nf 1 5 2\nf 2 5 3\nf 3 5 4\nf 5 1 4\nf 2 3 4\n' );
    window.addEventListener("load", function() {

        // parse plane mesh from string in countries-and-plane-mesh.js	
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


            var markers = [];
            // window.addEventListener('scroll', syncScroll);

            photo_overlay = this.addOverlay({
                content: `<div id="photo"><div id="close-photo" onclick="closePhoto(); event.stopPropagation();"></div>
                <a id="earth-link" href="#" targt="_blank">Open</a></div>`,
                visible: false,
                containerScale: 1,
                depthScale: 0.5
            });

            let loader = null;

            let mesh1 = ["Flag", "Needle"];
            // add airport pins from countries array in countries-and-plane-mesh.js
            for (var i = 0; i < countries.length; i++) {
                // for (var i = 0; i < 1; i++) {
                // add photo overlay


                loader = new window.GLTFLoader();

                // add photo pins

                if (countries[i]['code'] == "UK")
                    mesh1 = "";
                else
                    // continue;
                    mesh1 = ["Flag", "Needle"];
                // console.log(mesh1);
                var marker = null;
                marker = this.addMarker({

                    // mesh: "Marker",
                    mesh: mesh1,
                    // mesh : "Pyramid",
                    color: '#00A8FF',
                    location: {
                        lat: countries[i]['latitude'],
                        lng: countries[i]['longitude']
                    },

                    scale: 0.01,
                    offset: 1.6,
                    visible: false,
                    transparent: true,
                    hotspot: true,
                    hotspotRadius: 0.75,
                    hotspotHeight: 1.3,

                    image: "/img/flags/" + countries[i]['flag'],

                    airportCode: countries[i]['code'],
                    airportName: countries[i]['country_name'],
                    airportFlag: "<img width='40' src='/img/flags/" + countries[i]['flag'] + "' />",


                    // custom property
                    title: countries[i]['country_name'],
                    link: (redirectUrl == 'destination' ? '/country-details/' + countries[i]['permalink'] : '/universities/' + countries[i]['id'] + '/' + countries[i]['permalink']),

                    // custom property
                    photo_info: "/img/flags/" + countries[i]['flag']

                });

                if (countries[i]['code'] == "UK")

                    setTimeout((function() {
                        loader.load(
                            '/miniature-earth/thailand.glb',
                            function(gltf) {
                                marker.object3d.add(gltf.scene);
                                gltf.scene.scale.multiplyScalar(.35);
                            },
                            // called while loading is progressing
                            function(xhr) {
                                console.log((xhr.loaded / xhr.total * 100) + '% loaded');
                            },
                            // called when loading has errors
                            function(error) {
                                console.log('An error happened');
                            });
                    }).bind(marker), 280 * i);


                marker.addEventListener('click', openPhoto);

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
            }

            // syncScroll();
        });


        // close photo overlay when navigating away

        myearth.addEventListener("change", function() {

            if (!current_marker || auto_rotate) return;

            if (Earth.getAngle(myearth.location, current_marker.location) > 45) {
                closePhoto();
            }

        });
    });



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
                relativeDuration: 20,
                approachAngle: 12,
                end: function() {
                    auto_rotate = false;
                }
            })) {
            auto_rotate = true;
        }


        document.getElementById('photo').style.backgroundImage = "url(" + this.photo_info + ")";

        document.getElementById('earth-link').href = this.link;
        document.getElementById('earth-link').text = this.airportCode + ' - ' + this.airportName;
        photo_overlay.location = this.location;
        photo_overlay.visible = true;

        setTimeout(function() {
            document.getElementById('photo').className = 'photo-appear';
        }, 120);

        // this.animate('scale', 0.001, {
        //     duration: 150
        // });
        current_marker = this;

    }

    function closePhoto() {

        if (!current_marker) return;

        document.getElementById('photo').className = '';

        setTimeout((function() {
            document.getElementById('photo').style.backgroundImage = 'none';
            photo_overlay.visible = false;
            // this.opacity = 0.7;
            // this.animate('scale', 1, {
            //     duration: 150
            // });
        }).bind(current_marker), 100);

        current_marker = false;

    }
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

                            <!-- <div id="tip-layer">
                                <div>
                                    <div id="tip-big"></div>
                                    <div id="tip-small"></div>
                                </div>
                            </div> -->
                            <div id="myearth" class="earth-js"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End choose place-->