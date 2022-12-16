<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\DeleteRole;
use App\Http\Requests\Admin\Role\StoreRole;
use App\Http\Requests\Admin\Role\UpdateRole;
use App\Http\Resources\Role\RoleResource;
use App\Models\SystemRole as Role;
use App\Repositories\Role\RoleRepository;
use App\Services\Role\RoleService;
use Illuminate\Http\Request;

/**
 * @group Admin Role Module
 */
class RoleController extends Controller
{
    protected $roleRepository;
    protected $roleService;

    public function __construct(RoleRepository $roleRepository, RoleService $roleService) {
        $this->authorizeResource(Role::class, "role");
        $this->roleRepository = $roleRepository;
        $this->roleService = $roleService;
    }

    /**
     * Get All Roles
     *
     * @header Authorization Bearer Token
     *
     * @queryParam sort Sort Field by name, active. Example: name,active
     * @queryParam filter[name] Filter by name. Example: first name
     * @queryParam filter[active] Filter by active. Example: active
     *
     * @apiResourceCollection App\Http\Resources\Role\RoleResource
     * @apiResourceModel App\Models\SystemRole paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     */
    public function index()
    {
        return ok_response($this->all());
    }

    /**
     * Create Role
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection 201 App\Http\Resources\Role\RoleResource
     * @apiResourceModel App\Models\SystemRole paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * */
    public function store(StoreRole $request)
    {
        $this->roleService->createRole($request);
        return created_response($this->all());
    }

    /**
     * Show Role
     *
     * @header Authorization Bearer Token
     *
     * @apiResource App\Http\Resources\Role\RoleResource
     * @apiResourceModel App\Models\SystemRole paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found role" responses/not_found.json
     * */
    public function show(Role $role)
    {
        return ok_response(new RoleResource($role));
    }

    /**
     * Update Role
     *
     * @header Authorization Bearer Token
     * @apiResourceCollection App\Http\Resources\Role\RoleResource
     * @apiResourceModel App\Models\SystemRole paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found role" responses/not_found.json
     * */
    public function update(UpdateRole $request, Role $role)
    {
        $this->roleService->updateRole($request, $role);
        return ok_response($this->all());
    }

    /**
     * Delete Role
     *
     * A Super Admin Role Cannot Be Deleted
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\Role\RoleResource
     * @apiResourceModel App\Models\SystemRole paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found role" responses/not_found.json
     * */
    public function destroy(DeleteRole $request, Role $role)
    {
        $role->delete();
        return ok_response($this->all());
    }

    private function all(){
        return paginatedCollectionFormat(RoleResource::class, $this->roleRepository->getRoles());
    }
}
