<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Admin::orderBy('created_at', 'desc')->get();
        return view('admin.accounts', compact('accounts'))->with('active', 'accounts');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,cashier,kitchen',
        ]);

        $account = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Account created successfully',
            'data' => $account
        ]);
    }

    public function update(Request $request, $id)
    {
        $account = Admin::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('admins')->ignore($account->id)],
            'role' => 'required|in:admin,cashier,kitchen',
            'password' => 'nullable|string|min:6',
        ]);

        $account->name = $validated['name'];
        $account->email = $validated['email'];
        $account->role = $validated['role'];

        if (!empty($validated['password'])) {
            $account->password = Hash::make($validated['password']);
        }

        $account->save();

        return response()->json([
            'success' => true,
            'message' => 'Account updated successfully',
            'data' => $account
        ]);
    }

    public function destroy($id)
    {
        $account = Admin::findOrFail($id);

        if ($account->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account'
            ], 403);
        }

        $account->delete();

        return response()->json([
            'success' => true,
            'message' => 'Account deleted successfully'
        ]);
    }
}
