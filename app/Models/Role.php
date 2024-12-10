<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Role extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'name',
    ];
    
    public function User(){
        return $this->BelongsToMany(User::class);
    }
}
