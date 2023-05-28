<?php

namespace App\Models\Admission;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionOfficer extends Model
{
    use HasFactory;
    public $table = 'admission_officers';

    public function user(){
        return $this->belongsTo(User::class);
    }
}
