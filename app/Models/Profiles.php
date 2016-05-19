<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model {

    public $timestamps = false;
    protected $fillable = ['user_id', 'profile_type_id', 'link'];
    protected $table = 'Profiles';
    protected $hidden = ['id', 'user_id', 'profile_type_id'];
    protected $appends = ['type'];

    public function getTypeAttribute() {
        return $this->type()->firstOrFail()->name;
    }

    public function type() {
        return $this->hasOne(Profiles_types::class, 'id', 'profile_type_id');
    }
}
