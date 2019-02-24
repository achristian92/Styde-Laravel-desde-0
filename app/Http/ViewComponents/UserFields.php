<?php
/**
 * Created by PhpStorm.
 * User: alanruizaguirre
 * Date: 2019-02-24
 * Time: 11:57
 */

namespace App\Http\ViewComponents;


use App\Profession;
use App\Skill;
use App\User;
use Illuminate\Contracts\Support\Htmlable;

class UserFields implements Htmlable
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return view('users._fields', [
            'professions' => Profession::orderBy('title','ASC')->get(),
                'skills' => Skill::orderBy('name','ASC')->get(),
                'roles' => trans('users.roles'),
                'user' => $this->user,
        ]);

    }
}