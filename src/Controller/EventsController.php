<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Hash;

class EventsController extends AppController
{

    public function index()
    {
        $this->set('bodyClass', 'pageAbout pageServices');

        $events = $this->Events->find()->contain(['EventImages'])->order(['display_order' => 'asc'])->limit(3)->all();
        // debug($events);

        $events_page_text = $this->getSnippet('events_page_text');
        $this->set('eventsList', $events);
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
    public function schoolTour($id = 'school-tours')
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

        //Load Schools slider

        $this->loadModel('Schools');
        $schoolImages = $this->Schools->find()->contain(['SchoolImages' => ['fields' => ['image', 'title','school_id']]])->where(["Schools.active" => 1])->all()->toArray();

        $highlighted = $this->Schools->find()->where(["Schools.highlighted" => 1,"Schools.active" => 1])->first();

        // $schoolImages = Hash::combine($schoolImages, '{n}.id', '{n}', '{n}.name');
        // dd($schoolImages);
        $this->set('schools', $schoolImages);
        $this->set('highlighted', $highlighted);

        $this->set('requestSchoolTourAppointmentSnippet', $this->getSnippet('book_appointment_request_school_tour'));
    }
}
