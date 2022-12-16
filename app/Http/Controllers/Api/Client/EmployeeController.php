<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Employee\EmployeeResource;
use App\Repositories\Employee\EmployeeRepository;
use Illuminate\Http\Request;

/**
 * @group Employee Module
 */
class EmployeeController extends Controller
{
    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository) {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Get All Employees
     *
     * @queryParam filter[type] Filter by type of Employee
     *  which is 1 for manager or 2 for staff . Example: 1
     * @queryParam limit decide how many Employees You Need . Example: 5
     *
     * @apiResourceCollection App\Http\Resources\Employee\EmployeeResource
     * @apiResourceModel App\Models\Employee
     */
    public function index(Request $request)
    {
        return ok_response($this->all($request));
    }

    private function all($request){
        return collectionFormat(EmployeeResource::class, $this->employeeRepository->getEmployeesLimited($request));
    }
}
