<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\Utility\Hash;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    /**
     * Displays a view
     *
     * @param string ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\View\Exception\MissingTemplateException When the view file could not
     *   be found and in debug mode.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found and not in debug mode.
     * @throws \Cake\View\Exception\MissingTemplateException In debug mode.
     */
    public function display_(string ...$path): ?Response
    {
        if (!$path) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }
    public function main()
    {

        $this->loadModel('Sliders');
        $slider = $this->Sliders->find()->where(['active' => 1])->cache('home_sliders')->order(['display_order ' => 'asc'])->limit(5);
        // debug($slider->toArray());
        $this->set('sliders', $slider);

        $this->loadModel('Events');
        $events = $this->Events->find()->where(['active' => 1, 'show_on_home' => 1])->cache('home_events')->order(['display_order ' => 'asc'])->limit(3);
        $this->set('events', $events);


        $this->loadModel('Testimonials');
        $testimonials = $this->Testimonials->find()->where(['active' => 1, 'country_id is null or country_id < 1'])->cache('home_testimonials')->order(['rand()'])->toArray();
        $this->set('testimonials', $testimonials);
        // dd($testimonials);

        // $this->loadModel('Services');
        // $services = $this->Services->find()->where(['active' => 1, 'show_on_home' => 1])->order(['display_order ' => 'asc'])->limit(10);
        // $this->set('services', $services);

        $this->loadModel('Branches');
        $mainBranch = $this->Branches->find()->where(['active' => 1, 'is_main_branch' => 1])->cache('home_branches')->first();
        $this->set('mainBranch', $mainBranch);

        $this->loadModel('Enquiries');
        $enquiry = $this->Enquiries->newEmptyEntity();
        $this->set('enquiry', $enquiry);

        $home_why_besa2 = $this->getSnippet('home_why_besa2');
        $home_our_partners = $this->getSnippet('home_our_partners');
        $home_services_destination = $this->getSnippet('home_services_destination');
        $home_aboutus = $this->getSnippet('home_aboutus');
        $home_study_journey = $this->getSnippet('home_study_journey');
        $this->set(compact('home_why_besa2', 'home_our_partners', 'home_services_destination', 'home_aboutus', 'home_study_journey'));
    }
    private function _get_total_uploaded_files($os = '')
    {
        $query3 = $this->Uploads->find();
        if ($os) {
            if ($os == "iOS") {
                $conditions["os_type"] = "1";
            } elseif ($os == "Huawei") {
                $conditions["os_type"] = "2";
            } elseif ($os == "Android") {
                $conditions["or"]["os_type"] = 0;
                $conditions["or"][] = "os_type is null";
            }
            $users_in_country = $this->Users->find()->where($conditions)->all()->toArray();
            if (!empty($users_in_country)) {
                $filtered_user_ids = [];
                foreach ($users_in_country as $ccvalue) {
                    $filtered_user_ids[] = $ccvalue->id;
                }
            }
            $conditions1 = [];
            if (!empty($filtered_user_ids)) {
                $conditions1["user_id in"] = $filtered_user_ids;
            }
            $total_uploaded_files_obj = $query3->select(['uploads_count' => $query3->func()->count('id')])
                ->where($conditions1)
                ->all()->toArray();
        } else {
            $total_uploaded_files_obj = $query3->select(['uploads_count' => $query3->func()->count('id')])
                ->all()->toArray();
        }
        return $total_uploaded_files_obj[0]->uploads_count;
    }

    private function _get_active_users($os = '')
    {
        $query6 = $this->Uploads->find();
        if ($os) {
            if ($os == "iOS") {
                $conditions["os_type"] = "1";
            } elseif ($os == "Huawei") {
                $conditions["os_type"] = "2";
            } elseif ($os == "Android") {
                $conditions["or"]["os_type"] = 0;
                $conditions["or"][] = "os_type is null";
            }
            $users_in_country = $this->Users->find()->where($conditions)->all()->toArray();
            if (!empty($users_in_country)) {
                $filtered_user_ids = [];
                foreach ($users_in_country as $ccvalue) {
                    $filtered_user_ids[] = $ccvalue->id;
                }
            }
            $conditions1 = [];
            if (!empty($filtered_user_ids)) {
                $conditions1["user_id in"] = $filtered_user_ids;
            }
            $active_users = $query6->select(['users_count' => $query6->func()->count('DISTINCT user_id')])
                ->where($conditions1)
                ->all()->toArray();
        } else {
            $active_users = $query6->select(['users_count' => $query6->func()->count('DISTINCT user_id')])
                ->all()->toArray();
        }
        return $active_users[0]->users_count;
    }

    public function view($id = null)
    {

        $page = $this->Pages->findByPermalink($id)->first();



        // if ($page->is_url) {
        //         $this->redirect($page['url']);
        //     }


        $this->set('page', $page);
    }


    public function preview()
    {

        $data = $this->request->getData();
        debug($data);
        die;
    }

    public function home2()
    {
        // die("---");
        // Configure::write('debug', 2);
        // Configure::write('debug', true);
        $this->loadModel('RecordedVideos');
        $mostWatchedVideos = $this->RecordedVideos->find()->contain(['RecordedVideoViews' => ['fields' => ['id', 'recorded_video_id']]])->where(['show_in_most_watched' => 1])->all()->toArray();
        // dd($mostWatchedVideos);
        $this->set('mostWatchedVideos', $mostWatchedVideos);


        $this->loadModel('Sessions');
        $newFeatureVideos = $this->Sessions->find()->contain(['RecordedVideos'])->where(['show_as_new_feature' => 1, 'recorded_video_id is not null'])->limit(10)->all()->toArray();

        $this->set('newFeatureVideos', $newFeatureVideos);




        $this->loadModel('SpecialEventsImages');
        $specialEventMainImage = $this->SpecialEventsImages->find()->where(['active' => 1, 'is_main_image' => 1])->first();

        $this->set('specialEventMainImage', $specialEventMainImage);
        $this->loadModel('SpecialEventsImages');
        $specialEventsImages = $this->SpecialEventsImages->find()->where(['active' => 1, 'is_main_image !=' => 1])->all()->toArray();

        $this->set('specialEventsImages', $specialEventsImages);

        $home_most_watched_desc_text = $this->getSnippet('home_most_watched_desc_text');
        $home_special_events_desc_text = $this->getSnippet('home_special_events_desc_text');
        $home_new_features_desc_text = $this->getSnippet('home_new_features_desc_text');

        $this->set(compact('home_most_watched_desc_text', 'home_special_events_desc_text', 'home_new_features_desc_text'));
    }
    public function display()
    {

        $home_page = "home-page";
        $page = $this->Pages->findByPermalink($home_page)->first();
        // dd($page);
        $this->set('page', $page);
        // $this->render("view");

    }

    public function show($id = null) // or permalink
    {
        // Configure::write('debug', true);
        $this->viewBuilder()->setLayout('default');
        // $home_page = "home-page";
        // $page = $this->Pages->findByPermalink($home_page)->first();
        // // dd($page);
        // $this->set('page', $page);
        // $this->render("view");


        $this->loadModel('RecordedVideos');

        $conditions = array(
            // 'created >=' => date('Y-m-d', strtotime('- 7days')),
            'OR' => ['RecordedVideos.id' => $id, 'RecordedVideos.permalink' => $id]
        );

        $recordedVideo = $this->RecordedVideos->find()->contain(['Serieses'])->where($conditions)->first();
        // dd($recordedVideo);
        $this->set('recordedVideo', $recordedVideo);

        if (!empty($recordedVideo)) {
            $otherVideos = array();
            if (!empty($recordedVideo['series_id'])) {
                $conditions = ['series_id' => $recordedVideo['series_id']];
                $otherVideos = $this->RecordedVideos->find()->where($conditions)->all();
            }
            if (empty($otherVideos)) {
                $selectedCats = explode(',', $recordedVideo['categories']);
                $conds1 = array();
                foreach ($selectedCats as $skey => $svalue) {
                    if (!empty($svalue)) {
                        $conds1["or"][] = array("categories like" => "%," . $svalue . ",%");
                    }
                }
                $conds1["active"] = 1;
                $conds1["series_id is "] = null;
                $otherVideos = $this->RecordedVideos->find('all')->where($conds1)->order("created desc")->limit(10)->toArray();
            }
            $this->set('otherVideos', $otherVideos);


            $userData = $this->Session->read('Auth.Users');
            if ($this->Session->check('is_subscribed') && !empty($userData)) {
                $this->set('is_subscribed', $this->Session->read('is_subscribed'));
            } else {
                // debug($this->getSnippet('subscription_play_video_message'));
                $this->set('FlashMessagePopSnippet', $this->getSnippet('subscription_play_video_message'));
                $this->set('FlashMessagePopSnippet_image', $this->getSnippet_image('subscription_play_video_message'));
            }
        } else {

            $this->Flash->error(__('The Vide not found. Please, try again.'));
            $this->redirect('/');
        }
    }

    public function aboutUs()
    {

        $aboutusSnippet = $this->getSnippet('aboutus');
        $this->set('bodyClass', 'pageAbout');
        $this->set('aboutusSnippet', $aboutusSnippet);
        $this->loadModel('AboutusSliders');
        $aboutusSlidersList = $this->AboutusSliders->find()->where(['active' => 1])->order(['display_order' => 'asc'])->all();

        $this->set('aboutusSlidersList', $aboutusSlidersList);
    }
    public function partnershipWithBesa()
    {

        // $book_free_meeting = $this->getSnippet('book_free_meeting');
        $partnershipWithBesa = $this->getSnippet('partnership_with_besa');
        $this->set('bodyClass', '');
        // $this->set('book_free_meeting', $book_free_meeting);
        $this->set('partnership_with_besa', $partnershipWithBesa);
    }
    public function careerApply($id = null, $title = null)
    {
        if (isset($title))
            $this->set('careerTitle', $title);

        if (isset($id))
            $this->set('id', $id);
        else {
            $this->Flash->error(__('Sorry, selected career not found!'));
            $this->redirect('/careers');
        }

        // $book_free_meeting = $this->getSnippet('book_free_meeting');
        $partnershipWithBesa = ''; //$this->getSnippet('partnership_with_besa');
        $this->set('bodyClass', '');
        // $this->set('book_free_meeting', $book_free_meeting);
        $this->set('partnership_with_besa', $partnershipWithBesa);


        // $this->loadModel('Careers');
        // $careersList = $this->Careers->find('list', [
        //     'keyField' => 'id', 'valueField' => 'title'
        // ])->where(['active' => 1])->order(['title' => 'asc']);
        // $this->set('careersList', $careersList);

        $this->loadModel('Careers');
        $careersList = $this->Careers->find()->select([
            'id', 'title' => 'CONCAT(title, " (",country,"-", state,")")'
        ])->where(['active' => 1])->order(['title' => 'asc'])->all();
        // dd($careersList);
        $careersList = Hash::combine($careersList->toArray(), '{n}.id', '{n}.title');
        $this->set('careersList', $careersList);
    }
    public function partnerInstitutions()
    {

        $partner_institutions_bottom_section = $this->getSnippet('partner_institutions_bottom_section');
        $partner_institutions = $this->getSnippet('partner_institutions');
        $this->set('bodyClass', '');
        $this->set('partner_institutions_bottom_section', $partner_institutions_bottom_section);
        $this->set('partner_institutions_left_boxs', $partner_institutions);
    }
    public function pathwayPrograms()
    {

        $book_free_meeting = $this->getSnippet('book_free_meeting');
        $pathway_programs = $this->getSnippet('pathway_programs');
        $this->set('bodyClass', 'pageAbout');
        $this->set('book_free_meeting', $book_free_meeting);
        $this->set('pathway_programs', $pathway_programs);
    }
    public function appSupport()
    {

        $this->set('bodyClass', '');
    }
    public function pathwayPlacement()
    {

        $book_free_meeting = $this->getSnippet('book_free_meeting');
        $pathway_placement = $this->getSnippet('pathway_placement');
        $this->set('bodyClass', 'pageAbout');
        $this->set('book_free_meeting', $book_free_meeting);
        $this->set('pathway_placement', $pathway_placement);
    }
    public function universityPlacement()
    {

        $book_free_meeting = $this->getSnippet('book_free_meeting');
        $university_placement = $this->getSnippet('university_placement');
        $this->set('bodyClass', 'pageAbout');
        $this->set('book_free_meeting', $book_free_meeting);
        $this->set('university_placement', $university_placement);
    }
    public function youngLearners()
    {

        $book_free_meeting = $this->getSnippet('book_free_meeting');
        $young_learners = $this->getSnippet('young_learners');
        $this->set('bodyClass', 'pageAbout');
        $this->set('book_free_meeting', $book_free_meeting);
        $this->set('young_learners', $young_learners);
    }
    public function whereToStudy()
    {
        $this->set('showImageCountries', true);
        $this->set('bodyClass', 'pageWhereToStudy');
    }
    public function contactUs()
    {
        $this->set('bodyClass', '');
        $this->loadModel('Branches');
        $branches = $this->Branches->find()->where(['active' => 1])->order(['name' => 'ASC'])->all()->toArray();
        $branchesList = Hash::combine($branches, '{n}.id', '{n}.country');
        $branches = Hash::combine($branches, '{n}.id', '{n}.name', '{n}.country');
        $this->set(compact('branchesList', 'branches'));
    }
}
