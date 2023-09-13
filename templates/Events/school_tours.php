<section class="main-banner british-banner fair-banner <?= $event['style'] ?>" style="padding-bottom:0 !important;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7" style="padding-left: 0;">
                <div class="background-banner-color">
                    <img src="/img/31098 [Converted] 1.png" alt="" style="z-index: 2;" width="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-5">
                <div class="relative-box-about ">

                    <?php $tt = explode(' ', trim($event['title'])) ?>
                    <h1 class="relative-text"><?= substr($tt[0], 0, 6) ?></h1>
                    <h2 class="title text-left"><?= $event['title'] ?></h2>

                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" style="padding: 0;">
                <div class="title-banner-blue  title-banner-green" >
                    <h2>Dreaming of studying abroad?</h2>
                    <p>
                        The journey from the MENA region to international
                        universities is an exciting one, and the International General Certificate of Secondary
                        Education (IGCSE) can be your passport to this adventure.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="global-engagement">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title-eng">Here is why</h2>
                <div class="group-cards">
                    <div class="card-eng">
                        <img src="/img/icon/global-connection.png" loading="lazy" alt="Icon Global connection ">
                        <h4>Global Recognition with a Local Touch</h4>
                    </div>
                    <div class="card-eng">
                    <img src="/img/icon/languages.png" loading="lazy" alt="Icon languages ">
                        <h4>Language Proficiency and Cultural Empowerment</h4>
                    </div>
                    <div class="card-eng">
                    <img src="/img/icon/dream.png" loading="lazy" alt="Icon dream ">
                        <h4>Subject Depth for Diverse Dreams</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ExploringAbroadSection">
    <div class="container">
        <div class="row">
            <div class="cold-md-12">
                <p class="p_18">Embark on a Journey of Discovery: BESA School Tours Unveil the World of Study Abroad</p>
                <p class="p_12">At BESA, we believe that studying abroad is an unparalleled opportunity forpersonal and intellectual growth. We understand the importance of immersingoneself in different cultures</p>
            </div>
        </div>
    </div>
</div>


<div class="school-tour-slider">
  <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="slider">
                <div class="item">
                    <h2>Title 1</h2>
                    <div class="box">
                    <img src="image1.jpg" alt="Image 1">
                    </div>
                    <div class="box">
                    <img src="image2.jpg" alt="Image 2">
                    </div>
                    <div class="box">
                    <img src="image3.jpg" alt="Image 3">
                    </div>
                </div>
                <!-- Add more items with the same structure -->
            </div>

            <div class="large-box">
                    <img src="" alt="Large Image" id="largeImage">
            </div>

        </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function(){
  $(".slider").owlCarousel({
    items: 1, // Show one item at a time
    nav: true, // Show navigation arrows
    loop: true, // Enable looping
    onChanged: updateLargeImage // Custom function for updating the large image
  });
});

function updateLargeImage(event){
  var currentIndex = event.item.index;
  var currentTitle = $(event.target).find(".item").eq(currentIndex).find("h2").text();
  var currentImages = $(event.target).find(".item").eq(currentIndex).find(".box img");

  // Update large image and title
  $("#largeImage").attr("src", currentImages.eq(0).attr("src"));
  // You can also update the title as per your design

  // Add click event to box images
  currentImages.click(function(){
    var imageUrl = $(this).attr("src");
    $("#largeImage").attr("src", imageUrl);
  });
}

</script>