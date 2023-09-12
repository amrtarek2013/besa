<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class EventsController extends AppController
{

    public function index()
    {
        $this->set('bodyClass', 'pageAbout pageServices');

        $events = $this->Events->find()->where(['active' => 1])->contain(['EventImages'])->order(['display_order' => 'asc'])->limit(3)->all();
        // debug($events);

        $events_page_text = $this->getSnippet('events_page_text');
        $this->set('events', $events);
        $this->set('events_page_text', $events_page_text);
    }

    public function eventDetails($id = null)
    {
        $event = $this->Events->findByPermalink($id)->first();

        $this->set('bodyClass', 'pageAbout pageServices');

        if (empty($event))

            throw new NotFoundException(__('Not found'));

        $this->set('event', $event);
        $this->set('permalink', $id);



        $this->loadModel('EventImages');
        $eventImages = $this->EventImages->find()->where(["active" => 1, "event_id" => $event['id']])->order(['display_order' => 'ASC'])->all()->toArray();
        // debug($eventImages);
        $this->set('eventImages', $eventImages);
    }
    public function schoolTours($id = 'school-tours')
    {
        $event = $this->Events->findByPermalink($id)->first();

        $this->set('bodyClass', 'pageAbout pageServices');

        if (empty($event))

            throw new NotFoundException(__('Not found'));

        $this->set('event', $event);
        $this->set('permalink', $id);



        $this->loadModel('EventImages');
        $eventImages = $this->EventImages->find()->where(["active" => 1, "event_id" => $event['id']])->order(['display_order' => 'ASC'])->all()->toArray();
        // debug($eventImages);
        $this->set('eventImages', $eventImages);
    }
}
