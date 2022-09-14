<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\CustomerCollection;
use App\Http\Resources\Customer\CustomerResource;
use App\Models\Customer;
use App\Traits\HasApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    use HasApiResponseTrait;

    public function index(): JsonResponse
    {
        try {
            $limit = \request()->query('limit',10);
            $customers = Customer::orderBy('id','desc')->paginate($limit);
            return $this->responseForCollection('Customer list', new CustomerCollection($customers));

        }catch (\Throwable $throwable){
            return $this->responseWithError($throwable);
        }

    }


    public function store(Request $request): JsonResponse
    {
        try {
            $data = [
                'name'          => $request->name,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'address'       => $request->address,
            ];
            if($request->hasFile('image')){
                $file = $request->file('image');
                $fileName = uniqid('customer_' . strtotime(date('y-m-d')), true) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('/customer', $fileName);
                $data['image'] = $fileName;
            }

            $customer = Customer::create($data);

            return $this->responseWithSuccess('Customer created successfully',new CustomerResource($customer));
        }catch (\Throwable $throwable){
            return $this->responseWithError($throwable->getMessage());
        }
    }


    public function view(Customer $customer): JsonResponse
    {
        try{
            return $this->responseWithSuccess('Customer details',new CustomerResource($customer));
        }catch (\Throwable $throwable){
            return $this->responseWithError($throwable->getMessage());
        }

    }

    public function update(Request $request,Customer $customer): JsonResponse
    {
        try {
            if($request->hasFile('image')){
                $file = $request->file('image');
                $fileName = uniqid('customer_' . strtotime(date('y-m-d')), true) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('/customer', $fileName);
                $data['image'] = $fileName;
            }
            $data = [
                'name'          => $request->name,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'address'       => $request->address,
            ];
            if($request->hasFile('image')){
                $file = $request->file('image');
                $fileName = uniqid('customer_' . strtotime(date('y-m-d')), true) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('/customer', $fileName);
                $data['image'] = $fileName;
            }
            $customer->update($data);
            return $this->responseWithSuccess('Customer updated successfully',new CustomerResource($customer));
        }catch (\Throwable $throwable){
            return $this->responseWithError($throwable->getMessage());
        }
    }

    public function delete(Customer $customer): JsonResponse
    {
        try{
            $customer->delete();
            return $this->responseWithSuccess('Customer deleted successfully',$customer);
        }catch (\Throwable $throwable){
            return $this->responseWithError($throwable->getMessage());
        }

    }
}
