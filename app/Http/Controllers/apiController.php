<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Egulias\EmailValidator\Validation\NoRFCWarningsValidation;
use Egulias\EmailValidator\Validation\MessageIDValidation;



class apiController extends Controller
{

    public function index(Request $request)
    {
        /*
            Все API запросы идут к этому методу
            Здесь определяется к какому методу нужно обратиться дальше
            Если полученного метода нет, возвращается ошибка
            Возврат всегда в JSON формате
        */
        return match ($request->input('mode')) {
            'test'              => $this->test(),
            'all_users'         => $this->getAllUsers(),
            'username_exists'   => $this->username_exists($request->input('query')),
            'pass_requirements' => $this->check_password_requirements($request->input('query')),
            'create_user'       => $this->create_user($request),
            'email_exists'      => $this->email_exists($request->input('email')),
            default             => $this->unknownMethod()
        };
    }

    public function test()
    {
        return response()->json(['test' => true]);
    }


    private function prepairing_create_user($username, $email, $password): array
    {
        $errors = [];
        $status = false;

        if (is_null($username) or is_null($password) or is_null($email)) {
            $errors[] = "Заполните все поля";
        }

        if (count($errors) > 0) {
            return ['errors' => $errors, 'status' => $status];
        }

        if (strlen($username) < 3) {
            $errors[] = "Минимальная длина никнейма - 3";
        }

        if (!$this->getValueFromJsonObject($this->email_validation($email), 'check')) {
            $errors[] = "Некорректный email";
        }
        

        $password_requires_response = $this->check_password_requirements($password);
        $password_requires = json_decode($password_requires_response->getContent(), true);
        foreach ($password_requires['errors'] as $err)
        {
            $errors[] = $err;
        }

        // Проверка занято ли имя, true = занято
        $check_username_response = $this->username_exists($username); 
        $check_username = json_decode($check_username_response->getContent(), true);
        
        if ($check_username['status']) {
            $errors[] = $check_username['message'];
        }

        // Проверка занята ли почта, true = занято
        $check_email_response = $this->email_exists($email); 
        $check_email = json_decode($check_email_response->getContent(), true);

        if ($check_email['status']) {
            $errors[] = $check_email['message'];
        }

        return ['errors' => $errors, 'status' => $status];
    }

    public function create_user(Request $request): Object
    {
        $username   = $request->input('username');
        $password   = $request->input('password');
        $email      = $request->input('email');

        // Проверяем все данные на корректность
        $response = $this->prepairing_create_user($username, $email, $password);
        $errors = $response['errors'];
        
        
        if (count($errors) > 0) {
            return response()->json(['status' => false, 'errors' => $errors]);
        }

        $user = User::create(['name' => $username, 'password' => $password, 'email' => $email]);
        return response()->json(['status' => true, "user" => $user, 'errors' => []]);
    }
    
    private function username_exists($query): Object
    { 
        if (is_null($query)) {return $this->unknownMethod();}
        $userexists = User::where('name', $query) -> first();
        $status = !is_null($userexists) ? true : false;
        $message = !is_null($userexists) ? "Данное имя уже занято" : "";
        return response()->json(['status' => $status, 'message' => $message]); 
    }

    private function email_exists($query): Object
    { 
        if (is_null($query)) {return $this->unknownMethod();}
        $userexists = User::where('email', $query) -> first();
        $status = !is_null($userexists) ? true : false;
        $message = !is_null($userexists) ? "Данный email занят другим пользователем" : "";
        return response()->json(['status' => $status, 'message' => $message]); 
    }


    private function check_password_requirements($password): Object 
    {
        $errors = [];
        $min_length = 6;
        $max_length = 30;

        if (strlen($password) < $min_length || strlen($password) > $max_length ) {
            $errors[] = "Пароль должен быть не менее $min_length символов и не более $max_length символов";
        }
        if (!preg_match("/\d/", $password)) {
            $errors[] = "Пароль должен содержать хотя бы одну цифру";
        }
        if (!preg_match("/[A-Z]/", $password)) {
            $errors[] = "Пароль должен содержать хотя бы одну заглавную букву";
        }
        if (!preg_match("/[a-z]/", $password)) {
            $errors[] = "Пароль должен содержать хотя бы одну строчную букву";
        }
        if (!preg_match("/\W/", $password)) {
            $errors[] = "Пароль должен содержать хотя бы один специальный символ";
        }
        if (preg_match("/\s/", $password)) {
            $errors[] = "Пароль не должен содержать пробелов";
        }
        

        return response()->json(['status' => count($errors) === 0, 'errors' => $errors]); 
    }

    private function unknownMethod(): Object 
    { 
        return response()->json(['message' => 'Unauthorize method'], 400);
    }

    private function getAllUsers(): Object 
    { 
        return response()->json(User::all());
    }

    public function email_validation($email): object 
    { 
        $validator = new EmailValidator();
        $multipleValidations = new MultipleValidationWithAnd([
            new DNSCheckValidation(),
            new RFCValidation(),
            new NoRFCWarningsValidation(),
            new MessageIDValidation()
        ]);
        return response()->json(['check' => $validator->isValid($email, $multipleValidations)]);
    }


    public function getValueFromJsonObject($object, $value)
    {
        $check_email = json_decode($object->getContent(), true);
        return $check_email[$value];
    }



}