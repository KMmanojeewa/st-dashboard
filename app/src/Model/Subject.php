<?php
namespace STDashboard\Model;

use SilverStripe\ORM\DataObject;

class Subject extends DataObject
{
    private static $table_name = 'Subject';

    private static $db = [
        'Name' => 'Varchar'
    ];

    private static $belongs_many_many = [
        'Students' => Student::class
    ];
}