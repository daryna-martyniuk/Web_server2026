<?php

namespace App\Http\Controllers\Blog\Admin;

//use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends BaseController{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginator = BlogCategory::paginate(5);

        return $paginator;
        //dd(__METHOD__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $item = BlogCategory::create($data);

        if ($item) {
            return response()->json([
                'success' => 'Категорію успішно створено',
                'data' => $item
            ], 201);
        } else {
            return response()->json([
                'msg' => 'Помилка збереження категорії'
            ], 400);
        }
        //dd(__METHOD__);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        //dd(__METHOD__);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = BlogCategory::find($id);
        if (empty($item)) { //якщо ід не знайдено
            return back() //redirect back
            ->withErrors(['msg' => "Запис id=[{$id}] не знайдено"]) //видати помилку
            ->withInput(); //повернути дані
        }

        $data = $request->all(); //отримаємо масив даних, які надійшли з форми
        if (empty($data['slug'])) { //якщо псевдонім порожній
            $data['slug'] = Str::slug($data['title']); //генеруємо псевдонім
        }

        $result = BlogCategory::where('slug', $data['slug'])->where('id', '!=', $id)->exists() ? false : $item->update($data);
        if ($result) {
            return response()->json([
                'success' => 'Категорію успішно оновлено',
                'data' => $item
            ], 200);
        } else {
            return response()->json([
                'msg' => 'Помилка збереження'
            ], 400);
        }
        //dd(__METHOD__);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        //dd(__METHOD__);
    }
}
