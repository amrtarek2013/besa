<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use PSpell\Config;

class EnquiriesController extends AppController
{

    public function contactUs()
    {
        $this->set('bodyClass', '');
        $this->loadModel('Branches');


        $enquiry = $this->Enquiries->newEmptyEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {

            Configure::write('debug', 0);
            Configure::write('debug', false);
            $data = $this->request->getData();
            // dd($data);
            $enquiry = $this->Enquiries->patchEntity($enquiry, $data, ['validate' => $this->Enquiries->enquiryTypes[$data['type']]['validation']]);



            $return = [];
            $return['message'] = 'Sorry, try again';
            $return['status']  = 0;
            $return['title'] = 'Error';
            // debug($enquiry);
            // die;
            $enquiry_redirect_url = $this->Enquiries->enquiryTypes[$enquiry['type']]['redirect'];
            if ($this->Enquiries->save($enquiry)) {
                $this->sendToBitrix($enquiry, $enquiry['type'], $this->Enquiries->enquiryTypes);

                $return['message'] = 'Success';
                $return['status']  = 1;
                $return['title'] = 'Success';

                $enquiryTitle = $this->Enquiries->enquiryTypes[$enquiry['type']]['title'];
                $a_replace = [];
                $b_replace = [];
                $u_replace = [];
                // $url = '<a href="' . Router::url('/admin/enquiries/view/' . $enquiry['id'], true) . '" >View Enquiry</a>';
                $url = Router::url('/admin/enquiries/view/' . $enquiry['id'], true);
                /*if (isset($enquiry['branch_id'])) {
                    $this->loadModel('Branches');
                    // $branch = $this->Branches->find()->where(['id' => $enquiry['branch_id']])->first();


                    $b_replace = array(
                        '{%name%}' => $enquiry['name'],
                        '{%email%}' => $enquiry['email'],
                        '{%phone%}' => $enquiry['mobile'],
                        '{%subject%}' => $enquiry['subject'],
                        '{%message%}' => $enquiry['message'],
                        '{%enquiry_type%}' => $enquiryTitle,
                    );
                    
                    if (!empty($branch)) {
                        $a_replace = array(
                            '{%name%}' => $enquiry['name'],
                            '{%email%}' => $enquiry['email'],
                            '{%phone%}' => $enquiry['mobile'],
                            '{%subject%}' => $enquiry['subject'],
                            '{%message%}' => $enquiry['message'],

                            '{%enquiry_type%}' => $enquiryTitle,
                            // '{%branch_name%}'  => $branch['name'],
                            // '{%branch_address%}'  => $branch['address'] . ', ' . $branch['city'] . ', ' . $branch['state'] . ', ' . $branch['postcode'] . ', ' . $branch['country'],
                            // '{%branch_email%}'  => $branch['email'],
                            // '{%branch_phone%}'  => $branch['mobile'],
                            '{%view_link%}'  => $url,
                        );
                    } else
                    $a_replace = array(
                        '{%name%}' => $enquiry['name'],
                        '{%email%}' => $enquiry['email'],
                        '{%phone%}' => $enquiry['mobile'],
                        '{%subject%}' => $enquiry['subject'],
                        '{%message%}' => $enquiry['message'],
                        '{%enquiry_type%}' => $enquiryTitle,
                        '{%view_link%}'  => $url,
                    );

                    $this->sendEmail($branch['email'], false, 'branch.contactus_enquiry', $b_replace);

                    $this->sendEmail($this->g_configs['general']['txt.admin_email'], false, 'admin.contactus_enquiry', $a_replace);
                } else {*/
                $a_replace = array(
                    '{%name%}' => $enquiry['name'],
                    '{%email%}' => $enquiry['email'],
                    '{%phone%}' => $enquiry['mobile'],
                    '{%subject%}' => $enquiry['subject'],
                    '{%message%}' => $enquiry['message'],
                    '{%enquiry_type%}' => $enquiryTitle,
                    '{%view_link%}'  => $url,
                );

                $this->sendEmail($this->g_configs['general']['txt.admin_email'], false, 'admin.contactus_enquiry', $a_replace);
                // }
                $to = $enquiry['email'];
                $from = '';

                // $url = Router::url('/user/reset-password/' . $hashed_value, true);
                $u_replace = array(
                    '{%name%}' => $enquiry['name'],
                    '{%email%}' => $enquiry['email'],
                    '{%phone%}' => $enquiry['mobile'],
                    '{%subject%}' => $enquiry['subject'],
                    '{%message%}' => $enquiry['message'],
                    '{%enquiry_type%}' => $enquiryTitle
                );

                $email_template = 'user.contactus_thankyou_enquiry';
                // dd($this->Enquiries->enquiryTypes[$enquiry['type']]['email_template']);
                if (isset($this->Enquiries->enquiryTypes[$enquiry['type']]['email_template'])) {
                    $email_template = $this->Enquiries->enquiryTypes[$enquiry['type']]['email_template'];
                    // dd($email_template);
                    $u_replace = [];
                    $dataFields = $this->Enquiries->enquiryTypes[$enquiry['type']]['fields'];

                    foreach ($dataFields as $field => $fieldTitle) {
                        $enquiry[$field] = ($field == 'mobile') ? (!empty($enquiry['mobile_code']) ? '(+' . $enquiry['mobile_code'] . ') ' . $enquiry[$field] : "\t" . $enquiry[$field]) : $enquiry[$field];
                        $enquiry[$field] = ($field == 'subject_area_id' && isset($enquiry['subject_area']['title'])) ? $enquiry['subject_area']['title'] : $enquiry[$field];
                        $enquiry[$field] = ($field == 'destination_id' && isset($enquiry['country']['country_name'])) ? $enquiry['country']['country_name'] : $enquiry[$field];
                        $enquiry[$field] = ($field == 'fair_venue' && isset($fairVenues[$enquiry['fair_venue']])) ? $fairVenues[$enquiry['fair_venue']] : $enquiry[$field];
                        if ($enquiry['type'] == 'book-appointment') {
                            $enquiry[$field] = ($field == 'study_level' && isset($interestedStudyLevels[$enquiry[$field]])) ? $interestedStudyLevels[$enquiry[$field]] : $enquiry[$field];
                        } else if ($enquiry['type'] == 'visitors-application') {
                            $enquiry[$field] = ($field == 'study_level' && isset($mainStudyLevels[$enquiry[$field]])) ? $mainStudyLevels[$enquiry[$field]] : $enquiry[$field];
                        }

                        $fieldName = str_replace('_id', '', $field);
                        $u_replace['{%' . $fieldName . '%}'] = $enquiry[$field];
                    }
                }

                $this->sendEmail($to, false, $email_template, $u_replace);
                // 
                $return['message'] = __('The Enquiry has been saved.');

                if ($this->request->is('ajax')) {
                    die(json_encode($return));
                } else {
                    $this->Flash->success(__('The Enquiry has been saved.'));
                }

                // return $this->redirect(['action' => 'contact-us']);
            } else {


                if ($this->request->is('ajax')) {

                    $return['message'] = __('The Enquiry could not be sent. Please, try again.');
                    die(json_encode($return));
                } else {
                    $this->Flash->error(__('The Enquiry could not be sent. Please, try again.'));
                }
            }

            if ($enquiry->type == 'career_apply' && $enquiry->career_id)
                $enquiry_redirect_url = $enquiry_redirect_url . '/' . $enquiry->career_id;


            $this->__redirectToType($enquiry_redirect_url);


            // dd($enquiry);
        }
        $this->set(compact('enquiry'));

        $book_free_meeting = $this->getSnippet('book_free_meeting');

        $this->set('book_free_meeting', $book_free_meeting);


        $branches = $this->Branches->find()->where(['active' => 1])
            ->cache('contactus_branches')
            ->order(['display_order' => 'ASC'])->all()->toArray();
        $countries = Hash::combine($branches, '{n}.country', '{n}.country');
        $branchesList = Hash::combine($branches, '{n}.name', '{n}.name', '{n}.country');
        $branches = Hash::combine($branches, '{n}.name', '{n}');
        $this->set(compact('countries', 'branchesList', 'branches'));
    }



    private function __redirectToType($type = 'contact-us')
    {

        switch ($type) {
            case 'home':
                return $this->redirect('/');
                // case 'app-support':
                //         return $this->redirect('/');
                //     case 'partnership-with-besa':
                //         return $this->redirect('/');
            default:
                return $this->redirect('/' . $type);
        }
    }

    public function visitorsApplication()
    {

        $this->set('bodyClass', '');

        $this->loadModel('StudyLevels');
        // $studyLevels = $this->StudyLevels->find('list', [
        //     'keyField' => 'id', 'valueField' => 'title'
        // ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('mainStudyLevels', $this->StudyLevels->mainStudyLevels);

        // $this->loadModel('Countries');
        // $countriesCodesList = $this->Countries->find()->select([
        //     'code', 'phone_code'
        // ])->where(['active' => 1])->order(['phone_code' => 'asc']);

        // $countriesCodesList = Hash::combine(
        //     $countriesCodesList->toArray(),
        //     '{n}.phone_code',
        //     ['+%s', '{n}.phone_code']
        // );


        // $this->set('countriesCodesList', $countriesCodesList);


        $this->loadModel('Countries');


        $destinations = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1, 'is_destination' => 1])->cache('book_appointment_destinations')->order(['country_name' => 'asc']);

        $this->set('destinationsList', $destinations);

        $visitors_application_top_text = $this->getSnippet('visitors_application_top_text');

        $this->set('visitorsApplicationToText', $visitors_application_top_text);

        $this->set('fairVenues', $this->Enquiries->fairVenues);

        if (isset($_GET['location']) && isset($this->Enquiries->fairVenuesTitles[strtolower($_GET['location'])]))
            $this->set('selected_fair_venue', $this->Enquiries->fairVenuesTitles[strtolower($_GET['location'])]);
    }

    public function educationalInstitution()
    {

        $this->set('bodyClass', '');

        $this->loadModel('StudyLevels');

        $this->set('mainStudyLevels', $this->StudyLevels->mainStudyLevels);
    }
    public function britishTrophySubscription()
    {

        $this->set('bodyClass', '');

        $this->loadModel('StudyLevels');
        // $studyLevels = $this->StudyLevels->find('list', [
        //     'keyField' => 'id', 'valueField' => 'title'
        // ])->where(['active' => 1])->order(['title' => 'asc'])->toArray();
        $this->set('mainStudyLevels', $this->StudyLevels->mainStudyLevels);
    }
    public function bookAppointment()
    {

        $this->set('bodyClass', '');

        $this->loadModel('StudyLevels');
        $this->loadModel('SubjectAreas');
        $this->loadModel('Countries');


        $destinations = $this->Countries->find('list', [
            'keyField' => 'id', 'valueField' => 'country_name'
        ])->where(['active' => 1, 'is_destination' => 1])->cache('book_appointment_destinations')->order(['country_name' => 'asc']);

        $subjectAreas = $this->SubjectAreas->find('list', [
            'keyField' => 'id', 'valueField' => 'title'
        ])->where(['active' => 1])->cache('book_appointment_subjectareas')->order(['title' => 'asc']);

        $this->set('interestedStudyLevels', $this->Enquiries->interestedStudyLevels);
        $this->set('destinationsList', $destinations);
        $this->set('subjectAreasList', $subjectAreas);

        $book_appointment = $this->getSnippet('book_appointment_top_text');

        $this->set('bookAppointmentSnippet', $book_appointment);
    }
}
