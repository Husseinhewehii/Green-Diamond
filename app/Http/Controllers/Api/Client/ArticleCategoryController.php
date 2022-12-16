<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleCategory\ArticleCategoryResource;
use App\Models\ArticleCategory;
use App\Repositories\ArticleCategory\ArticleCategoryRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Article Category Module
 */
class ArticleCategoryController extends Controller
{
    protected $articleCategoryRepository;

    public function __construct(ArticleCategoryRepository $articleCategoryRepository) {
        $this->articleCategoryRepository = $articleCategoryRepository;
    }

    /**
     * Get All Article Categories
     *
     *
     * @queryParam filter[type] Filter by type which is 1 for blogs or 2 for news. Example: type
     * @queryParam limit decide how many Article Categories You Need . Example: 5
     *
     * @apiResourceCollection App\Http\Resources\ArticleCategory\ArticleCategoryResource
     * @apiResourceModel App\Models\ArticleCategory
     */
    public function index(Request $request)
    {
        return ok_response($this->all($request));
    }

    private function all($request){
        return collectionFormat(ArticleCategoryResource::class, $this->articleCategoryRepository->getArticleCategoriesLimited($request));
    }
}
