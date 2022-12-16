<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Partition\PartitionResource;
use App\Models\Partition;
use App\Repositories\Partition\PartitionRepository;
use Illuminate\Http\Request;

/**
 * @group Partition Module
 */
class PartitionController extends Controller
{
    protected $partitionsRepository;

    public function __construct(PartitionRepository $partitionsRepository) {
        $this->partitionsRepository = $partitionsRepository;
    }

    /**
     * Get All Partitions
     *
     * @queryParam sort Sort Field by key, group, title, sub_title, description, short_description, active. Example: key,group,title,sub_title,description,short_description,active
     * @queryParam filter[key] Filter by key. Example: key
     * @queryParam filter[group] Filter by group. Example: group
     * @queryParam filter[title] Filter by title. Example: title
     * @queryParam filter[sub_title] Filter by sub_title. Example: sub_title
     * @queryParam filter[description] Filter by description. Example: description
     * @queryParam filter[short_description] Filter by short_description. Example: short_description
     * @queryParam filter[active] Filter by active. Example: active
     *
     * @apiResourceCollection App\Http\Resources\Partition\PartitionResource
     * @apiResourceModel App\Models\Partition
     */
    public function index()
    {
        return ok_response(collectionFormat(PartitionResource::class, $this->partitionsRepository->getPartitionsWithoutPagination()));
    }
}
