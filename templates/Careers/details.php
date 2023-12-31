<style>
    p,
    h3,
    h4,
    h5,
    span {
        text-align: justify;
        line-height: 32px;
    }
</style>
<script type="text/javascript" src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
<script type="text/javascript" src="https://mozilla.github.io/pdf.js/build/pdf.worker.js"></script>
<script>
    $(document).ready(function() {
        var url = "https://github.com/mozilla/pdf.js/blob/master/web/compressed.tracemonkey-pldi-09.pdf";

        // Asynchronous download PDF
        pdfjsLib.PDFJS.getDocument(url)
            .then(function(pdf) {
                return pdf.getPage(1);
            })
            .then(function(page) {
                // Set scale (zoom) level
                var scale = 1.5;

                // Get viewport (dimensions)
                var viewport = page.getViewport(scale);

                // Get canvas#the-canvas
                var canvas = document.getElementById('the-canvas');

                // Fetch canvas' 2d context
                var context = canvas.getContext('2d');

                // Set dimensions to Canvas
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Prepare object needed by render method
                var renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };

                // Render PDF page
                page.render(renderContext);
            });
    })
</script>
<canvas id='the-canvas'></canvas>
<?php

if (false) {
?>
    <section class="main-banner  inner-serv unitedKingdom-banner">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">

                    <img src="<?= $career['image_path'] ?>" alt="" style="width: 100%;">
                </div>
                <!-- <div class="col-md-12" style="padding:30px">
                <h1 class="title" style="font-size: 35px;">Location<?= $career['title'] ?></h1>
            </div> -->
            </div>
        </div>

    </section>

    <div class="title-header-blue" style="padding-bottom:0px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title" style="font-size: 35px; text-align:center; color:var(--bs-white)"><?= $career['title'] ?> <h1>
                            <h3 class="title" style="font-size: 25px; text-align:center; color:var(--bs-white)"> <?= $career['country'] ?> - <?= $career['state'] ?></h3>
                            <?php

                            if (!isset($show_pdf)) {
                            ?>
                                <h3 style="text-align: center;">
                                    <a href="<?= Cake\Routing\Router::Url('/career-details/' . $permalink . '/' . $id . '/1') ?>" target="_blank" style="color: var(--bs-main);"><i class="fa-solid fa-file-pdf"></i> View Job Full Requirments</a>
                                </h3>
                            <?php } ?>

                </div>
            </div>
        </div>
    </div>
<?php
}
if (false && isset($show_pdf)) {
?>
    <embed src="<?= $career['file_path'] ?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="800px" />
    <!--     
    <object data="<?= $career['file_path'] ?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="800px"></object>

    <iframe src="<?= $career['file_path'] ?>" width="800" height="500"></iframe> -->

    <canvas id="the-canvas" style="border: 1px solid black; direction: ltr;"></canvas>


    <script src="/pdf.js-master/src/pdf.js" type="module"></script>

    <script type="module">
        import {
            pdfjsLib
        } from "/pdf.js-master/src/pdf.js";
        // window.pdfjsLib = new pdfjsLib();
    </script>

    <script id="script">
        //
        // If absolute URL from the remote server is provided, configure the CORS
        // header on that server.
        //
        var url = '<?= str_replace('\\', '/', $career['file_path']) ?>';
        console.log(url);

        //
        // The workerSrc property shall be specified.
        //
        pdfjsLib.GlobalWorkerOptions.workerSrc =
            '/pdf.js-master/src/pdf.worker.js';

        //
        // Asynchronous download PDF
        //
        const loadingTask = pdfjsLib.getDocument(url);
        console.log(loadingTask);
        (async () => {
            const pdf = await loadingTask.promise;
            //
            // Fetch the first page
            //
            const page = await pdf.getPage(1);
            const scale = 1.5;
            const viewport = page.getViewport({
                scale
            });
            // Support HiDPI-screens.
            const outputScale = window.devicePixelRatio || 1;

            //
            // Prepare canvas using PDF page dimensions
            //
            const canvas = document.getElementById("the-canvas");
            const context = canvas.getContext("2d");

            canvas.width = Math.floor(viewport.width * outputScale);
            canvas.height = Math.floor(viewport.height * outputScale);
            canvas.style.width = Math.floor(viewport.width) + "px";
            canvas.style.height = Math.floor(viewport.height) + "px";

            const transform = outputScale !== 1 ? [outputScale, 0, 0, outputScale, 0, 0] :
                null;

            //
            // Render PDF page into canvas context
            //
            const renderContext = {
                canvasContext: context,
                transform,
                viewport,
            };
            page.render(renderContext);
        })();
    </script>
<?php } else { ?>
    <?= $career['text'] ?>
    <?= $career['requirments'] ?>
<?php } ?>


<section class=" tabes british-tabes">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="gridTabes">
                    <a class="btn clear-blue foundation" href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['pages.careerapply'] . '/' .  $career['id'] . '/' . $career['title']) ?>">Apply Now</a>

                </div>
            </div>
        </div>
    </div>
</section>