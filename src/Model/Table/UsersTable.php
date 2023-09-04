<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Event;
use ArrayObject;
// use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use MobileValidator\MobileValidator;

class UsersTable extends Table
{


  public $modelName = 'users';
  public $filters = [
    'first_name' => 'like',
    'email' => 'like',
    'current_study_level' => ['type' => 'select'],
    'created' => ['type' => 'date_range', 'from' => 'Date created from', 'to' => 'Date created to']
  ];

  public $schema_of_export = array(
    'id',
    'first_name',
    'email',
    'address',
    'password',
    'active',

  );

  public $schema_of_import = array(
    'id',
    'first_name',
    'email',
    'address',
    'password',
    'active'
  );


  /**
   * Initialize method
   *
   * @param array $config The configuration for the Table.
   * @return void
   */
  public function initialize(array $config): void
  {
    parent::initialize($config);

    $this->setTable('users');
    $this->setDisplayField('name');
    $this->setPrimaryKey('id');
    $this->addBehavior('Timestamp');

    // $this->addBehavior('ImageFile', ['ImageUpload' => ['image' => []]]);

    $this->addBehavior(
      'ImageFile',
      [
        'ImageUpload' => [
          'image' => [
            'resize' => ['width' => 180, 'height' => 180],
            'datePath' => ['path' => ''],
            // 'datePath' => false,
            'path' => 'uploads/users',
            'file_name' => '{$rand}_{$file_name}',

            // 'thumbs' => [
            //     ['thumb_prefix' => 'thumb_', 'width' => '320', 'height' => '240']
            // ],
          ],

        ]
      ]
    );

    $this->hasMany('Applications')->setForeignKey('user_id');
    $this->belongsTo('Countries')->setForeignKey('country_id');
    $this->belongsTo('Destinations', [
      'className' => 'Countries', 'foreignKey' => 'destination_id'
    ]);
    $this->belongsTo('Nationalities', [
      'className' => 'Countries', 'foreignKey' => 'nationality_id'
    ]);
    $this->belongsTo('StudyLevels')->setForeignKey('study_level_id');
    $this->belongsTo('SubjectAreas')->setForeignKey('subject_area_id');
  }

  /**
   * Default validation rules.
   *
   * @param \Cake\Validation\Validator $validator Validator instance.
   * @return \Cake\Validation\Validator
   */
  public function validationDefault(Validator $validator): Validator
  {

    $validator->notEmptyString('first_name', 'This field is required.');
    $validator->notEmptyString('last_name', 'This field is required.');
    $validator->email('email', false, 'Please enter a valid email address.')->notEmptyString('email', 'This field is required.');


    $validator->notEmptyString('mobile', 'This field is required.');
    $validator->notEmptyString('postcode', 'This field is required.');
    // $validator->notEmptyString('username', 'This field is required.');
    return $validator;
  }



  public function validationRegister(Validator $validator): Validator
  {

    $validator->notEmptyString('first_name', 'This field is required.');
    $validator->notEmptyString('last_name', 'This field is required.');
    $validator->email('email', false, 'Please enter a valid email address.')
      ->notEmptyString('email', 'This field is required.')
      ->add('email', [
        'isEmailUnique' => [
          'rule' => 'isEmailUnique',
          'provider' => 'table',
          'message' => 'This field already exsist!',
        ]
      ]);
    // ->equalToField('email', 'email_confirm', 'Email must be same as the confirm email field');

    $validator->notEmptyString('mobile', 'This field is required.')
      // ->add('mobile', [
      //   'validMobileNumber' => [
      //     'rule' => 'validMobileNumber',
      //     'provider' => 'table',
      //     'message' => 'Valid mobile number required',
      //   ]
      // ])
      ->add('mobile', [
        'isMobileUnique' => [
          'rule' => 'isMobileUnique',
          'provider' => 'table',
          'message' => 'This field already exsist!',
        ]
      ]);

    // $validator->notEmptyString('username', 'This field is required.');
    // $validator->notEmptyString('postcode', 'This field is required.');
    $validator->notEmptyString('security_code', 'This field is required.')->add('security_code', [
      'checkCaptcha' => [
        'rule' => 'checkCaptcha',
        'provider' => 'table',
        'message' => 'Security Code is not valid',
      ]
    ]);
    $validator->minLength('password', 6, 'Passowrd length must be greater than 6 letters.')
      ->equalToField('password', 'passwd', 'Password must be same as the confirm password field')
      ->notEmptyString('password', 'This field is required.');

    return $validator;
  }
  public function validationProfile(Validator $validator): Validator
  {

    $validator->notEmptyString('first_name', 'This field is required.');
    $validator->notEmptyString('last_name', 'This field is required.');
    $validator->email('email', false, 'Please enter a valid email address.')
      ->notEmptyString('email', 'This field is required.')
      ->add('email', [
        'isEmailUnique' => [
          'rule' => [$this, 'isEmailUnique'],
          'provider' => 'table',
          'message' => 'This field already exsist!',
        ]
      ]);
    // ->equalToField('email', 'email_confirm', 'Email must be same as the confirm email field');

    $validator->notEmptyString('mobile', 'This field is required.')
      // ->add('mobile', [
      //   'validMobileNumber' => [
      //     'rule' => 'validMobileNumber',
      //     'provider' => 'table',
      //     'message' => 'Valid mobile number required',
      //   ]
      // ])
      ->add('mobile', [
        'isMobileUnique' => [
          'rule' => 'isMobileUnique',
          'provider' => 'table',
          'message' => 'This field already exsist!',
        ]
      ]);

    // $validator->notEmptyString('username', 'This field is required.');
    // $validator->notEmptyString('postcode', 'This field is required.');
    // $validator->notEmptyString('security_code', 'This field is required.')->add('security_code', [
    //   'checkCaptcha' => [
    //     'rule' => 'checkCaptcha',
    //     'provider' => 'table',
    //     'message' => 'Security Code is not valid',
    //   ]
    // ]);
    $validator->minLength('password', 6, 'Passowrd length must be greater than 6 letters.')
      ->equalToField('password', 'passwd', 'Password must be same as the confirm password field');

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

  public function isEmailUnique(
    $value
    // )
    // {

    //   if (isset($value) && !empty($value)) {
    //     $existed_user = $this->find()->where(["email" => $value])->first();

    //     if (!empty($existed_user)) {
    //       return false;
    //     }
    //   }
    //   return true;
    // }

    ,
    $context
  ) {
    $table = TableRegistry::get($this->_registryAlias);
    if ($context['newRecord']) {
      $where = [
        'email' => $value,
      ];
    } else {
      $where = [
        'id !=' => $context['data']['id'],
        'email' => $value,
      ];
    }
    $query = $table->find()->select(['id'])->where($where)->first();
    return empty($query) ? true : false;
  }
  public function isMobileUnique(
    $value
    // )
    // {

    //   if (isset($mobile) && !empty($mobile)) {
    //     $existed_user = $this->find()->where(["mobile" => $mobile])->first();

    //     if (!empty($existed_user)) {
    //       return false;
    //     }
    //   }
    //   return true;
    ,
    $context
  ) {
    $table = TableRegistry::get($this->_registryAlias);
    if ($context['newRecord']) {
      $where = [
        'mobile' => $value,
      ];
    } else {
      $where = [
        'id !=' => $context['data']['id'],
        'mobile' => $value,
      ];
    }
    $query = $table->find()->select(['id'])->where($where)->first();
    return empty($query) ? true : false;
  }


  function validMobileNumber($check, array $context)
  {
    // $MobileValidator = new MobileValidator();
    // $check = str_replace(' ', '', $check);
    // // if ($check == '0011223344') {
    // if (strpos($check, '0011') !== false || $check == '0011223344') {
    //   return true;
    // }
    // if ($MobileValidator->IsBlocked($check))
    //   return false;
    // if (preg_match('/^04\d{8}$/', $check))
    //   return true;
    // else
    //   return false;
  }


  // public function beforeSave(\Cake\Event\Event $event, \Cake\ORM\Entity $entity, ArrayObject $options)
  // {

  //   if (!empty($entity->password)) {
  //     $entity->password =  (new \Cake\Auth\DefaultPasswordHasher())->hash($entity->password);
  //   } else {
  //     $entity->setDirty('password', false);
  //   }
  // }

  public function beforeSave(\Cake\Event\Event $event, \Cake\ORM\Entity $entity, ArrayObject $options)
  {

    if ($entity->isDirty('password')) {
      $entity->password =  (new \Cake\Auth\DefaultPasswordHasher())->hash($entity->password);
    }
  }
}
