<?php
namespace App\Http\Controllers\Api;

use App\Application\Buses\QueryBus;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Application\Buses\CommandBus;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Application\Commands\LoginUserCommand;
use App\Application\Commands\LogoutUserCommand;
use App\Application\Queries\GetUserProfileQuery;
use App\Application\Commands\RegisterUserCommand;
use App\Application\Commands\UpdateProfileCommand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class AuthController extends Controller
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->commandBus->dispatch(
            new RegisterUserCommand($request->validated())
        );

        $user = $result['user']->load(['township', 'ward']);

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'data' => [
                'user' => new UserResource($user),
                'token' => $result['token'],
                'token_type' => 'Bearer'
            ],
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $result = $this->commandBus->dispatch(
            new LoginUserCommand($data['email'], $data['password'])
        );

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user'  => new UserResource($result['user']->load(['township', 'ward'])),
                'token' => $result['token'],
                'token_type' => 'Bearer',
            ],
        ]);
    }


   public function profile(Request $request): JsonResponse
    {
        // Dispatch the query through the query bus
        $user = $this->queryBus->dispatch(
            new GetUserProfileQuery($request->user())
        );

        // Wrap the result in a resource and return consistent API response
        return response()->json([
            'success' => true,
            'message' => 'User profile retrieved successfully',
            'data' => [
                'user' => new UserResource($user),
            ],
        ]);
    }


    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $this->commandBus->dispatch(
            new UpdateProfileCommand($request->user(), $request->validated())
        );

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!',
            'data' => new UserResource($user),
        ]);
    }

    public function logout(Request $request)
    {
        $this->commandBus->dispatch(
            new LogoutUserCommand($request->user())
        );

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
        ]);
    }
}
