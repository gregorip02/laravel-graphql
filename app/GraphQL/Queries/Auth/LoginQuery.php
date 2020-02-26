<?php

namespace App\GraphQL\Queries\Auth;

use App\User;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class LoginQuery
{
    use AuthenticatesUsers;

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

        return $this->login($request);
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
     * The user has been authenticated.
     *
     * @return AuthenticatedUser
     */
    protected function authenticated(Request $request, $user): User
    {
        return $user;
    }

    /**
     * The user not been autenticated.
     *
     * @return Unknow
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw new AuthenticationException();
    }
}
