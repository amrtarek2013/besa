<link rel="stylesheet" href="/miniature-earth/examples/assets/example.css">
<!-- <link rel="stylesheet" href="/miniature-earth/demo/hologram/style.css"> -->

<script src="/miniature-earth/miniature.earth.js"></script>
<script>
    window.addEventListener("earthjsload", function() {


        var myearth = new Earth("myearth", {
            location: {
                lat: 0,
                lng: 0
            },
            autoRotate: true
        });


        myearth.addEventListener("ready", function() {

            this.addMarker({
                mesh: ["Pin"],
                color: '#30b81f',
                /* green */
                location: {
                    lat: 35,
                    lng: 0
                },
                scale: 1.5
            });

            this.addMarker({
                mesh: "Pin3",
                color: '#2549ff',
                /* blue */
                location: {
                    lat: 35,
                    lng: -22.5
                },
                scale: 1.5
            });

            this.addMarker({
                mesh: ["Pin2"],
                location: {
                    lat: 35,
                    lng: -45
                },
                scale: 1.5
            });


            // this.addMarker({
            //     mesh: ["Flag", "Needle"],
            //     color: '#30b81f',
            //     /* green */
            //     location: {
            //         lat: 35,
            //         lng: -90
            //     },
            //     scale: 1.5
            // });

            // this.addMarker({
            //     mesh: ["Flag2", "Needle"],
            //     color: '#2549ff',
            //     /* blue */
            //     location: {
            //         lat: 35,
            //         lng: -112.5
            //     },
            //     scale: 1.5
            // });

            // this.addMarker({
            //     mesh: ["Flag3", "Needle"],
            //     location: {
            //         lat: 35,
            //         lng: -135
            //     },
            //     scale: 1.5
            // });


            // this.addMarker({
            //     mesh: "X",
            //     location: {
            //         lat: 35,
            //         lng: -180
            //     },
            //     color: '#555',
            //     scale: 1.5
            // });

            // this.addMarker({
            //     mesh: "Diamond",
            //     color: 'cyan',
            //     opacity: 0.75,
            //     location: {
            //         lat: 35,
            //         lng: 135
            //     },
            //     scale: 1.5
            // });

            // this.addMarker({
            //     mesh: "Marker",
            //     location: {
            //         lat: 35,
            //         lng: 90
            //     },
            //     scale: 1.5
            // });

            // this.addMarker({
            //     mesh: "Cone",
            //     location: {
            //         lat: 35,
            //         lng: 45
            //     },
            //     color: '#555',
            //     scale: 1.5
            // });

        });

    });
</script>
<div id="myearth"></div>