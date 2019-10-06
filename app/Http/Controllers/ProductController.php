<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\ProductRequest;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.products.index', [
            'title' => 'Списък на продуктите',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', [
            'title'      => 'Създаване на продукт',
            'categories' => $categories,
        ]);
    }

    public static function generatePermanlink(string $title): string
    {
        $title      = Product::sanitize(Product::cyrillicToLatin(mb_strtolower($title)));
        $permalinks = Product::select('permalink')->where('permalink', 'like', $title . '%')->get();
        if ($permalinks->where('permalink', '=', $title)->count() == 0) {
            return $title;
        } else {
            $counter = 0;
            while ($permalinks->where('permalink', '=', $title . '-' . ++$counter)->count() > 0) {
            }

            return $title . '-' . $counter;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param ProductRequest           $productRequest
     * @return Response
     */
    public function store(ProductRequest $productRequest)
    {
        $product = Product::create([
            'name'        => $productRequest->title,
            'category_id' => $productRequest->category,
            'description' => $productRequest->description,
            'permalink'   => self::generatePermanlink($productRequest->title),
        ]);

        return response()->json(['url' => route('products.edit', ['product' => $product])]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Product $product
     * @return Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Product $product
     * @return Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product'    => $product,
            'title'      => 'Създаване на продукт',
            'categories' => Category::all(),
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Product        $product
     * @param ProductRequest $productRequest
     * @return void
     */
    public function update(Product $product, ProductRequest $productRequest)
    {
        $product->name        = $productRequest->title;
        $product->category_id = $productRequest->category;
        $product->description = $productRequest->description;
        $product->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return void
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $product->delete();
    }

    public function ajax(Request $request)
    {
        $products = Product::with(['category:id,title,alias'])->select('id', 'name', 'category_id', 'created_at');
        $recordsTotal = Product::all()->count();
        $recordsFiltered = $products->count();

        $ajaxGridColumnNames = [
            0 => 'name',
            1 => 'category_id',
            2 => 'created_at',
        ];

        $products->whereLikeIf('name', $request->get('name'))
                 ->when($request->get('category_id'), function ($query) use ($request) {
                     $query->whereHas('category', function ($query) use ($request) {
                         $query->where('title', 'like', "%{$request->get('category_id')}%");
                     });
                 })
                 ->whereDateGreaterIf('created_at', $request->get('created_at_from'))
                 ->whereDateLessIf('created_at', $request->get('created_at_to'));

        $orderState = $request->get('order');
        foreach ($orderState as $singleOrderState) {
            $products->orderBy($ajaxGridColumnNames[$singleOrderState['column']], $singleOrderState['dir']);
        }

        $products     = $products->skip($request->input('start'))
                                 ->take($request->input('length'))
                                 ->get();

        foreach ($products as $product) {
            $product->actions     = view('admin.products.layouts.actions')->with('product', $product)->render();
            $product->category_id = "{$product->category->title} ({$product->category->alias})";
        }

        return response()->json([
            'data'            => $products,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
        ]);
    }
}
