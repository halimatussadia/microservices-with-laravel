<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Traits\HasApiResponseTrait;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use HasApiResponseTrait;

    public function index(): JsonResponse
    {
        try {
            $limit = \request()->query('limit',10);
            $categories = Category::where('status',Category::ACTIVE)->orderBy('id','desc')->paginate($limit);

            return $this->responseForCollection('Category list',CategoryResource::collection($categories));
        }catch (\Throwable $throwable){
            return $this->responseWithError($throwable->getMessage());
        }

    }


    public function store(CreateRequest $request): JsonResponse
    {
        try {
            $category = Category::create($request->all());
            return $this->responseWithSuccess('Category created successfully',new CategoryResource($category));
        }catch (\Throwable $throwable){
            return $this->responseWithError($throwable->getMessage());
        }
    }


    public function update(UpdateRequest $request,Category $category): JsonResponse
    {
        try {
            $category->update([
               'name'           => $request->name,
               'description'    => $request->description,
               'status'         => $request->status,
            ]);
            return $this->responseWithSuccess('Category updated successfully',new CategoryResource($category));
        }catch (\Throwable $throwable){
            return $this->responseWithError($throwable->getMessage());
        }
    }

    public function destroy(Category $category): JsonResponse
    {
        try{
            $category->delete();
            return $this->responseWithSuccess('Category deleted successfully',$category);
        }catch (\Throwable $throwable){
            return $this->responseWithError($throwable->getMessage());
        }

    }


}
