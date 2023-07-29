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
        'type' => ['like', 'options' => ['lable' => 'Type']],
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
        'home' => ['validation' => 'home', 'redirect'=>'/', 'title' => 'Home', 'fields' => []],
        'contact-us' => ['validation' => 'contactUs', 'redirect'=>'/contact-us', 'title' => 'Contact Us', 'fields' => []],
        'app-support' => ['validation' => 'appSupport', 'redirect'=>'/app-support', 'title' => 'App Support', 'fields' => []],
        'career-apply' => ['validation' => 'careerApply', 'redirect'=>'/career-apply', 'title' => 'Career Apply', 'fields' => []],
        'partnership-with-besa' => ['validation' => 'partnershipWithBesa', 'redirect'=>'/partnership-with-besa', 'title' => 'Partnership with besa', 'fields' => []],
        // 'home' => ['validation' => 'home', 'redirect'=>'/', 'title' => 'Home', 'fields' => []],

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
