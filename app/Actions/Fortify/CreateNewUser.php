<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Silber\Bouncer\BouncerFacade as Bouncer;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['nullable', 'string', 'max:255'],
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        [$firstName, $lastName] = $this->resolveUserNames($input);

        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'contact_number' => $input['contact_number'] ?? '0000000000',
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $employeeRole = Bouncer::role()->firstOrCreate(
            ['name' => 'employee'],
            ['title' => 'Employee']
        );

        $user->assign($employeeRole->name);

        return $user;
    }

    protected function resolveUserNames(array $input): array
    {
        $firstName = trim((string) ($input['first_name'] ?? ''));
        $lastName = trim((string) ($input['last_name'] ?? ''));

        if ($firstName !== '' && $lastName !== '') {
            return [$firstName, $lastName];
        }

        $name = trim((string) ($input['name'] ?? ''));

        if ($name === '') {
            return ['User', 'User'];
        }

        $parts = preg_split('/\s+/', $name);
        $firstName = array_shift($parts);
        $lastName = count($parts) ? implode(' ', $parts) : $firstName;

        return [$firstName, $lastName];
    }
}
