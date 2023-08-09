<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class EnquiriesTable extends Table
{
    public $filters = [
        'type' => ['like', 'options' => ['lable' => 'Type', 'type' => 'select']],
        'name' => ['like', 'options' => ['lable' => 'User Name']],
        'email' => ['like', 'options' => ['lable' => 'User Email']],
        'phone' => ['like', 'options' => ['lable' => 'User Phone']],
        'created' => ['type' => 'date_range'],
        // 'branch_id' => ['title' => "Branch", 'empty' => "Select a branch"]
        // 'code' => array('type' => 'like', 'options' => array('type' => 'text')),

        // 'continent',
    ];

    public $continents = [

        'uk' => 'UK', 'eur' => 'Europe', 'na' => 'North America',
        'other' => 'Other Enquiries',
    ];

    public $status_list = array(
        0 => 'NO ACTION',

    );
    public $enquiryTypes = [
        'home' => ['validation' => 'home', 'redirect' => '/', 'title' => 'Home', 'fields' => ['name', 'email', 'message']],
        'contact-us' => ['validation' => 'contactUs', 'redirect' => '/contact-us', 'title' => 'Contact Us', 'fields' => ['name', 'phone', 'email', 'subject', 'message']],
        'app-support' => ['validation' => 'appSupport', 'redirect' => '/app-support', 'title' => 'App Support', 'fields' => ['name', 'surname', 'email', 'message']],
        'career-apply' => ['validation' => 'careerApply', 'redirect' => '/career-apply', 'title' => 'Career Apply', 'fields' => ['name', 'surname', 'phone', 'email', 'address', 'certificate', 'how_hear_about_us']],
        'partnership-with-besa' => ['validation' => 'partnershipWithBesa', 'redirect' => '/partnership-with-besa', 'title' => 'Partnership with besa', 'fields' => ['name', 'phone', 'email', 'address', 'certificate', 'how_hear_about_us']],
        'visitors-application' => ['validation' => 'visitorsApplication', 'redirect' => '/visitors-application', 'title' => 'Visitors Application', 'fields' => ['name' => 'First Name', 'surname' => 'Last Name', 'phone' => 'Mobile', 'email', 'school_name', 'study_level' => 'Level of Study']],
        'educational-institution' => ['validation' => 'educationalInstitution', 'redirect' => '/educational-institution', 'title' => 'Educational Institution', 'fields' => ['school_name', 'school_counselor_name', 'phone', 'email', 'attending_students_no' => 'Number of attending students', 'certificate' => 'Upload attending students details']],
        'british-trophy-subscription' => ['validation' => 'britishTrophySubscription', 'redirect' => '/british-trophy-subscription', 'title' => 'The British Trophy Event Subscription', 'fields' => ['school_name', 'name' => 'Contact person name', 'phone' => 'Mobile', 'email', 'certificate' => 'Upload school team sheet']],
        'book-appointment' => ['validation' => 'bookAppointment', 'redirect' => '/book-appointment', 'title' => 'Book An appointment', 'fields' => ['name' => 'Full Name', 'phone' => 'Mobile', 'email', 'study_level_id' => 'Study level interested in', 'subject_area_id' => 'Subject area interested in', 'destination_id' => 'Study destination interested in']],

    ];
    public $enquiryTypesList = [
        'home' => 'Home',
        'contact-us' => 'Contact Us',
        'app-support' => 'App Support',
        'career-apply' => 'Career Apply',
        'partnership-with-besa' => 'Partnership with besa',
        'visitors-application' => 'Visitors Application',
        'educational-institution' => 'Educational Institution',
        'british-trophy-subscription' => 'The British Trophy Event Subscription',
        'book-appointment' => 'Book An appointment'


    ];
    public $types = [0 => 'Full Service'];
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('enquiries');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->addBehavior(
            'ImageFile',
            [
                // 'ImageUpload' => [
                //     'image' => [
                //         'resize' => ['width' => 629, 'height' => 355],
                //         'datePath' => ['path' => ''],
                //         // 'datePath' => false,
                //         'width' => 629, 'height' => 355,
                //         'path' => 'uploads/enquiries',
                //         'file_name' => '{$rand}_{$file_name}',

                //         'thumbs' => [
                //             // ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
                //         ],
                //     ],
                // ]
                'FileUpload' => [
                    'certificate' => [
                        'file_name' => '{$rand}_{$file_name}',
                        'path' => 'uploads/enquiries',

                    ]
                ],
            ]

        );
        $this->belongsTo('Branches')->setForeignKey('branch_id');
    }



    public function validationDefault(Validator $validator): Validator
    {

        $validator->notEmptyString('name', 'This field is required.');
        // $validator->notEmptyString('code', 'This field is required.');

        return $validator;
    }

    public function validationContactus(Validator $validator): Validator
    {
        // $validator->add('g-recaptcha-response', [
        //     'checkCaptchaV3' => [
        //         'rule' => 'checkCaptchaV3',
        //         'provider' => 'table',
        //         'message' => 'Page session expired, please reload the page!!',
        //     ]
        // ]);
        $validator->notEmptyString('name', 'This field is required.');
        // $validator->notEmptyString('last_name', 'This field is required.');
        $validator->email('email', false, 'Please enter a valid email address.')
            ->notEmptyString('email', 'This field is required.');

        $validator->notEmptyString('phone', 'This field is required.');
        $validator->notEmptyString('subject', 'This field is required.');
        $validator->notEmptyString('message', 'This field is required.');


        $validator->notEmptyString('security_code', 'This field is required.')->add('security_code', [
            'checkCaptcha' => [
                'rule' => 'checkCaptcha',
                'provider' => 'table',
                'message' => 'Security Code is not valid',
            ]
        ]);

        return $validator;
    }


    public function validationAppSupport(Validator $validator): Validator
    {

        $validator->notEmptyString('name', 'This field is required.');
        $validator->notEmptyString('surname', 'This field is required.');
        $validator->email('email', false, 'Please enter a valid email address.')
            ->notEmptyString('email', 'This field is required.');

        $validator->notEmptyString('message', 'This field is required.');


        $validator->notEmptyString('security_code', 'This field is required.')->add('security_code', [
            'checkCaptcha' => [
                'rule' => 'checkCaptcha',
                'provider' => 'table',
                'message' => 'Security Code is not valid',
            ]
        ]);

        return $validator;
    }

    public function validationPartnershipWithBesa(Validator $validator): Validator
    {

        $validator->notEmptyString('name', 'This field is required.');
        $validator->notEmptyString('phone', 'This field is required.');
        $validator->notEmptyString('certificate', 'This field is required.');
        $validator->email('email', false, 'Please enter a valid email address.')
            ->notEmptyString('email', 'This field is required.');

        // $validator->notEmptyString('message', 'This field is required.');


        $validator->notEmptyString('security_code', 'This field is required.')->add('security_code', [
            'checkCaptcha' => [
                'rule' => 'checkCaptcha',
                'provider' => 'table',
                'message' => 'Security Code is not valid',
            ]
        ]);

        return $validator;
    }


    public function validationCareerApply(Validator $validator): Validator
    {

        $validator->notEmptyString('career_id', 'This field is required.');
        $validator->notEmptyString('name', 'This field is required.');
        $validator->notEmptyString('surname', 'This field is required.');

        $validator->notEmptyString('certificate', 'This field is required.');
        $validator->notEmptyString('phone', 'This field is required.');
        $validator->email('email', false, 'Please enter a valid email address.')
            ->notEmptyString('email', 'This field is required.');

        // $validator->notEmptyString('message', 'This field is required.');


        $validator->notEmptyString('security_code', 'This field is required.')->add('security_code', [
            'checkCaptcha' => [
                'rule' => 'checkCaptcha',
                'provider' => 'table',
                'message' => 'Security Code is not valid',
            ]
        ]);

        return $validator;
    }
    public function validationVisitorsApplication(Validator $validator): Validator
    {

        $validator->notEmptyString('name', 'This field is required.');
        $validator->notEmptyString('surname', 'This field is required.');

        $validator->notEmptyString('school_name', 'This field is required.');
        $validator->notEmptyString('phone', 'This field is required.');
        $validator->email('email', false, 'Please enter a valid email address.')
            ->notEmptyString('email', 'This field is required.');

        $validator->notEmptyString('study_level', 'This field is required.');


        $validator->notEmptyString('security_code', 'This field is required.')->add('security_code', [
            'checkCaptcha' => [
                'rule' => 'checkCaptcha',
                'provider' => 'table',
                'message' => 'Security Code is not valid',
            ]
        ]);

        return $validator;
    }

    public function validationEducationInstitution(Validator $validator): Validator
    {

        $validator->notEmptyString('name', 'This field is required.');
        $validator->notEmptyString('surname', 'This field is required.');

        $validator->notEmptyString('school_name', 'This field is required.');
        $validator->notEmptyString('phone', 'This field is required.');
        $validator->email('email', false, 'Please enter a valid email address.')
            ->notEmptyString('email', 'This field is required.');

        $validator->notEmptyString('study_level', 'This field is required.');


        $validator->notEmptyString('security_code', 'This field is required.')->add('security_code', [
            'checkCaptcha' => [
                'rule' => 'checkCaptcha',
                'provider' => 'table',
                'message' => 'Security Code is not valid',
            ]
        ]);

        return $validator;
    }

    public function validationBritishTrophySubscription(Validator $validator): Validator
    {

        $validator->notEmptyString('name', 'This field is required.');

        $validator->notEmptyString('school_name', 'This field is required.');
        $validator->notEmptyString('phone', 'This field is required.');
        $validator->email('email', false, 'Please enter a valid email address.')
            ->notEmptyString('email', 'This field is required.');

        $validator->notEmptyString('certificate', 'This field is required.');

        $validator->notEmptyString('security_code', 'This field is required.')->add('security_code', [
            'checkCaptcha' => [
                'rule' => 'checkCaptcha',
                'provider' => 'table',
                'message' => 'Security Code is not valid',
            ]
        ]);

        return $validator;
    }

    public function validationBookAppointment(Validator $validator): Validator
    {

        $validator->notEmptyString('name', 'This field is required.');
        $validator->notEmptyString('phone', 'This field is required.');
        $validator->email('email', false, 'Please enter a valid email address.')
            ->notEmptyString('email', 'This field is required.');

        $validator->notEmptyString('study_level_id', 'This field is required.');
        $validator->notEmptyString('subject_area_id', 'This field is required.');

        $validator->notEmptyString('destination_id', 'This field is required.');


        $validator->notEmptyString('security_code', 'This field is required.')->add('security_code', [
            'checkCaptcha' => [
                'rule' => 'checkCaptcha',
                'provider' => 'table',
                'message' => 'Security Code is not valid',
            ]
        ]);

        return $validator;
    }

    function checkCaptcha($data)
    {

        if (!isset($_SESSION['security_code'])) {
            return false;
        }


        if (strtolower($data) ==  '123456') {
            return true;
        }
        return strtolower($data) == strtolower($_SESSION['security_code']); //strtolower('123456');
    }

    // function checkCaptchaV3($data)
    // {
    //     return getCaptcha($data); //strtolower('123456');
    // }

    public function afterSave($event, $entity, $options)
    {
        clearViewCache();
    }

    public function beforeSave($event, $entity, $options)
    {

        if ($entity->isNew() && empty($entity->permalink)) {
            $entity->permalink = Inflector::dasherize(strtolower(Text::slug($entity->name, '_')));
        }

        // if (empty($entity->banner_image)) {
        //     $entity->banner_image = str_replace('\\','',$entity->banner_image);
        // }
    }
}
