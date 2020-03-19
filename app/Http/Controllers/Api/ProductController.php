<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Product;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index(Request $request)
    {
        $products = $this->product;
        $productRepository = new ProductRepository($products);

        if ($request->has('q')){
            $productRepository->productFilter($request->get('q'));
        }

        if($request->has('filter')) {
            $productRepository->fieldFilter($request->get('filter'));
        }

        if($request->has('sort')){
            $productRepository->sort($request->get('sort'), $request->get('direction'));
        }

        return new ProductCollection($productRepository->getResult()->paginate(10));
    }


    public function show($id)
    {
        $product = $this->product->find($id);

        return new ProductResource($product);
    }

    public function store(ProductRequest $request)
    {
        $data = $request->all();

        try{

            $product = $this->product->create($data);

            return response()->json([
                'data' => [
                    'message' => 'Product successfully added'
                ]
            ],201);
        }catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(),401);
        }
    }

    public function update($id, ProductRequest $request)
    {
        $data = $request->all();
        try{
            $product = $this->product->find($id);
            $product->update($data);

            return response()->json([
                'data' => [
                    'message' => 'Product successfully changed'
                ]
            ],200);
        }catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(),401);
        }
    }

    public function destroy($id)
    {
        $product = $this->product->find($id);
        $product->delete();

        return response()->json([
            'data' => [
                'message' => 'Product successfully removed'
            ]
        ]);
    }

}
