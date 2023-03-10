<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendgridOverview extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'blocks',
        'bounce_drops',
        'bounces',
        'clicks',
        'deferred',
        'delivered',
        'invalid_emails',
        'opens',
        'processed',
        'requests',
        'spam_report_drops',
        'spam_reports',
        'unique_clicks',
        'unique_opens',
        'unsubscribe_drops',
        'unsubscribes',
        'date_current',
        'date_time'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('sendgrid_overview');
    }
}
