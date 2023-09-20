<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CounselorInvoicesTable extends Table
{


    public $filters = [];

    public $paymentMethods = [
        1 => 'Bank Account',
        2 => 'Instapay',
        3 => 'Mobile Wallet'
    ];
    public $paymentMethodFields = [
        1 => ['bank_name' => 'Bank Name', 'bank_account' => 'Bank Account Number'],
        2 => ['instapay' => 'Instapay Account'],
        3 => ['wallet_mobile' => 'Mobile Wallet']
    ];
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('counselor_invoices');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');


        $this->belongsTo('Counselors')->setForeignKey('counselor_id');

        $this->hasMany('CounselorRewards')->setForeignKey('invoice_id');
    }



    public function validationDefault(Validator $validator): Validator
    {

        return $validator;
    }
}
