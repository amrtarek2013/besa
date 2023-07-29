<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;

class EnquiriesController extends AppController
{

    public function contactUs()
    {
        $this->set('bodyClass', '');
        $this->loadModel('Branches');


        $enquiry = $this->Enquiries->newEmptyEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {

            // debug($this->request->getData());
            $enquiry = $this->Enquiries->patchEntity($enquiry, $this->request->getData(), ['validate' => 'contactUs']);

            // debug($enquiry);
            // die;
            $enquiry_redirect_url = $enquiry['type'];
            if ($this->Enquiries->save($enquiry)) {

                $enquiryTitle = Inflector::humanize($enquiry['type']);
                $a_replace = [];
                $b_replace = [];
                $u_replace = [];
                $url = '<a href="' . Router::url('/admin/enquiries/view/' . $enquiry['id'], true) . '" >View Enquiry</a>';
                if (isset($enquiry['branch_id'])) {
                    $this->loadModel('Branches');
                    $branch = $this->Branches->find()->where(['id' => $enquiry['branch_id']])->first();


                    $b_replace = array(
                        '{%name%}' => $enquiry['name'],
                        '{%email%}' => $enquiry['email'],
                        '{%phone%}' => $enquiry['phone'],
                        '{%subject%}' => $enquiry['subject'],
                        '{%message%}' => $enquiry['message'],
                        '{%enquiry_type%}' => $enquiryTitle,
                    );

                    if (!empty($branch)) {
                        $a_replace = array(
                            '{%name%}' => $enquiry['name'],
                            '{%email%}' => $enquiry['email'],
                            '{%phone%}' => $enquiry['phone'],
                            '{%subject%}' => $enquiry['subject'],
                            '{%message%}' => $enquiry['message'],

                            '{%enquiry_type%}' => $enquiryTitle,
                            // '{%branch_name%}'  => $branch['name'],
                            // '{%branch_address%}'  => $branch['address'] . ', ' . $branch['city'] . ', ' . $branch['state'] . ', ' . $branch['postcode'] . ', ' . $branch['country'],
                            // '{%branch_email%}'  => $branch['email'],
                            // '{%branch_phone%}'  => $branch['phone'],
                            '{%view_link%}'  => $url,
                        );
                    } else
                        $a_replace = array(
                            '{%name%}' => $enquiry['name'],
                            '{%email%}' => $enquiry['email'],
                            '{%phone%}' => $enquiry['phone'],
                            '{%subject%}' => $enquiry['subject'],
                            '{%message%}' => $enquiry['message'],
                            '{%enquiry_type%}' => $enquiryTitle,
                            '{%view_link%}'  => $url,
                        );

                    $this->sendEmail('khaledabdo2012@gmail.com'/*$branch['email']*/, false, 'branch.contactus_enquiry', $b_replace);

                    $this->sendEmail($this->g_configs['general']['txt.admin_email'], false, 'admin.contactus_enquiry', $a_replace);
                } else {
                    $a_replace = array(
                        '{%name%}' => $enquiry['name'],
                        '{%email%}' => $enquiry['email'],
                        '{%phone%}' => $enquiry['phone'],
                        '{%subject%}' => $enquiry['subject'],
                        '{%message%}' => $enquiry['message'],
                        '{%enquiry_type%}' => $enquiryTitle,
                        '{%view_link%}'  => $url,
                    );

                    $this->sendEmail($this->g_configs['general']['txt.admin_email'], false, 'admin.contactus_enquiry', $a_replace);
                }
                $to = $enquiry['email'];
                $from = '';

                // $url = Router::url('/user/reset-password/' . $hashed_value, true);
                $u_replace = array(
                    '{%name%}' => $enquiry['name'],
                    '{%email%}' => $enquiry['email'],
                    '{%phone%}' => $enquiry['phone'],
                    '{%subject%}' => $enquiry['subject'],
                    '{%message%}' => $enquiry['message'],
                    '{%enquiry_type%}' => $enquiryTitle
                );

                $this->sendEmail($to, false, 'user.contactus_thankyou_enquiry', $u_replace);
                $this->Flash->success(__('The Enquiry has been saved.'));
                // return $this->redirect(['action' => 'contact-us']);
            } else {
                // dd($enquiry->getErrors());
                $this->Flash->error(__('The Enquiry could not be sent. Please, try again.'));
            }

            if ($enquiry->type == 'career_apply' && $enquiry->career_id)
                $enquiry_redirect_url = $enquiry_redirect_url . '/' . $enquiry->career_id;


            $this->__redirectToType($enquiry_redirect_url);


            // dd($enquiry);
        }
        $this->set(compact('enquiry'));

        $book_free_meeting = $this->getSnippet('book_free_meeting');

        $this->set('book_free_meeting', $book_free_meeting);


        $branches = $this->Branches->find()->where(['active' => 1])->order(['name' => 'ASC'])->all()->toArray();
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
}
