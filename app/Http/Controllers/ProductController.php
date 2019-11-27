<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\ProductSubProperties;
use App\Property;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function index($categoryName, Request $request)
    {
        try {
            $category = Category::where('alias', $categoryName)->first()->id;
        } catch (\Exception $e) {
            abort(404);
        }

        $properties = Property::with('subProperties')
                              ->where('category_id', $category)
                              ->get();

        $products = Product::with(['picture' => function ($query) {
            $query->with('thumbnails');
        }, 'subProperties',
        ])
                           ->select('products.*')
                           ->distinct('products.id')
                           ->when($request->get('check'), function ($query) use ($request, $category) {
                               $props = Property::select('properties.id', 'sub_properties.id as sub_id')
                                                ->where('category_id', $category)
                                                ->join('sub_properties', 'sub_properties.property_id', 'properties.id')
                                                ->whereIn('sub_properties.id', $request->get('check'))
                                                ->get();

                               foreach ($props->pluck('id')->unique() as $prop) {
                                   $query->whereHas('subProperties', function ($query) use ($props, $prop) {
                                       $query->where(function ($query) use ($props, $prop) {
                                           foreach ($props as $s) {
                                               if ($s->id == $prop) {
                                                   $query->orWhere('subproperty_id', $s->sub_id);
                                               }
                                           }
                                       });
                                   });
                               }
                           })
                           ->whereHas('category', function ($query) use ($category) {
                               $query->where('id', $category);
                           });

        if ($request->get('order-by')) {
            $order = explode('-', $request->get('order-by'));
            if (($order[0] == 'name' || $order[0] == 'price') && ($order[1] == 'asc' || $order[1] == 'desc')) {
                $products = $products->orderBy($order[0], $order[1]);
            } else {
                // Най-високо оценени
//                $products = $products->orderBy(explode('-', )[0], explode('-', $request->get('order-by'))[1]);
            }
        } else {
            $products = $products->orderBy('price');
        }

        $limit = ($request->get('per-page') == 50 || $request->get('per-page') == 100 ? $request->get('per-page') : 20);

        $prices = Product::selectRaw('min(price) as min_price, max(price) as max_price')
                         ->where('category_id', $category)
                         ->first();

        $products = $products->paginate($limit);
        if ($request->ajax()) {
            return response()->json([
                'check'      => $request->all(),
                'view'       => view('products', [
                    'products'     => $products,
                    'properties'   => $properties,
                    'prices'       => $prices,
                    'categoryName' => $categoryName,
                ])->render(),
                'pagination' => view('partials.pagination', ['products' => $products])->render(),
            ]);
        }

//        dd($products);
        return view('category', [
            'products'     => $products,
            'categories'   => Category::all(),
            'properties'   => $properties,
            'prices'       => $prices,
            'categoryName' => $categoryName,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function indexAdmin()
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
            'picture_id'  => $productRequest->picture_id,
            'price'       => $productRequest->price,
            'promo_price' => $productRequest->promo_price,
            'permalink'   => self::generatePermanlink($productRequest->title),
        ]);

        $productSubProperties = [];
        foreach ($productRequest->sub_properties as $item) {
            $productSubProperties[] = [
                'product_id'     => $product->id,
                'subproperty_id' => $item,
            ];
        }

        ProductSubProperties::insert($productSubProperties);

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
        $products        = Product::with(['category:id,title,alias'])->select('id', 'name', 'category_id', 'created_at');
        $recordsTotal    = Product::all()->count();
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

        $products = $products->skip($request->input('start'))
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
