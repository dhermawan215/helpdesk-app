<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpDeskTicket extends Model
{
    use HasFactory;

    protected $table = 'help_desk_tickets';

    protected $fillable = [
        'ticket_id',
        'user_request_id',
        'category_id',
        'sub_category_id',
        'subject',
        'description',
        'ticket_date',
        'assign_to',
        'status'
    ];
}
