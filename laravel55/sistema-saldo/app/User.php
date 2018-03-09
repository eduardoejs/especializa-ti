<?php

namespace App;

use App\Models\Historic;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Balance;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //Relacionamento 1x1 entre usuario e saldo. O metodo abaixo retorna o saldo do usuario
    public function balance()
    {
        return $this->hasOne(Balance::class);
    }

    //Relacionamento 1xN entre usuario e historico
    public function historics()
    {
        return $this->hasMany(Historic::class);
    }

    public function getDestinatario($destinatario)
    {
        return $this->where('name', 'LIKE', "%$destinatario%")
                     ->orWhere('email', $destinatario) //toSql()
                     ->get()
                     ->first();
    }
}
