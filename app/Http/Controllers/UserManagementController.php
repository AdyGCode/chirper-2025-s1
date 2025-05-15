<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
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


        $users = User::whereAny(
            ['name', 'email', 'position',], 'LIKE', "%$search%")
            ->paginate(2)
            ->appends(['search' => $search]);


        return view('users.index')
            ->with('users', $users)
            ->with('search', $search);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'name' => ['required', 'min:2', 'max:192',],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class . ',email',],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'role' => ['nullable',],
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => Str::lower($validated['email']),
                'password' => Hash::make($validated['password']),
            ]);

        } catch (ValidationException $e) {

            flash()->error('Please fix the errors in the form.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'User Creation Failed');

            return back()->withErrors($e->validator)->withInput();

        }

        $userName = $user->name;

        flash()->success("User $userName created successfully!",
            [
                'position' => 'top-center',
                'timeout' => 5000,
            ],
            "User Added");

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

        try {

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

        } catch (ValidationException $e) {

            flash()->error('Please fix the errors in the form.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'User Update Failed');

            return back()->withErrors($e->validator)->withInput();

        }

        if (isNull($user->email_verified_at)) {
            $user->sendEmailVerificationNotification();
        }

        $userName = $user->name;

        flash()->info("User $userName details updated successfully!",
            [
                'position' => 'top-center',
                'timeout' => 5000,
            ],
            "User Updated");

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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // TODO: Update when we add Roles & Permissions

        $oldUser = $user;

        $user->delete();


        $userName = $oldUser->name;

        flash()->info("User $userName removed successfully!",
            [
                'position' => 'top-center',
                'timeout' => 5000,
            ],
            "User Deleted");

        return redirect(route('users.index'));

    }
}
