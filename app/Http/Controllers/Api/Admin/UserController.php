<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\DeleteUser;
use App\Http\Requests\Admin\User\StoreUser;
use App\Http\Requests\Admin\User\UpdateUser;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\User\UserService;


/**
 * @group Admin User Module
 */
class UserController extends Controller
{
    protected $userRepository;
    protected $userService;

    public function __construct(UserRepository $userRepository, UserService $userService) {
        $this->authorizeResource(User::class, "user");
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * Get All Users
     *
     * @header Authorization Bearer Token
     *
     * @queryParam sort Sort Field by first_name, last_name, email, phone, type, active. Example: first_name,last_name,email,phone,type,active
     * @queryParam filter[first_name] Filter by first_name. Example: first name
     * @queryParam filter[last_name] Filter by last_name. Example: last name
     * @queryParam filter[email] Filter by email. Example: email
     * @queryParam filter[phone] Filter by phone. Example: phone
     * @queryParam filter[type] Filter by type. Example: type
     * @queryParam filter[active] Filter by active. Example: active
     *
     * @apiResourceCollection App\Http\Resources\User\UserResource
     * @apiResourceModel App\Models\User paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     */
    public function index()
    {
        return ok_response($this->all());
    }

    /**
     * Create User
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection 201 App\Http\Resources\User\UserResource
     * @apiResourceModel App\Models\User paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * */
    public function store(StoreUser $request)
    {
        $this->userService->createUser($request);
        return created_response($this->all());
    }

    /**
     * Show User
     *
     * @header Authorization Bearer Token
     *
     * @apiResource App\Http\Resources\User\UserResource
     * @apiResourceModel App\Models\User paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found user" responses/not_found.json
     * */
    public function show(User $user)
    {
        //
        return ok_response(new UserResource($user));
    }

    /**
     * Update User
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\User\UserResource
     * @apiResourceModel App\Models\User paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found user" responses/not_found.json
     * */
    public function update(UpdateUser $request, User $user)
    {
        $this->userService->updateUser($request, $user);
        return ok_response($this->all());
    }

    /**
     * Delete User
     *
     * A Super Admin Cannot Be Deleted
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\User\UserResource
     * @apiResourceModel App\Models\User paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found user" responses/not_found.json
     * */
    public function destroy(DeleteUser $request, User $user)
    {
        $user->delete();
        return ok_response($this->all());
    }

    private function all(){
        return paginatedCollectionFormat(UserResource::class, $this->userRepository->getUsers());
    }
}
