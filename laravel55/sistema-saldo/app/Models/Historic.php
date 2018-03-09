<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Historic extends Model
{
    protected $fillable = ['type', 'amount', 'total_before', 'total_after', 'user_id_transaction', 'date'];

    //Muttator: get<NomeDoCampo>Attribute
    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getType($type = null)
    {
        $types = [
            'I' => 'Entrada',
            'O' => 'Saque',
            'T' => 'Transferência para',
        ];

        if(!$type)
            return $types;

        if($this->user_id_transaction != null && $type == 'I')
            return 'Recebido por transferência de';

        return $types[$type];
    }

    public function scopeUserAuth($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    //relacionamento inverso com user, para resgatar o nome do usuario que fez uma transferencia
    public function user()
    {
        return $this->belongsTo(User::class);//relacionamento da ordem 1
    }

    //relacionamento com a tabela de user, onde resgato o user_id_transaction
    public function userDestinatario()
    {
        return $this->belongsTo(User::class, 'user_id_transaction');//relacionamento da ordem 1
    }

    public function search(Array $data, $paginate)
    {
        return $this->where(function ($query) use ($data){
            if(isset($data['id']))
                $query->where('id', '=', $data['id']);

            if(isset($data['date']))
                $query->where('date', '=', $data['date']);

            if(isset($data['type']))
                $query->where('type', '=', $data['type']);

        })//->where('user_id', '=', auth()->user()->id) //uso o escopo local abaixo para pesquisar
            ->userAuth()
            ->with(['userDestinatario'])
            ->orderBy('date', 'desc')//->toSql();
            ->paginate($paginate);
    }
}
