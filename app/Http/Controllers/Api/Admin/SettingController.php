<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\UpdateSetting;
use App\Http\Resources\Setting\SettingResource;
use App\Models\Setting;
use App\Repositories\Setting\SettingRepository;
use App\Services\Setting\SettingService;

/**
 * @group Admin Setting Module
 */
class SettingController extends Controller
{
    protected $settingRepository;
    protected $settingService;

    public function __construct(SettingRepository $settingRepository, SettingService $settingService) {
        $this->authorizeResource(Setting::class, "setting");
        $this->settingRepository = $settingRepository;
        $this->settingService = $settingService;
    }

    /**
     * Get All Settings
     *
     * @header Authorization Bearer Token
     * @queryParam sort Sort Field by key,group. Example: key,group
     * @queryParam filter[key] Filter by key. Example: navbar
     * @queryParam filter[group] Filter by group. Example: main
     *
     * @apiResourceCollection App\Http\Resources\Setting\SettingResource
     * @apiResourceModel App\Models\Setting
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     */
    public function index()
    {
        return ok_response($this->all());
    }

    /**
     * Update Setting
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\Setting\SettingResource
     * @apiResourceModel App\Models\Setting
     *
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     */
    public function update(UpdateSetting $request, Setting $setting){
        $this->settingService->updateSetting($request, $setting);
        return ok_response($this->all());
    }

    private function all(){
        return collectionFormat(SettingResource::class, $this->settingRepository->getSettings());
    }
}
