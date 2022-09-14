<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

trait HasApiResponseTrait
{
    protected function responseWithSuccess(string $message ,  $data= null, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success'   => true,
            'message'   => $message,
            'data'      => $data
        ],$statusCode);
    }


    protected function responseWithError(string $message , $data= null, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success'   => false,
            'message'   => $message,
            'data'      => $data
        ],$statusCode);
    }


    public function responseForCollection(string $message,JsonResource $resourceCollection,int $statusCode = 200): JsonResponse
    {
        $response = $resourceCollection->response()->getData();
        return response()->json([
            'success'   => true,
            'message'   => $message,
            'data'      => $response->data,
            'meta'      => $response->meta
        ],$statusCode);
    }

}
