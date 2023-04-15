<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControleLOG_User extends Model
{
    protected $table = 'LOG_user';

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
            'id_user_function'  => 'required:LOG_user',
            'function'  => 'required:LOG_user',
            'name'  => 'required:LOG_user',
            'email' => 'required:LOG_user',
            'password' => 'required:LOG_user'
        ];
    }
}
