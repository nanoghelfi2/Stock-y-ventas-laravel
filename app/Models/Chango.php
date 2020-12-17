<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chango extends Model
{
    use HasFactory;
    
    public function cliente(){ //$chango->cliente->nombre
        return $this->belongsTo(Cliente::class); //Pertenece a un cliente.
    }
    public function wonderlist(){
        return $this->belongsToMany(Wonderlist::class)->withPivot('id', 'cantidad', 'unidades', 'subtotal'); // Muchos a muchos
    }
}
