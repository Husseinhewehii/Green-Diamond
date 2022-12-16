<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StaticContent\UpdateStaticContent;
use App\Http\Resources\StaticContent\ShowStaticContentResource;
use App\Models\StaticContent;
use App\Repositories\StaticContent\StaticContentRepository;
use App\Services\StaticContent\StaticContentService;

/**
 * @group Admin Static Content Module
 */
class StaticContentController extends Controller
{
    protected $staticContentRepository;
    protected $staticContentService;

    public function __construct(StaticContentRepository $staticContentRepository, StaticContentService $staticContentService) {
        $this->authorizeResource(StaticContent::class, "staticContent");
        $this->staticContentRepository = $staticContentRepository;
        $this->staticContentService = $staticContentService;
    }

    /**
     * Get All Static Content
     *
     * @header Authorization Bearer Token
     *
     * @queryParam sort Sort Field by key,group. Example: key,group
     * @queryParam filter[key] Filter by key. Example: navbar
     * @queryParam filter[group] Filter by group. Example: main
     *
     * @apiResourceCollection App\Http\Resources\StaticContent\ShowStaticContentResource
     * @apiResourceModel App\Models\StaticContent
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     */
    public function index()
    {
        return ok_response($this->all());
    }

    /**
     * Update Static Content
     *
     * Send Key of Static Content Record and Text with translations
     *
     * you could send text of just one language
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\StaticContent\ShowStaticContentResource
     * @apiResourceModel App\Models\StaticContent
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * */
    public function update(UpdateStaticContent $request,StaticContent $staticContent){
        $this->staticContentService->updateStaticContent($request, $staticContent);
        return ok_response($this->all());
    }

    private function all(){
        return collectionFormat(ShowStaticContentResource::class, $this->staticContentRepository->getStaticContent());
    }

    protected function resourceMethodsWithoutModels()
    {
        return ['index', 'update'];
    }
}
