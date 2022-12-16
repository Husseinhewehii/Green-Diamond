<?php

namespace App\Repositories\Employee;

use App\Models\Employee;
use Spatie\QueryBuilder\QueryBuilder;

class EmployeeRepository
{
    public function getEmployees()
    {
        return QueryBuilder::for(Employee::class)
        // ->allowedFilters(['name','description','email','phone','type','active'])
        // ->allowedFilters(['name','description','email','phone','type','active'])
        ->allowedSorts(['name','position','description','type','active'])
        ->allowedSorts(['name','position','description','type','active'])
        ->paginate(10);
    }

    public function getEmployeesLimited($request)
    {
        return QueryBuilder::for(Employee::class)
        ->allowedFilters(['name','position','description','type','active'])
        ->limit($request->limit)
        ->get();
    }

}
