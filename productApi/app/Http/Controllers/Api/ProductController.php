<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Traits\HasApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use HasApiResponseTrait;

    public function index(): JsonResponse
    {
        try {
            $limit = \request()->query('limit',10);
            $products = Product::where('status',Product::ACTIVE)->orderBy('id','desc')->paginate($limit);

            return $this->responseForCollection('Product list',ProductResource::collection($products));
        }catch (\Throwable $throwable){
            return $this->responseWithError($throwable->getMessage());
        }

    }


    public function store(CreateRequest $request): JsonResponse
    {
        try {
            $data = [
                'title'         => $request->title,
                'price'         => $request->price,
                'description'   => $request->description,
                'category_id'   => $request->category_id,
            ];
            if($request->hasFile('image')){
                $file = $request->file('image');
                $fileName = uniqid('product_' . strtotime(date('y-m-d')), true) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('/product', $fileName);
                $data['image'] = $fileName;
            }

            $product = Product::create($data);

            return $this->responseWithSuccess('Product created successfully',new ProductResource($product));
        }catch (\Throwable $throwable){
            return $this->responseWithError($throwable->getMessage());
        }
    }


    public function show(Product $product): JsonResponse
    {
        try{
            return $this->responseWithSuccess('Product deleted successfully',new ProductResource($product));
        }catch (\Throwable $throwable){
            return $this->responseWithError($throwable->getMessage());
        }

    }

    public function update(UpdateRequest $request,Product $product): JsonResponse
    {
        try {
            $data = [
                'title'         => $request->title,
                'price'         => $request->price,
                'description'   => $request->description,
                'category_id'   => $request->category_id,
                'status'        => $request->status
            ];
            if($request->hasFile('image')){
                $file = $request->file('image');
                $fileName = uniqid('product_' . strtotime(date('y-m-d')), true) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('/product', $fileName);
                $data['image'] = $fileName;
            }
            $product->update($data);
            return $this->responseWithSuccess('Product updated successfully',new ProductResource($product));
        }catch (\Throwable $throwable){
            return $this->responseWithError($throwable->getMessage());
        }
    }

    public function destroy(Product $product): JsonResponse
    {
        try{
            $product->delete();
            return $this->responseWithSuccess('Product deleted successfully',$product);
        }catch (\Throwable $throwable){
            return $this->responseWithError($throwable->getMessage());
        }

    }
}
