<div class="hero-blog-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" style="padding:0">
                <img src="<?= $blog['header_image_path'] ?>" alt="">
            </div>
        </div>
    </div>
</div>

 <div class="content-blog-single-page">
    <h2 class="name-blog"><?= $blog['title'] ?></h2>
    <?php if (false) { ?>
        <div class="content">
            <h4 class="title-blog">Dreaming of studying abroad?</h4>
            <p class="descrption">
                Dreaming of studying abroad? The journey from the MENA region to international universities is an exciting one, 
                and the International General Certificate of Secondary Education (IGCSE) can be your passport to this adventure. 
                Here is why:
            </p>
            <ul class="global-list">
                <li>
                    <span class="global-list-title">1. Global Recognition with a Local Touch</span>
                    <p>
                        Your IGCSE qualification is your ticket to global recognition. With IGCSE, 
                        you're equipped with an internationally accepted qualification that's 
                        recognized by top universities in the UK and abroad.
                    </p>
                </li>
                <li>
                    <span class="global-list-title">2-Language Proficiency and Cultural Empowerment</span>
                    <p>
                        Language skills and cultural understanding are invaluable assets. 
                        IGCSE's emphasis on communication skills and diverse 
                        subjects ensures that you're not just a student, 
                        but a global citizen ready to adapt and thrive anywhere you go.
                    </p>
                </li>   
                <li>
                    <span class="global-list-title">3-Subject Depth for Diverse Dreams</span>
                    <p>
                    IGCSE understands that every student is unique. With a diverse range of subjects, 
                    you can explore your passions and tailor your education to your aspirations. 
                    Whether your heart lies in sciences, humanities, or arts, 
                    IGCSE equips you with the foundation to succeed.
                    </p>
                </li>   
                <li>
                    <span class="global-list-title">4-Critical Thinking: Your Superpower</span>
                    <p>
                        Analysing complex situations, solving problems, and making informed decisions. 
                        That's the power of critical thinking, honed through the IGCSE curriculum. 
                        This skill isn't just for exams – it's your toolkit for excelling in higher education and beyond.
                    </p>
                </li>     
                <li>
                    <span class="global-list-title">5-Preparation for Your Next Chapter</span>
                    <p>
                        Imagine stepping onto an international campus with confidence, already acquainted with the academic landscape. 
                        IGCSE bridges the gap, aligning its curriculum with advanced studies. You're not starting from scratch; 
                        you're building on a strong foundation.
                    </p>
                </li> 
                <li>
                    <span class="global-list-title">6- Meeting Entry Requirements</span>
                    <p>
                        The doors to universities abroad swing wide open for IGCSE graduates. 
                        Institutions in Egypt and the MENA region value the international credibility of IGCSE. 
                        And guess what? Many international universities not only recognise your qualification but 
                        also consider it a substantial part of their entry requirements.
                    </p>
                </li> 
                <li>
                    <span class="global-list-title">7-Crafting Your Unique Story</span>
                    <p>
                        Studying abroad is about showcasing who you are. Your IGCSE journey provides you with experiences, 
                        challenges, and growth to shape your narrative. From personal statements to interviews, 
                        your journey becomes your unique story of resilience and determination.
                    </p>
                </li> 
                <li>
                    <span class="global-list-title">8-Network of Global Peers</span>
                    <p>
                        Studying abroad is about showcasing who you are. Your IGCSE journey provides you with experiences, 
                        challenges, and growth to shape your narrative. From personal statements to interviews, 
                        your journey becomes your unique story of resilience and determination.
                    </p>
                </li> 
                <li>
                    <span class="global-list-title">9-Scholarships: Rewarding Excellence</span>
                    <p>
                        Your dedication pays off – not just with knowledge, but with opportunities. 
                        Universities recognise excellence, and IGCSE graduates are prime candidates for scholarships and financial aid. 
                        Your achievements are your advantage in making higher education dreams come true
                    </p>
                </li>  
            </ul>
        </div>
    
    <?php } ?>

    <?= $blog['content_text'] ?>

</div> 

<div class="form-blog">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
                <?= $this->Form->create(null, array('url' => 'contact-us', 'id' => 'FormVisitorApp', 'class' => 'register')); ?>
                <input type="hidden" id="type" name="type" value="visitors-application">
                <div class="container-formBox">
                    <h4 class="title">Interested in studying abroad?</h4>
                    <p><span>BESA</span> can help – fill in your details and we’ll call you back.</p>
                    <div class="grid-container">

                        <?= $this->Form->control('name', [
                            'placeholder' => 'Full Name',
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>'], 'label' => 'Full Name*', 'required' => true
                        ]) ?>

                        <?= $this->Form->control('email', [
                            'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>



                        <?= $this->element('mobile_with_code') ?>

                        <?= $this->Form->control('surname', [
                            'placeholder' => 'Last Name*', 'label' => 'Last Name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>            

                        <?= $this->Form->control('school_name', [
                            'type' => 'text', 'placeholder' => 'School / University name', 'label' => 'School / University name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('study_level', [
                            'placeholder' => 'Level of study', 'type' => 'select', 'empty' => 'Select Level of study*',
                            'options' => $mainStudyLevels, 'label' => 'Level of study*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                     
                        <?= $this->Form->control('fair_venue', [
                            'placeholder' => 'Fair Venue*', 'type' => 'select', 'empty' => 'Select Fair Venue*',
                            'options' => $fairVenues, 'label' => 'Fair Venue*', 'required' => true, 'value' => (isset($selected_fair_venue) ? $selected_fair_venue : ''),
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->element('security_code', ['show_label' => true]) ?>

                    </div>

                    <button type="submit" class="btn greenish-teal">Submit</button>

                </div>
                <?= $this->Form->end() ?>
            </div>
         </div>
    </div>
</div>




