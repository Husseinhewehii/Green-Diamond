<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleResource;
use App\Models\Article;
use App\Repositories\Article\ArticleRepository;
use Illuminate\Http\Request;

/**
 * @group Article Module
 */
class ArticleController extends Controller
{
    protected $articleRepository;

    public function __construct(ArticleRepository $articleRepository) {
        $this->articleRepository = $articleRepository;
    }

    /**
     * Get All Articles
     *
     * @queryParam filter[article_category_type] Filter by type of Article Category
     *  which is 1 for blogs or 2 for news . Example: 1
     * @queryParam limit decide how many Articles You Need . Example: 5
     *
     * @apiResourceCollection App\Http\Resources\Article\ArticleResource
     * @apiResourceModel App\Models\Article
     */
    public function index(Request $request)
    {
        return ok_response($this->all($request));
    }

    /**
     * Show Article
     *
     * @header Authorization Bearer Token
     *
     * @apiResource App\Http\Resources\Article\ArticleResource
     * @apiResourceModel App\Models\Article
     * @responseFile 404 scenario="not found article " responses/not_found.json
     * */
    public function show(Article $article)
    {
        return ok_response(new ArticleResource($article));
    }

    private function all($request){
        return collectionFormat(ArticleResource::class, $this->articleRepository->getArticlesLimited($request));
    }
}
