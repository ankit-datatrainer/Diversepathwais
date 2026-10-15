<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        $form = $request->query('form');
        $search = trim((string) $request->query('q'));

        $enquiries = Enquiry::query()
            ->when($form, fn ($q) => $q->where('form', $form))
            ->when($request->query('unread'), fn ($q) => $q->where('is_read', false))
            ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.enquiries.index', [
            'enquiries' => $enquiries,
            'form' => $form,
            'search' => $search,
            'forms' => Enquiry::FORMS,
        ]);
    }

    public function show(Enquiry $enquiry)
    {
        if (! $enquiry->is_read) {
            $enquiry->update(['is_read' => true]);
        }

        return view('admin.enquiries.show', ['enquiry' => $enquiry]);
    }

    public function toggle(Enquiry $enquiry)
    {
        $enquiry->update(['is_read' => ! $enquiry->is_read]);

        return back()->with('status', $enquiry->is_read ? 'Marked as read.' : 'Marked as unread.');
    }

    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();

        return redirect()->route('admin.enquiries.index')->with('status', 'Enquiry deleted.');
    }
}
