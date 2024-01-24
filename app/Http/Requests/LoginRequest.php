<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required'
        ];
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getCredentials()
    {
        // The form field for providing username or password
        // have name of "username", however, in order to support
        // logging users in with both (username and email)
        // we have to check if user has entered one or another
        $username = $this->get('email');
        $password = $this->get('password');

        $hash = password_hash($password,PASSWORD_DEFAULT);
        $unencrypted_password = "123456";

        $verify = password_verify($unencrypted_password, $hash);

        // dd($verify);

        if ($this->isEmail($username)) {
            User::where([['email', '=', $username], ['active', '=', '1']])
            // ->whereNull('phone')
            ->update([
                'lastest_login' => date('Y-m-d H:i:s')
            ]);
            return [
                'email' => $username,
                'password' => $this->get('password')
            ];
        }

        return $this->only('email', 'password');
    }

    /**
     * Validate if provided parameter is valid email.
     *
     * @param $param
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function isEmail($param)
    {
        $factory = $this->container->make(ValidationFactory::class);

        return ! $factory->make(
            ['email' => $param],
            ['email' => 'email']
        )->fails();
    }
}
