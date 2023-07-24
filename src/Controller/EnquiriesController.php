<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Routing\Router;
use Cake\Utility\Hash;

class EnquiriesController extends AppController
{

    public function contactUs()
    {
        $this->set('bodyClass', '');
        $this->loadModel('Branches');
        $branches = $this->Branches->find()->where(['active' => 1])->order(['display_order' => 'ASC'])->all()->toArray();
        $countries = Hash::combine($branches, '{n}.country', '{n}.country');
        $branchesList = Hash::combine($branches, '{n}.name', '{n}.name', '{n}.country');
        $branches = Hash::combine($branches, '{n}.name', '{n}');
        $this->set(compact('countries', 'branchesList', 'branches'));


        $enquiry = $this->Enquiries->newEmptyEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {

            // debug($this->request->getData());
            $enquiry = $this->Enquiries->patchEntity($enquiry, $this->request->getData(), ['validate' => 'contactUs']);

            // debug($enquiry);
            // die;
            if ($this->Enquiries->save($enquiry)) {

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
                        '{%message%}' => $enquiry['message']
                    );

                    if (!empty($branch)) {
                        $a_replace = array(
                            '{%name%}' => $enquiry['name'],
                            '{%email%}' => $enquiry['email'],
                            '{%phone%}' => $enquiry['phone'],
                            '{%subject%}' => $enquiry['subject'],
                            '{%message%}' => $enquiry['message'],

                            '{%branch_name%}'  => $branch['name'],
                            '{%branch_address%}'  => $branch['address'] . ', ' . $branch['city'] . ', ' . $branch['state'] . ', ' . $branch['postcode'] . ', ' . $branch['country'],
                            '{%branch_email%}'  => $branch['email'],
                            '{%branch_phone%}'  => $branch['phone'],
                            '{%view_link%}'  => $url,
                        );
                    } else
                        $a_replace = array(
                            '{%name%}' => $enquiry['name'],
                            '{%email%}' => $enquiry['email'],
                            '{%phone%}' => $enquiry['phone'],
                            '{%subject%}' => $enquiry['subject'],
                            '{%message%}' => $enquiry['message'],
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
                    '{%message%}' => $enquiry['message']
                );

                $this->sendEmail($to, false, 'user.contactus_thankyou_enquiry', $u_replace);
                $this->Flash->success(__('The Enquiry has been saved.'));
                return $this->redirect(['action' => 'contact-us']);
            } else {
                // dd($enquiry->getErrors());
                $this->Flash->error(__('The Enquiry could not be sent. Please, try again.'));
            }

            $this->__redirectToType($enquiry->type);


            // dd($enquiry);
        }
        $this->set(compact('enquiry'));

        $book_free_meeting = $this->getSnippet('book_free_meeting');

        $this->set('book_free_meeting', $book_free_meeting);
    }

    private function __redirectToType($type = 'contact-us')
    {

        switch ($type) {
            case 'home':
                return $this->redirect('/');
                // default:
                //     return $this->redirect(['action' => 'contactUs']);
        }
    }
}
