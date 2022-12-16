<?php

namespace Tests\Feature;

use App\Constants\Media_Collections;
use App\Events\TestEvent;
use App\Jobs\TestJob;
use App\Jobs\TestJobSecond;
use App\Mail\TestMail;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\TestNotification;
use App\Services\Testing\TestService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class FeaturesTest extends TestCase
{
    use RefreshDatabase;
    public function test_download()
    {
        $file = UploadedFile::fake()->image('phototest.png');
        $fileName = $file->getClientOriginalName();
        $file->storeAs('testFolder', $fileName);
        $response = $this->get('/api/download-test');
        $response->assertHeader('disposition');
        $response->assertDownload('phototest.png');
    }

    public function test_upload()
    {
        //to create a fake disk , not on server
        Storage::fake('public');
        
        $payload = [
            'photo' => UploadedFile::fake()->image('phototest.png'),
            'spatie' => true
        ];
        
        $response = $this->post('api/upload-test', $payload);
        $response->assertOk();
        Storage::disk('public')->assertExists('/1/phototest.png');     
    }

    
    public function test_upload_2()
    {
        //to create a fake disk , not on server
        Storage::fake('employees_disk');
        
        $payload = [
            'photo' => UploadedFile::fake()->image('phototest.png')
        ];
        
        $response = $this->post('api/upload-test', $payload);
        $response->assertOk();
        Storage::disk('employees_disk')->assertExists('employees_folder/phototest.png');     
    }

    public function test_job()
    {
        $category = ArticleCategory::factory()->create();

        (new TestJob($category))->handle();
        
        //optional
        $category->refresh();
        
        $this->assertEquals('english title updated from job', $category->title);
    }

    public function test_time()
    {
        ArticleCategory::factory()->create();

        //only in laravel 9.5+
        // $this->freezeTime(function(){
        //     $this->travelTo(now()->addDay());
        // });

        $catExists = ArticleCategory::where('updated_at', now())->exists();
        $this->assertTrue($catExists);

        $this->travelTo(now()->addDay());
        $catExists = ArticleCategory::where('updated_at', now())->exists();
        $this->assertFalse($catExists);

        $this->travelBack();
        $catExists = ArticleCategory::where('updated_at', now())->exists();
        $this->assertTrue($catExists);
    }

    public function test_job_dispatched()
    {
        Bus::fake();
        $response = $this->get('/api/dispatch-job');
        $response->assertOk();
        Bus::assertDispatched(TestJob::class);
        Bus::assertDispatched(TestJobSecond::class);
    }

    public function test_mail_dispatched()
    {
        Mail::fake();
        Notification::fake();

        $user = User::factory()->create();

        $response = $this->get('/api/dispatch-mail');
        $response->assertOk();
        Mail::assertSent(TestMail::class);
        Notification::assertSentTo($user, TestNotification::class);
    }

    public function test_event_dispatched()
    {
        Event::fake();

        $response = $this->get('/api/dispatch-event');
        $response->assertOk();
        Event::assertDispatched(TestEvent::class);
    }

    public function test_package()
    {
        Excel::fake();

        $response = $this->get('/api/inovice-excel');
        $response->assertOk();
       //check excel package
    }

    public function test_mock()
    {
        $this->mock(TestService::class)
        ->shouldReceive("greet")
        ->with("hussein")
        ->once()
        ->andReturn("Hello hussein from mock");

        $response = $this->post('/api/mock-service');
        $response->assertStatus(200);
    }
}
