<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use App\Http\Resources\Api\Blog\Admin\CategoryResource;
//use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BlogCategoryDeleteRequest;

class CategoryController extends BaseController{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private BlogCategoryRepository $blogCategoryRepository)
    {
        //parent::__construct();

    }
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search');

        $paginator = $this->blogCategoryRepository->getAllWithPaginate($perPage, $search);

        return CategoryResource::collection($paginator);
        //dd(__METHOD__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input(); //отримаємо масив даних, які надійшли з форми

        $item = (new BlogCategory())->create($data); //створюємо об'єкт і додаємо в БД

        if ($item) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data'    => $item
            ];
        } else {
            return ['message' => 'Помилка збереження'];
        }

        //dd(__METHOD__);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);

        if (empty($item)) {
            return response()->json([
                'message' => "Запис id=[{$id}] не знайдено в admin-панелі"
            ], 404);
        }

        return new CategoryResource($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
       // $item = BlogCategory::find($id);
        $item = $this->blogCategoryRepository->getEdit($id);
        if (empty($item)) {
            return response([
                'message' => "Запис id=[{$id}] не знайдено"
            ], 404);
        }

        $data = $request->all(); //отримаємо масив даних, які надійшли з форми

        $result = $item->update($data);
        if ($result) {
            return [
                'success' => 'Категорію успішно оновлено',
                'data' => $item
            ];
        } else {
            return [
                'message' => 'Помилка збереження'
            ];
        }
        //dd(__METHOD__);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategoryDeleteRequest $request, $id)
    {
        $result = BlogCategory::destroy($id);

        if ($result) {
            return [
                'success' => true,
                'message' => "Категорію з id [{$id}] успішно видалено!"
            ];
        } else {
            return [
                'success' => false,
                'message' => "Помилка видалення або категорію вже було видалено"
            ];
        }
        //dd(__METHOD__);
    }

    public function allList()
    {
        $categories = $this->blogCategoryRepository->getForComboBox();

        return response()->json($categories);
    }
}
