<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailHistory extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function __construct()
    {
        $this->setTable('mail_history');
    }
}
