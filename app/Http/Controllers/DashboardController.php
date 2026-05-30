<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);

        $totalUsers    = User::count();
        $activeCount   = User::where('status', 'active')->count();
        $adminCount    = User::where('role', 'admin')->count();
        $inactiveCount = User::where('status', 'inactive')->count();

        return view('dashboard', compact(
            'users',
            'totalUsers',
            'activeCount',
            'adminCount',
            'inactiveCount'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'gender'   => 'required|in:male,female,other',
            'role'     => 'required|in:user,admin',
            'status'   => 'required|in:active,inactive',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'gender'   => $request->gender,
            'role'     => $request->role,
            'status'   => $request->status,
        ]);

        return redirect()->route('dashboard.index')
                         ->with('success', 'User created successfully!');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
                 'name'=> 'required|string|max:255',
                 'email'=> [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:6|confirmed',
            'gender'   => 'required|in:male,female,other',
            'role'     => 'required|in:user,admin',
            'status'   => 'required|in:active,inactive',
        ]);

        $updateData = [
            'name'   => $request->name,
            'email'  => $request->email,
            'gender' => $request->gender,
            'role'   => $request->role,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('dashboard.index')
                         ->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('dashboard.index')
                             ->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('dashboard.index')
                         ->with('success', 'User deleted successfully!');
    }
}