<link rel="stylesheet" href="/miniature-earth/demo/photo-locations/style.css" />
<script src="/miniature-earth/miniature.earth.js" async></script>

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
    import { GLTFLoader } from "three/addons/loaders/GLTFLoader.js";
    import { MeshoptDecoder } from "three/addons/libs/meshopt_decoder.module.js";
    const loader = new GLTFLoader();
    loader.setMeshoptDecoder(MeshoptDecoder);
    window.GLTFLoader = loader;

    // import { DRACOLoader } from 'three/addons/loaders/DRACOLoader.js';
    // const loader = new DRACOLoader();
    // loader.setDecoderPath("/miniature-earth/flags/compressed/decoder/");
    // loader.preload();
    // window.DRACOLoader = loader; 
</script>

<script>
    var myearth;
    var localNewsMarker;
    var news = [];

    var markers = [];
    var airports = <?= json_encode($countriesEarth, true) ?>;
    var custom_regions_image;

    var selected_countries = [];
    var redirectUrl = "<?= $redirectUrl ?>";
    window.addEventListener("load", function () {
        const loader = window.GLTFLoader;

        // parse plane mesh from string in airports-and-plane-mesh.js
        // Earth.addMesh(airplaneMesh);

        myearth = new Earth("myearth", {
            mapHitTest: true,
            autoRotate: true,
            zoom: 1.15,
            zoomMin: 1,
            zoomMax: 3,
            quality: window.innerWidth <= 1024 ? 4 : 5,
            zoomable: true,
            location: {
                lat: 50,
                lng: 10
            },
            mapBorderColor: "#66d8ff",
            mapBorderWidth: 0.4,

            mapLandColor: "#FFF",
            mapSeaColor: "#66D8FF"
        });

        // var fading_images = [];

        myearth.addEventListener("ready", function () {
            // window.addEventListener('scroll', syncScroll);

            photo_overlay = this.addOverlay({
                content: `<div id="photo"><div id="close-photo" onclick="closePhoto(); event.stopPropagation();"></div>
                <a id="earth-link" href="#" targt="_blank">Open</a></div>`,
                visible: false,
                containerScale: 1,
                depthScale: 0.5
            });


            // add airport pins from airports array in airports-and-plane-mesh.js
            for (var i = 0; i < airports.length; i++) {
                // add photo pins
                const marker = this.addMarker({
                    // mesh: "Marker",
                    mesh: "",
                    // mesh : "Pyramid",
                    color: "#00A8FF",
                    location: {
                        lat: airports[i]["latitude"],
                        lng: airports[i]["longitude"]
                    },

                    scale: 0.01,
                    offset: 1.6,
                    visible: false,
                    transparent: true,
                    hotspot: true,
                    hotspotRadius: 0.75,
                    hotspotHeight: 1.3,

                    image: "/img/flags/" + airports[i]["flag"],

                    airportCode: airports[i]["code"],
                    airportName: airports[i]["country_name"],
                    airportFlag: "<img width='40' src='/img/flags/" + airports[i]["flag"] + "' />",

                    // custom property
                    title: airports[i]["country_name"],
                    link: redirectUrl == "destination" ?
                        "/country-details/" + airports[i]["permalink"] : "/universities/" + airports[i]["id"] + "/" + airports[i]["permalink"],

                    // custom property
                    photo_info: "/img/flags/" + airports[i]["flag"]
                });

                marker.addEventListener("click", openPhoto);

                // animate marker
                setTimeout(
                    function () {
                        this.visible = true;
                        this.animate("scale", 0.9, {
                            duration: 140
                        });
                        this.animate("offset", 0, {
                            duration: 1100,
                            easing: "bounce"
                        });
                    }.bind(marker),
                    280 * i
                );

                loader.load(`/miniature-earth/flags/compressed/${airports[i]["code"]}.glb`, function (glb) {
                    glb.scene.scale.multiplyScalar(0.3);
                    glb.scene.position.set(0, 0.5, 0);
                    marker.object3d.add(glb.scene);
                });
            }

            // syncScroll();
        });

        // Close photo overlay when navigating away
        myearth.addEventListener("change", function () {
            if (!current_marker || auto_rotate) return;
            if (Earth.getAngle(myearth.location, current_marker.location) > 45) closePhoto();
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
        if (
            myearth.goTo(this.location, {
                relativeDuration: 20,
                approachAngle: 12,
                end: function () {
                    auto_rotate = false;
                }
            })
        ) {
            auto_rotate = true;
        }

        document.getElementById("photo").style.backgroundImage = "url(" + this.photo_info + ")";

        document.getElementById("earth-link").href = this.link;
        document.getElementById("earth-link").text = this.airportCode + " - " + this.airportName;
        photo_overlay.location = this.location;
        photo_overlay.visible = true;

        setTimeout(function () {
            document.getElementById("photo").className = "photo-appear";
        }, 120);

        // this.animate('scale', 0.001, {
        //     duration: 150
        // });
        current_marker = this;
    }

    function closePhoto() {
        if (!current_marker) return;

        document.getElementById("photo").className = "";

        setTimeout(
            function () {
                document.getElementById("photo").style.backgroundImage = "none";
                photo_overlay.visible = false;
                // this.opacity = 0.7;
                // this.animate('scale', 1, {
                //     duration: 150
                // });
            }.bind(current_marker),
            100
        );

        current_marker = false;
    }
</script>

<!-- Start choose place-->
<section class="choose-place">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="title-choose-place">CHOOSE <span>WHERE</span> <br />TO STUDY</h2>
                <a href="#" class="btn btn-aqua">EXPLORE STUDYING <br />
                    ABROAD</a>
            </div>

            <div class="col-md-9">
                <div class="background-earth">
                    <div id="wrapper">
                        <div id="earth-col">
                            <div id="myearth" class="earth-js"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End choose place-->