<?php

declare(strict_types=1);

namespace App\Controller;

class NewslettersController extends AppController
{

    public function subscribe()
    {


        $message = __('Your email not found. Please, try again.');
        $status = 'error';
        $newsletter = $this->Newsletters->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if (isset($data['email'])) {
                $newsletter = $this->Newsletters->find()->where(['email' => $data['email']])->first();
            }

            if (empty($newsletter)) {

                if (isset($_SESSION['Auth']['User'])) {
                    $user = $_SESSION['Auth']['User'];
                    $data['user_id'] = $user['id'];
                } else
                    $data['user_token'] = $this->userToken();

                $data['subscribed'] = 1;
                // debug($data);
                // dd($newsletter);
                $newsletter = $this->Newsletters->newEmptyEntity();
                $newsletter = $this->Newsletters->patchEntity($newsletter, $data);
                // $newsletter->email = $data['email'];
                // $newsletter->subscribed = 1;
                // dd($newsletter);
                if ($this->Newsletters->save($newsletter)) {
                    $this->sendToBitrix($newsletter, 'newsletter');
                    $message = __('Your email subscribed to Newsletter Successfully.');
                    $status = 'success';
                } else {
                    $message = __('Your email could not be added to Newsletter. Please, try again.');
                }
            } else {

                // if (isset($_SESSION['Auth']['User'])) {
                //     $user = $_SESSION['Auth']['User'];
                //     $newsletter->user_id = $user['id'];
                // } else
                //     $newsletter->user_token = $this->userToken();

                $newsletter->subscribed = 0;
                if ($this->Newsletters->save($newsletter)) {

                    $message = __('Your email unsubscribed from Newsletter Successfully.');
                }
                $status = 'deleted';
            }


            if ($this->request->is('ajax')) {
                die(json_encode(['status' => $status, 'message' => $message]));
            } else {
                $this->redirect($this->referer(array('action' => 'index'), true));
            }
        }
    }
}
