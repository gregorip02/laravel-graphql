<?php

namespace App\GraphQL\Mutations\Auth;

use App\User;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class RegisterMutation
{
    use RegistersUsers;

    /**
     * The valid attributes for the register action.
     *
     * @var array
     */
    protected $credentials = [
        'name', 'email', 'password'
    ];

    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $request = $this->normaliceRequest($context, $args);

        return $this->register($request);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): User
    {
        $credentials = $request->only($this->credentials);

        event(new Registered($user = $this->create($credentials)));

        $this->guard()->login($user);

        return $user;
    }

    /**
     * Normalice the incoming request.
     *
     * @param  GraphQLContext $context
     * @param  array          $args
     * @return \Illuminate\Http\Request
     */
    protected function normaliceRequest(GraphQLContext $context, array $args): Request
    {
        return Request::createFrom(
            new Request($args), $context->request()
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            // Lighthouse encrypt this value with @bcrypt directive.
            'password' => $data['password']
        ]);
    }
}
