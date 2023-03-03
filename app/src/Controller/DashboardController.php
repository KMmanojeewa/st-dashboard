<?php
namespace STDashboard\Controller;

use SilverStripe\Control\Controller;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\PasswordField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;
use STDashboard\Model\Student;
use STDashboard\Model\Subject;

class DashboardController extends Controller
{
    private static $url_segment = 'dashboard';

    private static $allowed_actions = [
        'createUser',
        'UserForm',
        'users',
        'student',
        'students',
        'allStudents',
        'StudentForm',
        'subjects',
        'SubjectForm',
        'createSubject',
        'allSubjects',
        'MarksForm',
        'addStudentSubjectMark',
    ];


    public function index()
    {
        if (!Security::getCurrentUser()) {
            return $this->redirect('sec/login');
        }
        $user = Security::getCurrentUser();
        return $this->customise([
            'UserName' => $user->FirstName,
        ])->renderWith('Dashboard');
    }

    public function authenticate()
    {
        if (!Security::getCurrentUser()) {
            return $this->redirect('sec/login');
        } else {
            return true;
        }
    }

    public function UserForm() {
        $fields = new FieldList(
            TextField::create('Name', 'Name'),
            TextField::create('Email', 'Email'),
            PasswordField::create('Password', 'Password')
        );

        $actions = new FieldList(
            FormAction::create('createUser')->setTitle('Create User')
        );

        $form = new Form($this, 'UserForm', $fields, $actions);

        return $form;
    }

    public function createUser($data, $form) {
        $name = $data['Name'];
        $email = $data['Email'];
        $password = $data['Password'];

        $member = Member::create([
            'FirstName' => $name,
            'Email' => $email,
            'Password' => $password
        ]);
        $member->write();
    }

    public function users()
    {
        if($this->authenticate()) {
            return $this->customise([
                'UsersData' => true,
                'AllUsers' => $this->allUsers(),
                'Users' => $this->renderWith(array('Users'))
            ])->renderWith('Dashboard');
        }

    }

    public function allUsers()
    {
        $students = Member::get();
        $fieldNames = new ArrayList();
        foreach ($students as $student) {
            $fieldNames->add([
                'ID' => $student->ID,
                'Name' => $student->FirstName,
                'Email' => $student->Email,
            ]);
        }
        return $fieldNames;
    }

    public function session()
    {
        return $this->getRequest()->getSession();
    }

    public function student()
    {
        if($this->authenticate()) {
            $request = $this->getRequest();
            if($id = $request->getVar('id')) {
                $this->session()->set('StudentID', $id);
                return $this->customise([
                    'OneStudent' => true,
                    'Student' => $this->viewStudent($id),
                    'StudentSubjects' => $this->viewStudentSubjects($id),
                ])->renderWith('Dashboard');
            }
        }
    }

    public function students()
    {
        if($this->authenticate()) {
            return $this->customise([
                'StudentData' => true,
                'AllStudents' => $this->allStudents(),
                'Students' => $this->renderWith(array('Students'))
            ])->renderWith('Dashboard');
        }
    }

    public function StudentForm() {
        $subjects = $this->allSubjectsArr();
        $fields = new FieldList(
            TextField::create('Name', 'Name'),
            TextField::create('Email', 'Email'),
            TextField::create('RegistrationNumber', 'Registration Number'),
            ListboxField::create(
                'Subjects',
                'Subjects',
                $subjects
            )
        );
        $actions = new FieldList(
            FormAction::create('createStudent')->setTitle('Create Student')
        );
        $form = new Form($this, 'StudentForm', $fields, $actions);
        return $form;

    }

    public function createStudent($data, $form) {
        $name = $data['Name'];
        $email = $data['Email'];
        $reg = $data['RegistrationNumber'];
        $subjects = $data['Subjects'];

        $student = Student::create([
            'Name' => $name,
            'Email' => $email,
            'RegistrationNumber' => $reg
        ]);
        $student->write();
        foreach ($subjects as $subject) {
            $student->Subjects()->add($subject);
        }

        $this->redirectBack();
    }

    public function allStudents()
    {
        $students = Student::get();
        $fieldNames = new ArrayList();
        foreach ($students as $student) {
            $fieldNames->add([
                'ID' => $student->ID,
                'RegistrationNumber' => $student->RegistrationNumber,
                'Name' => $student->Name,
                'Email' => $student->Email,
            ]);
        }
        return $fieldNames;
    }

    public function viewStudent($id)
    {
        if($student = Student::get()->filter('ID', $id)->first()) {

            $fieldNames = [
                'ID' => $student->ID,
                'Name' => $student->Name,
                'Email' => $student->Email,
            ];
            return $fieldNames;
        }


    }

    public function viewStudentSubjects($id)
    {
        if($student = Student::get()->filter('ID', $id)->first()) {

            $fieldNames = new ArrayList();
            foreach ($student->Subjects() as $subject) {
                $fieldNames->add([
                    'ID' => $subject->ID,
                    'Name' => $subject->Name,
                    'Marks' => $subject->Marks,
                ]);
            }
            return $fieldNames;
        }


    }

    public function subjects()
    {
        if($this->authenticate()) {
            return $this->customise([
                'SubjectData' => true,
                'AllSubjects' => $this->allSubjects(),
                'Subjects' => $this->renderWith(array('Subjects'))
            ])->renderWith('Dashboard');
        }
    }

    public function SubjectForm() {
        $fields = new FieldList(
            TextField::create('Name', 'Name')
        );
        $actions = new FieldList(
            FormAction::create('createSubject')->setTitle('Create Subject')
        );
        $form = new Form($this, 'SubjectForm', $fields, $actions);
        return $form;

    }

    public function createSubject($data, $form) {
        $name = $data['Name'];

        $subject = Subject::create([
            'Name' => $name
        ]);
        $subject->write();
        $this->redirectBack();
    }

    public function allSubjects()
    {
        $subjects = Subject::get();
        $fieldNames = new ArrayList();
        foreach ($subjects as $subject) {
            $fieldNames->add([
                'ID' => $subject->ID,
                'Name' => $subject->Name,
            ]);
        }
        return $fieldNames;
    }

    public function allSubjectsArr()
    {
        $subjects = Subject::get()->map('ID', 'Name')->toArray();
        return $subjects;
    }

    public function MarksForm()
    {
        $subjects = [];
        $id = $this->session()->get('StudentID');

        if($id) {
            $stSubjects = Student::get()->filter('ID', $id)->first()->Subjects();
            if($stSubjects->count()) {
                $subjects = $stSubjects->map('ID', 'Name')->toArray();
            }
        }

        $fields = new FieldList(
            DropdownField::create(
                'Subject',
                'Subject',
                $subjects
            ),
            TextField::create('Mark', 'Mark'),
            HiddenField::create('Student', null, $id),
        );
        $actions = new FieldList(
            FormAction::create('addStudentSubjectMark')->setTitle('Add Mark')
        );
        $form = new Form($this, 'MarksForm', $fields, $actions);
        return $form;


    }

    public function addStudentSubjectMark($data, $form)
    {
        $subject = $data['Subject'];
        $mark = $data['Mark'];
        $student = $data['Student'];
        $student = Student::get()->filter('ID', $student)->first();

        if($student) {
            $student->Subjects()->add($subject,["Marks" => $mark]);
        }
        $this->redirectBack();
    }

}