<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EnquiryController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'form' => ['required', Rule::in(array_keys(Enquiry::FORMS))],
            'name' => ['required', 'string', 'max:120'],
            'number' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-()\s]{7,20}$/'],
            'email' => ['required', 'email', 'max:190'],
            'country' => ['required', 'string', 'max:60'],
            'message' => ['nullable', 'string', 'max:5000'],
        ], [
            'number.regex' => 'Enter a valid phone number.',
        ]);

        Enquiry::create([
            'form' => $data['form'],
            'name' => $data['name'],
            'phone' => $data['number'],
            'email' => $data['email'],
            'country' => $data['country'],
            'message' => $data['message'] ?? null,
            'page_url' => Str::limit((string) $request->headers->get('referer'), 490, ''),
            'ip_address' => $request->ip(),
            'user_agent' => Str::limit((string) $request->userAgent(), 490, ''),
        ]);

        $message = 'Thank you. Your enquiry has been recorded — our team will contact you shortly.';

        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'message' => $message]);
        }

        return back()->with('enquiry_status', $message);
    }
}
