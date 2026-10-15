<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    /** form id in the page markup => label shown in the admin */
    public const FORMS = [
        'home-enquiry' => 'Home — Free Assessment',
        'contact-form' => 'Contact Us',
        'assessment-form' => 'Eligibility Assessment',
        'feedback-form' => 'Feedback',
        'refer-form' => 'Refer a Friend',
    ];

    protected $fillable = [
        'form', 'name', 'phone', 'email', 'country', 'message',
        'page_url', 'ip_address', 'user_agent', 'is_read',
    ];

    protected function casts(): array
    {
        return ['is_read' => 'boolean'];
    }

    public function formLabel(): string
    {
        return self::FORMS[$this->form] ?? $this->form;
    }
}
