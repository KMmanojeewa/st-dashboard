<?php
namespace STDashboard\Model;

use SilverStripe\ORM\DataObject;

class Student extends DataObject
{
    private static $table_name = 'Student';

    private static $db = [
        'Name' => 'Varchar',
        'Email' => 'Varchar',
        'RegistrationNumber' => 'Varchar',
        'Password' => 'Varchar',
        'PasswordCreated' => 'Boolean',
    ];

    private static $many_many = [
        'Subjects' => Subject::class
    ];

    private static $many_many_extraFields = [
        'Subjects' => [
            'Marks' => 'Varchar'
        ]
    ];

}