<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\apiController;


class UserController
{
    public function register(Request $request)
    {
        $api = new apiController();
        $create_user_response = $api->create_user($request);
        $create_user = json_decode($create_user_response->getContent(), true);
        $errors = $create_user['errors'];
        $user = $create_user['user'] ?? null;

        if (count($errors) > 0) {
            foreach ($errors as $err)
            {
                echo $err."<br>";
            }
        }
        
        if (!is_null($user))
        {
            $user = User::find($user['id']);
            $this->auth_succesful($user);
        }
    }

    public function login(Request $request)
    {
        $nameORemail   = $request->input('nameORemail');
        $password   = $request->input('password');

        if (is_null($nameORemail) or is_null($password))
        {
            echo "Заполните все поля";
            return "";
        }
        $api = new apiController;
        $isEmail = $api->getValueFromJsonObject($api->email_validation($nameORemail), 'check');
        
        if ($isEmail)
        {
            $user = User::whereEmail($nameORemail)->first() ?? null;
            if (is_null($user)) {echo "Пользователь с таким email не найден";return "";}
            if (password_verify($password, $user->getAuthPassword()))
            {
                $this->auth_succesful($user);
            } else
            {
                echo "Неверный пароль";
            }
        } else 
        {
            $user = User::where('name', $nameORemail)->first() ?? null;
            if (is_null($user)) {echo "Пользователь с таким никнеймом не найден";return "";}
            if (password_verify($password, $user->getAuthPassword()))
            {
                $this->auth_succesful($user);
            } else
            {
                echo "Неверный пароль";
            }  
        }
    }
    // adminsS4$ adminsr@mail.ru adminsr
    private function auth_succesful($user)
    {
        Auth::login($user);
        $this->reloadPageJS();
    }

    public function logout()
    {
        Auth::logout();
        $this->reloadPageJS();
    }

    private function reloadPageJS(){echo "<script>window.top.location.href = \"/\";</script>";}

}
