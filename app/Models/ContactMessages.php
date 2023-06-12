<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessages extends Model
{
    use HasFactory;
    protected $table = 'contact_messages';
    protected $fillable = [
        'name',
        'email',
        'subject',
        'phone',
        'address',
        'country',
        'title',
        'message',
        'status',
    ];
    public function fromTime()
    {
        return date('d-m-Y H:i', strtotime($this->created_at));
    }
    public function messageStatus()
    {
        $text = '<span class="';
        if ($this->status == 0) {
            $text .= 'text-danger">';
            $text .= trans('common.unread');
        } else {
            $text .= 'text-muted">';
            $text .= trans('common.read');
        }
        $text .= '</span>';
        return $text;
    }

    public function userData()
    {
        $data = [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'message' => $this->message,
        ];

        return $data;
    }
}
