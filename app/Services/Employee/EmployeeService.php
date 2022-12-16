<?php

namespace App\Services\Employee;

use App\Constants\Media_Collections;
use App\Models\Employee;

class EmployeeService
{
    public function createEmployee($request)
    {
        $employee = Employee::create($request->validated());
        add_media_item($employee, $request->photo, Media_Collections::EMPLOYEE);
    }

    public function updateEmployee($request, $employee)
    {
        $employee->update($request->validated());
        if($request->photo){
            add_media_item($employee, $request->photo, Media_Collections::EMPLOYEE);
        }
    }
}
