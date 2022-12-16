<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleCategory\StoreArticleCategory;
use App\Http\Requests\Admin\ArticleCategory\UpdateArticleCategory;
use App\Http\Resources\ArticleCategory\ArticleCategoryResource;
use App\Http\Resources\ArticleCategory\ArticleCategoryWithTranslatablesResource;
use App\Models\ArticleCategory;
use App\Repositories\ArticleCategory\ArticleCategoryRepository;
use App\Services\ArticleCategory\ArticleCategoryService;
use Illuminate\Http\Request;

/**
 * @group Admin Article Category Module
 */
class ArticleCategoryController extends Controller
{
    protected $articleCategoryRepository;
    protected $articleCategoryService;

    public function __construct(ArticleCategoryRepository $articleCategoryRepository, ArticleCategoryService $articleCategoryService) {
        $this->authorizeResource(ArticleCategory::class, "articleCategory");
        $this->articleCategoryRepository = $articleCategoryRepository;
        $this->articleCategoryService = $articleCategoryService;
    }

    /**
     * Get All Article Categories
     *
     * @header Authorization Bearer Token
     *
     * @queryParam sort Sort Field by title, parent_id, type, active. Example: title,parent_id,type,active
     * @queryParam filter[title] Filter by title. Example: title
     * @queryParam filter[parent_id] Filter by parent_id. Example: parent_id
     * @queryParam filter[type] Filter by type. Example: type
     * @queryParam filter[active] Filter by active. Example: active
     *
     * @apiResourceCollection App\Http\Resources\ArticleCategory\ArticleCategoryResource
     * @apiResourceModel App\Models\ArticleCategory paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     */
    public function index()
    {
        return ok_response($this->all());
    }

    /**
     * Create ArticleCategory
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection 201 App\Http\Resources\ArticleCategory\ArticleCategoryResource
     * @apiResourceModel App\Models\ArticleCategory paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * */
    public function store(StoreArticleCategory $request)
    {
        $this->articleCategoryService->createArticleCategory($request);
        return created_response($this->all());
    }

    /**
     * Show ArticleCategory
     *
     * @header Authorization Bearer Token
     *
     * @apiResource App\Http\Resources\ArticleCategory\ArticleCategoryWithTranslatablesResource
     * @apiResourceModel App\Models\ArticleCategory paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found article category" responses/not_found.json
     * */
    public function show(ArticleCategory $articleCategory)
    {
        return ok_response(new ArticleCategoryWithTranslatablesResource($articleCategory));
    }

    /**
     * Update ArticleCategory
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\ArticleCategory\ArticleCategoryResource
     * @apiResourceModel App\Models\ArticleCategory paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found article category" responses/not_found.json
     * */
    public function update(UpdateArticleCategory $request, ArticleCategory $articleCategory)
    {
        $this->articleCategoryService->updateArticleCategory($request, $articleCategory);
        return ok_response($this->all());
    }

    /**
     * Delete ArticleCategory
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\ArticleCategory\ArticleCategoryResource
     * @apiResourceModel App\Models\ArticleCategory paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found article category" responses/not_found.json
     * */
    public function destroy(ArticleCategory $articleCategory)
    {
        $articleCategory->delete();
        return ok_response($this->all());
    }

    private function all(){
        return paginatedCollectionFormat(ArticleCategoryResource::class, $this->articleCategoryRepository->getArticleCategories());
    }
}
