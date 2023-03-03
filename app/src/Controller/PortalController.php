<?php
namespace STDashboard\Controller;

use SilverStripe\Control\Controller;
use SilverStripe\ORM\ArrayList;
use STDashboard\Model\Student;

class PortalController extends Controller
{
    private static $url_segment = 'portal';

    private static $allowed_actions = [

    ];

    //456987

    public function index()
    {
        if($studentID = $this->session()->get('LoggedStudent')) {
            return $this->customise([
                'Site' => 'Hello Student',
                'StudentName' => Student::get()->filter('ID', $studentID)->first()->Name,
                'Subjects' => $this->studentSubjects(),
            ])->renderWith('Portal');
        } else {
            return $this->redirect('sec/student_login_pass');
        }

    }

    public function session()
    {
        return $this->getRequest()->getSession();
    }

    public function studentSubjects()
    {
        $studentID = $this->session()->get('LoggedStudent');
        if($studentID) {
            if($student = Student::get()->filter('ID', $studentID)->first()) {
                $arr = new ArrayList();
                foreach ($student->Subjects() as $subject) {
                    $arr->add([
                        'ID' => $subject->ID,
                        'Name' => $subject->Name,
                        'Marks' => $subject->Marks,
                    ]);
                }
                return $arr;
            }
        }
    }

}