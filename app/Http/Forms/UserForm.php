<?php
/**
 * Created by PhpStorm.
 * User: alanruizaguirre
 * Date: 2019-02-24
 * Time: 15:31
 */

namespace App\Http\Forms;
use App\{Profession,User,Skill};

use Illuminate\Contracts\Support\Responsable;

class UserForm implements Responsable
{
    private $view;
    /**
     * @var User
     */
    private $user;

    public function __construct($view, User $user)
    {
        $this->view = $view;
        $this->user = $user;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return view($this->view,[
            'professions' => Profession::orderBy('title','ASC')->get(),
            'skills' => Skill::orderBy('name','ASC')->get(),
            'roles' => trans('users.roles'),
            'user' => $this->user,
        ]);
    }
}