<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use function PHPUnit\Framework\isNull;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact(['users',]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'min:2', 'max:192',],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['nullable',],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => mb_strtolower($request->email),
            'password' => Hash::make($request->password),
        ]);

        return redirect(route('users.index'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // TODO: Update when we add Roles & Permissions
        $roles = Collection::empty();

        return view('users.create', compact(['roles',]));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // TODO: Update when we add Roles & Permissions

        return view('users.show', compact(['user']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // TODO: Update when we add Roles & Permissions

        $roles = Collection::empty();

        return view('users.edit', compact(['roles', "user",]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // TODO: Update when we add Roles & Permissions


        $validated = $request->validate([
            'name' => ['required', 'min:2', 'max:192',],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($user),],
            'password' => ['sometimes', 'nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['nullable',],
        ]);

        // Remove password if null
        if (isNull($validated['password'])) {
            unset($validated['password']);
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect(route('users.index'));
    }

    /**
     * Confirm the removal of the specified user.
     *
     * This is a prequel to the actual destruction of the record.
     * Put in place to provide a "confirm the action".
     *
     * @param string $id
     */
    public function delete(string $id)
    {
        // TODO: Update when we add Roles & Permissions

        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // TODO: Update when we add Roles & Permissions

        //
    }
}
