<?php
namespace STDashboard\Controller;

use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\PasswordField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Security\DefaultAdminService;
use SilverStripe\Security\IdentityStore;
use SilverStripe\Security\Member;
use SilverStripe\Security\PasswordEncryptor;
use SilverStripe\Security\Security;
use STDashboard\Model\Student;

class SecurityController extends Controller
{
    private static $url_segment = 'sec';

    private static $allowed_actions = [
        'login',
        'student_login',
        'student_login_register',
        'student_login_pass',
        'create_pw',
        'logout',
        'student_logout',
        'LoginForm',
        'StudentLoginForm',
        'checkEmail',
        'doLogin',
        'CreatePasswordForm',
        'saveStudentPassword',
        'StudentLoginWithPasswordForm',
        'StudentLoginWithRegisterForm',
        'studentLoginWithPass',
        'doStudentFirstTimeLogin',
    ];

    public function session()
    {
        return $this->getRequest()->getSession();
    }


    public function login()
    {
        return $this->customise([
            'Title' => 'Login',
        ])->renderWith('Security');
    }

    public function create_pw()
    {
        return $this->customise([
            'CreatePassword' => true,
            'Title' => 'Login',
        ])->renderWith('Security');
    }

    public function student_login()
    {
        return $this->customise([
            'StLogin' => true,
            'Title' => 'Login',
        ])->renderWith('Security');
    }

    public function student_login_register()
    {
        return $this->customise([
            'LoginWithRegisterNumber' => true,
            'Title' => 'Login',
        ])->renderWith('Security');
    }

    public function student_login_pass()
    {
        return $this->customise([
            'StLoginWithPass' => true,
            'Title' => 'Login',
        ])->renderWith('Security');
    }

    public function LoginForm() {
        $fields = new FieldList(
            TextField::create('Email', 'Email'),
            PasswordField::create('Password', 'Password')
        );
        $actions = new FieldList(
            FormAction::create('doLogin')->setTitle('Login')
        );
        $form = new Form($this, 'LoginForm', $fields, $actions);

        return $form;
    }

    public function StudentLoginForm() {
        $fields = new FieldList(
            TextField::create('Email', 'Email'),
        );
        $actions = new FieldList(
            FormAction::create('checkEmail')->setTitle('Continue')
        );
        $form = new Form($this, 'StudentLoginForm', $fields, $actions);

        return $form;
    }

    public function checkEmail($data, $form)
    {
        $email = $data['Email'];
        $student = Student::get()->filter([
            'Email' => $email
        ])->first();

        if($student) {

            $this->session()->set('TmpStudentEmail', $email);

            if($student->PasswordCreated) {
                $this->redirect('sec/student-login-pass');
            } else {
                $this->redirect('sec/student-login-register');
            }
        } else {
            $this->redirect('welcome');
        }
    }

    public function CreatePasswordForm()
    {
        $fields = new FieldList(
            LiteralField::create('CreatePassword', 'Create Your Password'),
            PasswordField::create('Password', 'Password'),
        );

        $actions = new FieldList(
            FormAction::create('saveStudentPassword')->setTitle('Create Password')
        );

        $form = new Form($this, 'CreatePasswordForm', $fields, $actions);

        return $form;
    }

    public function StudentLoginWithPasswordForm()
    {
        $fields = new FieldList(
            PasswordField::create('Password', 'Password'),
        );
        $actions = new FieldList(
            FormAction::create('studentLoginWithPass')->setTitle('Login')
        );
        $form = new Form($this, 'StudentLoginWithPasswordForm', $fields, $actions);
        return $form;
    }

    public function StudentLoginWithRegisterForm()
    {
        $fields = new FieldList(
            TextField::create('RegistrationNumber', 'Registration Number')
        );
        $actions = new FieldList(
            FormAction::create('doStudentFirstTimeLogin')->setTitle('Login')
        );
        $form = new Form($this, 'StudentLoginWithPasswordForm', $fields, $actions);
        return $form;
    }

    public function studentLoginWithPass($data, $form)
    {
        $email = $this->session()->get('TmpStudentEmail');
        $password = $data['Password'];

        $student = Student::get()->filter([
            'Email' => $email,
            'Password' => $password,
        ])->first();

        if ($student) {
            $this->session()->set('LoggedStudent', $student->ID);
            $this->redirect('portal');
        } else {
            return $this->redirectBack();
        }
    }

    public function saveStudentPassword($data, $form)
    {
        $student = $this->session()->get('TmpStudentID');
        $password = $data['Password'];

        $student = Student::get()->filter([
            'ID' => $student,
        ])->first();

        if ($student) {
            $student->Password = $password;
            $student->PasswordCreated = true;
            $student->write();
            $this->session()->clear('TmpStudentID');
            $this->redirect('sec/student-login-pass');
        } else {
            return $this->redirectBack();
        }
    }

    public function doStudentFirstTimeLogin($data, $form)
    {
        $email = $this->session()->get('TmpStudentEmail');
        $regNumber = $data['RegistrationNumber'];

        $student = Student::get()->filter([
            'Email' => $email,
            'RegistrationNumber' => $regNumber,
        ])->first();

        if ($student) {
            $this->session()->set('TmpStudentID', $student->ID);
            $this->redirect('sec/create-pw');
        } else {
            $form->sessionMessage('Invalid email or password', 'bad');
            return $this->redirectBack();
        }
    }

    public function doLogin($data, $form) {
        $email = $data['Email'];

        $asDefaultAdmin = DefaultAdminService::isDefaultAdmin($email);
        $canLogin = false;
        if($asDefaultAdmin) {
            $member = DefaultAdminService::singleton()->findOrCreateDefaultAdmin();
            $canLogin = true;
        } else {
            $member = Member::get()->filter(array(
                'Email' => $email,
            ))->first();
            if($member) {
                $this->checkPassword($member, $data['Password'], $result);
                $canLogin = true;
            }
        }

        if($canLogin) {
            $identityStore = Injector::inst()->get(IdentityStore::class);
            $identityStore->logIn($member, false, null);
        }

        if ($member) {
            Security::setCurrentUser($member);
            $this->redirect('dashboard');
        } else {
            $form->sessionMessage('Invalid email or password', 'bad');
            return $this->redirectBack();
        }
    }

    public function checkPassword($member, $password, ValidationResult &$result = null)
    {
        $encryptor = PasswordEncryptor::create_for_algorithm($member->PasswordEncryption);
        if (!$encryptor->check($member->Password, $password, $member->Salt, $member)) {
            $result->addError(_t(
                __CLASS__ . '.ERRORWRONGCRED',
                'The provided details don\'t seem to be correct. Please try again.'
            ));
        }

        return $result;
    }

    public function student_logout()
    {
        $this->session()->clear('LoggedStudent');
        return $this->redirect(Director::baseURL().'welcome');
    }

    public function logout()
    {
        if (Security::getCurrentUser()) {
            $request = Injector::inst()->get(HTTPRequest::class);
            $session = $request->getSession();
            if ($session) {
                $session->clearAll();
            }
            Injector::inst()->get(IdentityStore::class)->logOut($this->getRequest());
        }

        return $this->redirect(Director::baseURL().'welcome');
    }


}