<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use App\Property;
use App\SubProperty;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.categories.index', ['title' => 'Категории']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.categories.create', [
            'categories' => Category::all(),
            'route'      => route('categories.store'),
            'method'     => 'post',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $category)
    {
        $cat             = new Category;
        $cat->title      = $category->title;
        $cat->alias      = mb_strtolower($category->alias);
        $cat->parent_id  = $category->parent_id;
        $cat->updated_at = null;
        $cat->save();

        $category->createProperties($cat->id);

        return response()->json([
            'content' => view('admin.categories.edit-content', [
                    'categories' => Category::all(),
                    'route'      => route('categories.store'),
                ]
            )->render(),
            'message' => 'Категорията беше успешно записана']);
    }

    public static function haveSubProperties(string $subProperties): bool
    {
        $subProperties = explode(PHP_EOL, $subProperties);
        foreach ($subProperties as $subProperty) {
            if (trim($subProperty) != '') {
                return true;
            }
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return Response
     */
    public function show(Category $category)
    {
        //
    }


    public function ajax(Request $request)
    {
        $categories = Category::select('id', 'title', 'parent_id', 'alias');

        $ajaxGridColumnNames = [
            0 => 'title',
            1 => 'alias',
            2 => 'parent_id',
        ];

        $categories->whereLikeIf('title', $request->get('title'))
                   ->whereLikeIf('alias', $request->get('alias'))
                   ->when($request->get('parent'), function ($query) use ($request) {
                       $parentCategories = Category::where('title', 'like', "%{$request->get('parent')}%")->pluck('id');
                       $query->whereIn('parent_id', $parentCategories);
                   });

        $orderState = $request->get('order');
        foreach ($orderState as $singleOrderState) {
            $categories->orderBy($ajaxGridColumnNames[$singleOrderState['column']], $singleOrderState['dir']);
        }

        $categories   = $categories->get();
        $recordsTotal = $recordsFiltered = $categories->count();

        $c = Category::all()->pluck('title', 'id')->toArray();
        foreach ($categories as $category) {
            $category->actions = view('admin.categories.layouts.actions')->with('category', $category)->render();
            if ($category->parent_id) {
                $category->parent_id = $c[$category->parent_id];
            }
        }

        return response()->json([
            'data'            => $categories,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return array|string
     * @throws Throwable
     */
    public function edit(Category $category)
    {
        return view('admin.categories.modal.category', [
            'categories'       => Category::all(),
            'current_category' => $category,
        ])->render();
    }

    public function fullEdit(Category $category)
    {
        $properties = Property::where('category_id', $category->id)
                              ->with('subProperties')
                              ->get();

        return view('admin.categories.edit', [
            'categories' => Category::all(),
            'category'   => $category,
            'properties' => $properties,
            'route'      => route('categories.update', $category),
            'method'     => 'put',
        ])->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Category        $category
     * @param Request         $request
     * @param CategoryRequest $categoryRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws Throwable
     */
    public function update(Category $category, Request $request, CategoryRequest $categoryRequest)
    {
        $category->title     = $request->get('title');
        $category->alias     = $request->get('alias');
        $category->parent_id = $request->get('parent_id');
        $category->save();

        if ($request->get('property')) {
            foreach ($request->get('property') as $key => $property) {
                Property::where('id', $key)
                        ->update(['name' => $property]);
            }
        }

        if ($request->get('subproperty')) {
            $data = [];
            foreach ($request->get('subproperty') as $key => $property) {
                foreach ($property as $key1 => $subProperty) {
                    SubProperty::where('id', $key1)
                               ->update(['name' => $subProperty]);
                }
            }
            SubProperty::insert($data);
        }

        $categoryRequest->createProperties($category->id);

        if ($request->get('new_subproperty')) {
            $data = [];
            foreach ($request->get('new_subproperty') as $key => $property) {
                foreach ($property as $newSubproperty) {
                    $data[] = [
                        'name'        => $newSubproperty,
                        'property_id' => $key,
                    ];
                }
            }
            SubProperty::insert($data);
        }

        $properties = Property::where('category_id', $category->id)
                              ->with('subProperties')
                              ->get();

        return response()->json([
            'message' => 'Категорията беше успешно редактирана.',
            'content' => view('admin.categories.edit-content', ['categories' => Category::all(),
                                                                'category'   => $category,
                                                                'properties' => $properties,
                                                                'route'      => route('categories.update', $category),
            ])->render(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return void
     * @throws Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();
    }

    public function getProperties(Category $category)
    {
        $properties = Property::with('subProperties')
                              ->where('category_id', $category->id)
                              ->get();

        return view('admin.products.layouts.properties', compact('properties'))->render();
    }

}
