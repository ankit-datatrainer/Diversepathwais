<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function edit()
    {
        return view('admin.account', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $v = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190', Rule::unique('users', 'email')->ignore($user->id)],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        $user->name = $v['name'];
        $user->email = $v['email'];
        if (! empty($v['password'])) {
            $user->password = Hash::make($v['password']);
        }
        $user->save();

        return redirect()->route('admin.account.edit')->with('status', 'Account updated.');
    }
}
