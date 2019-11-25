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
            'title'      => 'Създаване на категория',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $category
     * @return void
     */
    public function store(CategoryRequest $category)
    {
        $cat             = new Category;
        $cat->title      = $category->title;
        $cat->alias      = $category->alias;
        $cat->parent_id  = $category->parent_id;
        $cat->updated_at = null;
        $cat->save();

        foreach ($category->property_name as $key => $property) {
            if ($property && self::haveSubProperties($category->sub_property[$key])) {
                $property = Property::create([
                    'name'        => $property,
                    'category_id' => $cat->id,
                ]);

                $subProperties = explode(PHP_EOL, $category->sub_property[$key]);;
                $data = [];
                foreach ($subProperties as $subPropertyKey => $subProperty) {
                    if (trim($subProperty) != '') {
                        $data[] = [
                            'name'        => (($subPropertyKey == count($subProperties) - 1)
                                ? $subProperty : mb_substr($subProperty, 0, mb_strlen($subProperty) - 1)),
                            'property_id' => $property->id,
                        ];
                    }
                }
                SubProperty::insert($data);
            }
        }
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

        $c = Category::get()->pluck('title', 'id')->toArray();
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
     * @return Response
     * @throws Throwable
     */
    public function edit(Category $category)
    {
        return view('admin.categories.modal.category', [
            'categories'       => Category::all(),
            'current_category' => $category,
        ])->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Category        $category
     * @param Request         $request
     * @param CategoryRequest $categoryRequest
     * @return Response
     */
    public function update(Category $category, Request $request, CategoryRequest $categoryRequest)
    {
        $category->title     = $request->get('title');
        $category->alias     = $request->get('alias');
        $category->parent_id = $request->get('parent_id') ?? null;

        $category->save();

        if ($request->ajax()) {
            return response()->json('{"message": "Категорията беше успешно редактирана."}');
        }

        return redirect()->back()->with('message', 'Категорията беше успешно редактирана.');
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
