<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use function PHPUnit\Framework\isNull;
use Illuminate\Support\Str;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // TODO: Only allow authorised users (Admin/Staff Roles)

        $validated = $request->validate([
            'search' => ['nullable', 'string',]
        ]);

        $search = $validated['search'] ?? '';
//
//        $users = User::whereLike('name', '%' . $search . '%')
//            ->orWhereLike('email', "%$search%")
//            ->orWhereLike('position', "%$search%")
//            ->paginate(10);

        $users = User::whereAny(
            ['name', 'email','position',], 'LIKE', "%$search%")
            ->paginate(10);


        return view('users.index', compact(['users', 'search',]));
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
//            'name' => $request->name,
//            'email' => mb_strtolower($request->email),
//            'password' => Hash::make($request->password),
            'name' => $validated['name'],
            'email' => Str::lower($validated['email']),
            'password' => Hash::make($validated['password']),
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

        return view('users.edit', compact(['roles', 'user',]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // TODO: Update when we add Roles & Permissions


        $validated = $request->validate([
            'name' => ['required', 'min:2', 'max:192',],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user),
            ],
            'password' => [
                'sometimes',
                'nullable',
                'confirmed',
                Rules\Password::defaults()
            ],
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

        if (isNull($user->email_verified_at)) {
            $user->sendEmailVerificationNotification();
        }

        return redirect(route('users.index'));
    }

    /**
     * Confirm the removal of the specified user.
     *
     * This is a prequel to the actual destruction of the record.
     * Put in place to provide a "confirm the action".
     *
     * @param User $user
     */
    public function delete(User $user)
    {
        // TODO: Update when we add Roles & Permissions

        return view("users.delete", compact(['user',]));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return void
     */
    public function destroy(User $user)
    {
        // TODO: Update when we add Roles & Permissions

        $oldUser = $user;

        $user->delete();

        return redirect(route('users.index'));

    }
}
