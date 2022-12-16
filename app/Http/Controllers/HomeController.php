<?php

namespace App\Http\Controllers;

use App\Constants\Media_Collections;
use App\Events\TestEvent;
use App\Jobs\TestJob;
use App\Jobs\TestJobSecond;
use App\Mail\TestMail;
use App\Models\ArticleCategory;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\TestNotification;
use App\Services\Testing\TestService;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class HomeController extends Controller
{
    public function index()
    {
        $data['articleCategories']=QueryBuilder::for(ArticleCategory::class)
        // ->with('articles')
        ->get();
        return view('home');
    }

    public function downloadTest()
    {
        $response =  response()
        ->download(storage_path('app\testFolder\phototest.png'),
         'phototest.png',
         ['Disposition'  => 'Attachment']);
         return $response;
    }

    public function uploadTest(Request $request)
    {
        $firstEmployee = Employee::factory()->create();

        if($request->hasFile('photo')){
            if($request->has('spatie')){
                add_media_item($firstEmployee, $request->photo, Media_Collections::EMPLOYEE);
            }else{
                $fileName = $request->file('photo')->getClientOriginalName();
                $request->file('photo')->storeAs('employees_folder', $fileName, 'employees_disk');
            }
        }
        return "jaa";
    }

    public function dispatchJob()
    {
        $category = ArticleCategory::factory()->create();

        // diff syntax
        TestJob::dispatch($category);
        dispatch(new TestJobSecond($category));
    }

    public function dispatchMail()
    {
        $user = User::First();
        
        Mail::to('husseinhewehii@gmail.com')->send(new TestMail());
        Notification::send($user, new TestNotification());
    }

    public function dispatchEvent()
    {
        event(new TestEvent());
    }

    public function invoiceExcel()
    {
        event(new TestEvent());
    }

    public function mockService(TestService $testService)
    {
        $name = $testService->greet("hussein");
        return $name;
    }

}
