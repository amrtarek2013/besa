<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class SystemEmail extends Entity
{

    protected $_accessible = [
        '*' => true,

    ];

    public $globalPlaceholders = array(
        '{%site_name%}' => array('label' => 'Site Name', 'value_type' => 'eval', 'value' => "ForkLift"),
    );

    public $templates = array(

        'user.contactus_thankyou_enquiry' => array(
            '{%name%}' => 'Username',
            '{%email%}'  => 'Email',
            '{%phone%}'  => 'Phone',
            '{%subject%}'  => 'Subject',
            '{%message%}'  => 'Message',
            '{%enquiry_type%}' => 'Enquiry Type',
            '{%website_url%}' => 'Website Url'
        ),
        'user.visitors-application-enquiry' => array(
            '{%name%}' => 'First Name',
            '{%surname%}' => 'Last Name',
            '{%mobile%}' => 'Mobile',
            '{%email%}' => 'Email',
            '{%school_name%}' => 'School / University name',
            '{%study_level%}' => 'Level of Study',
            '{%destination_id%}' => 'Destination interested in',
            '{%fair_venue%}' => 'Fair Venue',

            '{%website_url%}' => 'Website Url'
        ),
        'admin.contactus_enquiry' => array(
            '{%name%}' => 'Username',
            '{%email%}'  => 'Email',
            '{%phone%}'  => 'Phone',
            '{%subject%}'  => 'Subject',
            '{%message%}'  => 'Message',
            // '{%branch_name%}'  => 'Branch Name',
            // '{%branch_address%}'  => 'Branch Address',
            // '{%branch_email%}'  => 'Branch Email',
            // '{%branch_phone%}'  => 'Branch Phone',

            '{%enquiry_type%}' => 'Enquiry Type',
            '{%view_link%}' => 'View Link',
        ),

        'branch.contactus_enquiry' => array(
            '{%name%}' => 'Username',
            '{%email%}'  => 'Email',
            '{%phone%}'  => 'Phone',
            '{%subject%}'  => 'Subject',
            '{%message%}'  => 'Message',
            '{%enquiry_type%}' => 'Enquiry Type',
            '{%view_link%}' => 'View Link',
            '{%website_url%}' => 'Website Url'
        ),
        'user.notify_user_registration' => array(
            // '{%username%}' => 'Username',
            '{%first_name%}' => 'First Name',
            '{%last_name%}'  => 'Last Name',
            '{%email%}'  => 'Email',
            '{%mobile%}'  => 'Mobile',
            '{%view_link%}' => 'View Link',
            '{%website_url%}' => 'Website Url'
        ),
        'admin.notify_user_registration' => array(
            '{%username%}' => 'Username',
            '{%first_name%}' => 'First Name',
            '{%last_name%}'  => 'Last Name',
            '{%email%}'  => 'Email',
            '{%mobile%}'  => 'Mobile',
            '{%view_link%}' => 'View Link',
            '{%website_url%}' => 'Website Url'
        ),


        'user.re-confirm-email-address' => array(
            // '{%username%}' => 'Username',
            '{%first_name%}' => 'First Name',
            '{%last_name%}'  => 'Last Name',
            '{%email%}'  => 'Email',
            '{%mobile%}'  => 'Mobile',
            '{%confirmation_url%}' => 'Confirmation URL',
            '{%website_url%}' => 'Website Url'
        ),


        'user.notify_user_reset_password' => array(
            // '{%username%}' => 'Username',
            '{%first_name%}' => 'First Name',
            '{%last_name%}'  => 'Last Name',
            '{%email%}'  => 'Email',
            '{%mobile%}'  => 'Mobile',
            '{%new_password%}' => 'Reset Password URL',
            '{%website_url%}' => 'Website Url'
        ),


        'user.notify_user_new_apply' => array(
            // '{%username%}' => 'Username',
            '{%name%}' => 'Name',
            '{%surname%}'  => 'Surname',
            // '{%email%}'  => 'Email',
            // '{%mobile%}'  => 'Mobile',
            '{%view_link%}' => 'View Link',
            '{%website_url%}' => 'Website Url'
        ),
        'admin.notify_user_new_apply' => array(
            // '{%username%}' => 'Username',
            '{%name%}' => 'Name',
            '{%surname%}'  => 'Surname',
            '{%email%}'  => 'Email',
            '{%mobile%}'  => 'Mobile',
            '{%view_link%}' => 'View Link',
            '{%website_url%}' => 'Website Url'
        ),


        'user.notify_user_app_status' => array(
            // '{%username%}' => 'Username',
            '{%name%}' => 'Name',
            '{%surname%}'  => 'Surname',
            // '{%email%}'  => 'Email',
            // '{%mobile%}'  => 'Mobile',

            '{%status%}'  => 'Application Status',
            '{%status_text%}'  => 'Status Message',
            '{%status_time%}'  => 'status_time',
            '{%view_link%}' => 'View Link',
            '{%website_url%}' => 'Website Url'
        ),
        'admin.notify_user_app_updated' => array(
            // '{%username%}' => 'Username',
            '{%name%}' => 'Name',
            '{%surname%}'  => 'Surname',
            '{%email%}'  => 'Email',
            '{%mobile%}'  => 'Mobile',
            '{%view_link%}' => 'View Link',
            '{%website_url%}' => 'Website Url'
        ),


        // 'presenter.notify_presenter_registration' => array(
        //     '{%username%}' => 'Username',
        //     '{%first_name%}' => 'First Name',
        //     '{%last_name%}'  => 'Last Name',
        //     '{%email%}'  => 'Email',
        //     '{%mobile%}'  => 'Mobile',
        //     '{%view_link%}' => 'View Link',
        // '{%website_url%}' => 'Website Url'
        // ),
        // 'admin.notify_presenter_registration' => array(
        //     '{%username%}' => 'Username',
        //     '{%session_name%}' => 'Session Name',
        //     '{%user_email%}'  => 'Email',
        //     '{%mobile%}'  => 'Mobile',
        //     '{%order_id%}' => 'Order #',
        //     '{%view_link%}' => 'View Link',
        //     '{%invoice_link%}' => 'Invoice Link',
        // ),




        // 'subscription.user_order_notify' => array(

        //     '{%username%}' => 'Username',
        //     '{%plan_name%}' => 'Plan Title',
        //     '{%user_email%}'  => 'Email',
        //     '{%mobile%}'  => 'Mobile',
        //     '{%order_id%}' => 'Order #',
        //     '{%view_link%}' => 'View Link',
        //     '{%invoice_link%}' => 'Invoice Link',
        // ),
        // 'subscription.admin_order_notify' => array(

        //     '{%username%}' => 'Username',
        //     '{%plan_name%}' => 'Plan Title',
        //     '{%user_email%}'  => 'Email',
        //     '{%mobile%}'  => 'Mobile',
        //     '{%order_id%}' => 'Order #',
        //     '{%view_link%}' => 'View Link',
        //     '{%invoice_link%}' => 'Invoice Link',
        // ),


        // 'buy_ticket.user_order_notify' => array(

        //     '{%username%}' => 'Username',
        //     '{%session_name%}' => 'Session Name',
        //     '{%user_email%}'  => 'Email',
        //     '{%mobile%}'  => 'Mobile',
        //     '{%order_id%}' => 'Order #',
        //     '{%view_link%}' => 'View Link',
        //     '{%invoice_link%}' => 'Invoice Link',
        // ),
        // 'buy_ticket.admin_order_notify' => array(

        //     '{%username%}' => 'Username',
        //     '{%session_name%}' => 'Session Name',
        //     '{%user_email%}'  => 'Email',
        //     '{%mobile%}'  => 'Mobile',
        //     '{%order_id%}' => 'Order #',
        //     '{%view_link%}' => 'View Link',
        //     '{%invoice_link%}' => 'Invoice Link',
        // ),
        // 'buy_ticket.presenter_order_notify' => array(

        //     '{%username%}' => 'Username',
        //     '{%session_name%}' => 'Session Name',
        //     '{%user_email%}'  => 'Email',
        //     '{%mobile%}'  => 'Mobile',
        //     '{%order_id%}' => 'Order #',
        //     '{%view_link%}' => 'View Link',
        //     '{%invoice_link%}' => 'Invoice Link',
        // ),




        // 'shop_products.user_order_notify' => array(

        //     '{%username%}' => 'Username',
        //     // '{%product_name%}' => 'Product Name',
        //     '{%user_email%}'  => 'Email',
        //     '{%mobile%}'  => 'Mobile',
        //     '{%order_id%}' => 'Order #',
        //     '{%view_link%}' => 'View Link',
        //     '{%invoice_link%}' => 'Invoice Link',
        // ),
        // 'shop_products.admin_order_notify' => array(

        //     '{%username%}' => 'Username',
        //     // '{%product_name%}' => 'Product Name',
        //     '{%user_email%}'  => 'Email',
        //     '{%mobile%}'  => 'Mobile',
        //     '{%order_id%}' => 'Order #',
        //     '{%view_link%}' => 'View Link',
        //     '{%invoice_link%}' => 'Invoice Link',
        // ),

    );
}
