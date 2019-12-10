<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\ProductPictures;
use App\ProductSubProperties;
use App\Property;
use App\SubProperty;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function index($categoryName, Request $request)
    {
        try {
            $categories = Category::all();
            $category   = $categories->where('alias', $categoryName)->first();

            $properties = Property::with('subProperties')
                                  ->where('category_id', $category->id)
                                  ->get();

            $products = Product::with(['picture' => function ($query) {
                $query->with('thumbnails');
            }, 'subProperties',])
                               ->select('products.*')
                               ->selectRaw('IFNULL(promo_price, price) AS order_price')
                               ->when($request->get('min_price'), function ($query) use ($request) {
                                   $query->where('price', '>=', $request->get('min_price'));
                               })
                               ->when($request->get('max_price'), function ($query) use ($request) {
                                   $query->whereRaw("IFNULL(`promo_price`, `price`) <={$request->get('max_price')}");
                               })
                               ->when($request->get('filter'), function ($query) use ($request) {
                                   foreach ($request->get('filter') as $subProperties) {
                                       $query->whereHas('subProperties', function ($query) use ($subProperties) {
                                           $query->where(function ($query) use ($subProperties) {
                                               foreach ($subProperties as $subProperty) {
                                                   $query->orWhere('subproperty_id', $subProperty);
                                               }
                                           });
                                       });
                                   }
                               })
                               ->whereHas('category', function ($query) use ($category) {
                                   $query->where('id', $category->id);
                               });

            if ($request->get('order-by')) {
                $order = explode('-', $request->get('order-by'));
                if ($order[0] == 'newest') {
                    $products = $products->orderBy('created_at', 'DESC');
                } elseif (in_array($order[0], ['name', 'order_price']) &&
                          in_array($order[1], ['asc', 'desc'])) {
                    $products = $products->orderBy($order[0], $order[1]);
                } elseif ($request->get('order-by') == 'promo') {
                    $products = $products->orderByRaw('IF(promo_price IS NULL, 1, 0), RAND(promo_price), created_at DESC');
                }
            } else {
                $products = $products->orderBy('created_at', 'DESC');
            }

            $limit = in_array($request->get('per-page'), [50, 100]) ? $request->get('per-page') : 20;

            $prices = Product::selectRaw('MIN(price) AS min_price, MAX(IFNULL(promo_price, price)) as max_price')
                             ->where('category_id', $category->id)
                             ->first();

            $products = $products->paginate($limit);
            if ($request->ajax()) {
                return response()->json([
                    'view'       => view('products', [
                        'products'     => $products,
                        'properties'   => $properties,
                        'prices'       => $prices,
                        'categoryName' => $categoryName,
                    ])->render(),
                    'products'   => $products,
                    'pagination' => view('layouts.pagination', ['products' => $products])->render(),
                ]);
            }

            return view('category', [
                'products'      => $products,
                'categories'    => Category::all(),
                'properties'    => $properties,
                'prices'        => $prices,
                'categoryName'  => $categoryName,
                'categoryTitle' => $category->title,
            ]);
        } catch (\Exception $e) {
            abort(404);
        }

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', [
            'title'      => 'Създаване на продукт',
            'categories' => $categories,
            'route'      => route('products.store'),
            'method'     => 'post',
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
     * @param ProductRequest $productRequest
     * @return Response
     */
    public function store(ProductRequest $productRequest)
    {
        $product = Product::create([
            'name'        => $productRequest->title,
            'category_id' => $productRequest->category,
            'description' => $productRequest->description,
            'picture_id'  => $productRequest->picture_id[0],
            'price'       => $productRequest->price,
            'promo_price' => $productRequest->promo_price,
            'permalink'   => self::generatePermanlink($productRequest->title),
            'type'        => $productRequest->type,
        ]);

        if ($productRequest->pictures_id) {
            $data = [];
            foreach ($productRequest->pictures_id as $item) {
                $data[] = [
                    'product_id' => $product->id,
                    'picture_id' => $item,
                ];
            }
            ProductPictures::insert($data);
        }

        if ($productRequest->sub_properties) {
            $productSubProperties = [];
            foreach ($productRequest->sub_properties as $item) {
                $productSubProperties[] = [
                    'product_id'     => $product->id,
                    'subproperty_id' => $item,
                ];
            }

            ProductSubProperties::insert($productSubProperties);
        }

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Product $product)
    {
        $product = Product::with(['pictures.thumbnails', 'subproperties'])
                          ->find($product->id);

        $properties = Property::with('subProperties')
                              ->where('category_id', $product->category_id)
                              ->get();

        return view('admin.products.create', [
            'product'    => $product,
            'title'      => 'Редактиране на продукт',
            'categories' => Category::all(),
            'route'      => route('products.update', $product->id),
            'method'     => 'put',
            'properties' => $properties,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Product        $product
     * @param ProductRequest $productRequest
     * @return JsonResponse
     */
    public function update(Product $product, ProductRequest $productRequest)
    {
        if ($product->category_id != $productRequest->category) {
            Property::where('product_id', $product->id)->delete();
        }
        $product->name        = $productRequest->title;
        $product->category_id = $productRequest->category;
        $product->description = $productRequest->description;
        $product->picture_id  = $productRequest->picture_id[0];
        $product->type        = $productRequest->type;
        $product->update();

        if ($productRequest->sub_properties) {
            $subproperties = ProductSubProperties::where('product_id', $product->id)->get();
//            $data          = [];
//            foreach ($productRequest->sub_properties as $productSubProperty) {
//                $data[] = [
//                    'product_id'     => $product->id,
//                    'subproperty_id' => $productSubProperty,
//                ];
//            }
//            ProductSubProperties::insert($data);
        } else {
            ProductSubProperties::where('product_id', $product->id)->delete();
        }


        if ($productRequest->pictures_id) {
            $pictures = ProductPictures::where('product_id', $product->id)->get();
            if (count($pictures) > 0) {
                $count = 0;
                foreach ($pictures as $key => $picture) {
                    if (++$count > count($productRequest->pictures_id)) {
                        break;
                    }
                    $picture->picture_id = $productRequest->pictures_id[$key];
                    $picture->update();
                }

                if (count($pictures) < count($productRequest->pictures_id)) {
                    $data = [];
                    for ($i = $count; $i < count($productRequest->pictures_id); $i++) {
                        $data[] = [
                            'product_id' => $product->id,
                            'picture_id' => $productRequest->pictures_id[$i],
                        ];
                    }
                    ProductPictures::insert($data);

                } elseif (count($pictures) > count($productRequest->pictures_id)) {
                    $picturesForDelete = [];
                    for ($i = $count - 1; $i < count($pictures); $i++) {
                        $picturesForDelete[] = $pictures[$i]->id;
                    }
                    ProductPictures::whereIn('id', $picturesForDelete)->delete();
                }
            } else {
                $data = [];
                foreach ($productRequest->pictures_id as $item) {
                    $data[] = [
                        'product_id' => $product->id,
                        'picture_id' => $item,
                    ];
                }
                ProductPictures::insert($data);
            }
        } else {
            ProductPictures::where('product_id', $product->id)->delete();
        }

        return response()->json(['message' => 'Продуктът беше успешно обновен.']);
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
        $products        = Product::with(['category:id,title,alias'])
                                  ->select('id', 'name', 'category_id', 'created_at');
        $recordsTotal    = Product::all()->count();
        $recordsFiltered = $products->count();

        $ajaxGridColumnNames = [
            0 => 'name',
            1 => 'category_id',
            2 => 'created_at',
        ];

        $products->whereLikeIf('name', $request->get('name'))
                 ->when($request->get('category'), function ($query) use ($request) {
                     $query->whereHas('category', function ($query) use ($request) {
                         $query->where('title', 'like', "%{$request->get('category')}%");
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
