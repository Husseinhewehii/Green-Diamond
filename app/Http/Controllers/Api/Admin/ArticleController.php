<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Article\StoreArticle;
use App\Http\Requests\Admin\Article\UpdateArticle;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Article\ArticleWithTranslatablesResource;
use App\Models\Article;
use App\Repositories\Article\ArticleRepository;
use App\Services\Article\ArticleService;
use Illuminate\Http\Request;

/**
 * @group Admin Article Module
 */
class ArticleController extends Controller
{
    protected $articleRepository;
    protected $articleService;

    public function __construct(ArticleRepository $articleRepository, ArticleService $articleService) {
        $this->authorizeResource(Article::class, "article");
        $this->articleRepository = $articleRepository;
        $this->articleService = $articleService;
    }

    /**
     * Get All Articles
     *
     * @header Authorization Bearer Token
     *
     * @queryParam sort Sort Field by title,description,short_description,article_category_id,active. Example: title,description,short_description,article_category_id,active
     * @queryParam filter[title] Filter by title. Example: title
     * @queryParam filter[description] Filter by description. Example: description
     * @queryParam filter[short_description] Filter by short_description. Example: short_description
     * @queryParam filter[article_category_id] Filter by article_category_id. Example: article_category_id
     * @queryParam filter[active] Filter by active. Example: active
     *
     * @apiResourceCollection App\Http\Resources\Article\ArticleResource
     * @apiResourceModel App\Models\Article paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     */
    public function index()
    {
        return ok_response($this->all());
    }

    /**
     * Create Article
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection 201 App\Http\Resources\Article\ArticleResource
     * @apiResourceModel App\Models\Article paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * */
    public function store(StoreArticle $request)
    {
        $this->articleService->createArticle($request);
        return created_response($this->all());
    }

    /**
     * Show Article
     *
     * @header Authorization Bearer Token
     *
     * @apiResource App\Http\Resources\Article\ArticleWithTranslatablesResource
     * @apiResourceModel App\Models\Article paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found article " responses/not_found.json
     * */
    public function show(Article $article)
    {
        return ok_response(new ArticleWithTranslatablesResource($article));
    }

    /**
     * Update Article
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\Article\ArticleResource
     * @apiResourceModel App\Models\Article paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found article " responses/not_found.json
     * */
    public function update(UpdateArticle $request, Article $article)
    {
        $this->articleService->updateArticle($request, $article);
        return ok_response($this->all());
    }

    /**
     * Delete Article
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\Article\ArticleResource
     * @apiResourceModel App\Models\Article paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found article " responses/not_found.json
     * */
    public function destroy(Article $article)
    {
        $article->delete();
        return ok_response($this->all());
    }

    private function all(){
        return paginatedCollectionFormat(ArticleResource::class, $this->articleRepository->getArticles());
    }
}
