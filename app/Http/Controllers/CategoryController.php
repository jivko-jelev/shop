<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $category
     * @return void
     */
    public function store(CategoryRequest $category)
    {

        Category::create([
            'title'     => $category->title,
            'alias'     => $category->alias,
            'parent_id' => $category->parent_id,
        ]);

        return response()->json();
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


        $filter = $request->get('search')['value'];
        $categories->when($filter, function ($query) use ($filter) {
            $query->where(function ($query) use ($filter) {
                $query->where('title', 'like', "%{$filter}%")
                      ->orWhere('alias', 'like', "%{$filter}%");
            });
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
}
