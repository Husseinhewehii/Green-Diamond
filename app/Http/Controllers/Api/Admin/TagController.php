<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tag\StoreTag;
use App\Http\Requests\Admin\Tag\UpdateTag;
use App\Http\Resources\Tag\TagResource;
use App\Http\Resources\Tag\TagWithTranslatablesResource;
use App\Repositories\Tag\TagRepository;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Services\Tag\TagService;

/**
 * @group Admin Tag Module
 */
class TagController extends Controller
{
    protected $tagRepository;
    protected $tagService;

    public function __construct(TagRepository $tagRepository, TagService $tagService) {
        $this->authorizeResource(Tag::class, "tag");
        $this->tagRepository = $tagRepository;
        $this->tagService = $tagService;
    }

    /**
     * Get All Tag
     *
     * @header Authorization Bearer Token
     *
     * @queryParam sort Sort Field by name,active. Example: name,active
     * @queryParam filter[name] Filter by name. Example: name
     * @queryParam filter[active] Filter by active. Example: active
     *
     * @apiResourceCollection App\Http\Resources\Tag\TagResource
     * @apiResourceModel App\Models\Tag paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     */
    public function index()
    {
        return ok_response($this->all());
    }

    /**
     * Create Tag
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection 201 App\Http\Resources\Tag\TagResource
     * @apiResourceModel App\Models\Tag paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * */
    public function store(StoreTag $request) {
        $this->tagService->createTag($request);
        return created_response($this->all());
    }

    /**
     * Update Tag
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\Tag\TagResource
     * @apiResourceModel App\Models\Tag paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found Tag " responses/not_found.json
     * */
    public function update(UpdateTag $request, Tag $tag) {
        $this->tagService->updateTag($request, $tag);
        return ok_response($this->all());
    }

    /**
     * Show Tag
     *
     * @header Authorization Bearer Token
     *
     * @apiResource App\Http\Resources\Tag\TagWithTranslatablesResource
     * @apiResourceModel App\Models\Tag paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found Tag " responses/not_found.json
     * */
    public function show(Request $request, Tag $tag) {
        return ok_response(new TagWithTranslatablesResource($tag));
    }

    /**
     * Delete Tag
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\Tag\TagResource
     * @apiResourceModel App\Models\Tag paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found Tag " responses/not_found.json
     * */
    public function destroy(Request $request, Tag $tag) {
        $tag->delete();
        return ok_response($this->all());
    }

    private function all(){
        return paginatedCollectionFormat(TagResource::class, $this->tagRepository->getTags());
    }
}
