<?php
namespace Tests\Feature\Admin\Auth;

use App\Models\User;
use Database\Seeders\StaticContentSeeder;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Support\Facades\Artisan;

trait AuthTestingTrait{
    protected $loginUrl;
    protected $user;

    public function setUp() : void
    {
        parent::setUp();
        $this->seed(StaticContentSeeder::class);
        $this->user = User::factory()->create();

        Artisan::call('passport:install');
        $this->loginUrl = "/api/admin/login";
    }

    public function loginResponseData()
    {
        return [
            'id' => $this->user->id,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'email' => $this->user->email,
        ];
    }

    public function loginPayload($data = [])
    {
        $this->user->email = "test@test.com";
        $this->user->password = "Atest%&12";
        $this->user->save();
        $payload = ['email' => "test@test.com", 'password' => "Atest%&12"];
        return array_merge($payload, $data);
    }
}
