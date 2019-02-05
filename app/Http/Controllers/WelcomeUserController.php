<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeUserController extends Controller
{
    public function __invoke($usuario,$nickname = null)
    {
        $name = ucfirst($usuario);
        if($nickname != null){
            $nick = ucfirst($nickname);
            return "Hola {$name} , tu apodo es {$nick}";
        }else{
            return "Hola {$name}";
        }
    }
}
