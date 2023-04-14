<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControleLOG_User extends Model
{
    protected $table = 'LOG-user';

    protected $fillable = [
                            'id', 
                            'id_user_function',
                            'function',
                            'name',
                            'email',
                            'password'
                          ];

    public function rules()
    {
        return [
            'id_user_function'  => 'required:LOG-user',
            'function'  => 'required:LOG-user',
            'name'  => 'required:LOG-user',
            'email' => 'required|unique:LOG-user',
            'password' => 'required|unique:LOG-user'
        ];
    }
}
