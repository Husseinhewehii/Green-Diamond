<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Employee\StoreEmployee;
use App\Http\Requests\Admin\Employee\UpdateEmployee;
use App\Http\Resources\Employee\EmployeeResource;
use App\Models\Employee;
use App\Repositories\Employee\EmployeeRepository;
use App\Services\Employee\EmployeeService;

/**
 * @group Admin Employee Module
 */
class EmployeeController extends Controller
{
    protected $employeeRepository;
    protected $employeeService;

    public function __construct(EmployeeRepository $employeeRepository, EmployeeService $employeeService) {
        $this->authorizeResource(Employee::class, "employee");
        $this->employeeRepository = $employeeRepository;
        $this->employeeService = $employeeService;
    }

    /**
     * Get All Employees
     *
     * @header Authorization Bearer Token
     *
     * @queryParam sort Sort Field by name, type, active, description,position. Example: name,type,active,description,position
     * @queryParam filter[name] Filter by name. Example: name
     * @queryParam filter[type] Filter by type. Example: type
     * @queryParam filter[active] Filter by active. Example: active
     * @queryParam filter[description] Filter by description. Example: description
     * @queryParam filter[position] Filter by position. Example: position
     *
     * @apiResourceCollection App\Http\Resources\Employee\EmployeeResource
     * @apiResourceModel App\Models\Employee paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     */
    public function index()
    {
        return ok_response($this->all());
    }

   /**
     * Create Employee
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection 201 App\Http\Resources\Employee\EmployeeResource
     * @apiResourceModel App\Models\Employee paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * */
    public function store(StoreEmployee $request)
    {
        $this->employeeService->createEmployee($request);
        return created_response($this->all());
    }

    /**
     * Show Employee
     *
     * @header Authorization Bearer Token
     *
     * @apiResource App\Http\Resources\Employee\EmployeeResource
     * @apiResourceModel App\Models\Employee paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found employee" responses/not_found.json
     * */
    public function show(Employee $employee)
    {
        return ok_response(new EmployeeResource($employee));
    }

    /**
     * Update Employee
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\Employee\EmployeeResource
     * @apiResourceModel App\Models\Employee paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found employee" responses/not_found.json
     * */
    public function update(UpdateEmployee $request, Employee $employee)
    {
        $this->employeeService->updateEmployee($request, $employee);
        return ok_response($this->all());
    }

    /**
     * Delete Employee
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\Employee\EmployeeResource
     * @apiResourceModel App\Models\Employee paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found employee" responses/not_found.json
     * */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return ok_response($this->all());
    }

    private function all(){
        return paginatedCollectionFormat(EmployeeResource::class, $this->employeeRepository->getEmployees());
    }
}
