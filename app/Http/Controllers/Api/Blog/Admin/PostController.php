<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Http\Requests\BlogPostCreateRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Models\BlogPost;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogPostRepository;
use App\Jobs\BlogPostAfterCreateJob;
use App\Jobs\BlogPostAfterDeleteJob;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Http\Resources\Api\Blog\Admin\PostResource;
//use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
//use Carbon\Carbon;

class PostController extends BaseController{
    /**
     * Display a listing of the resource.
     */

    use DispatchesJobs;
    public function __construct(
        private BlogPostRepository $blogPostRepository,
        private BlogCategoryRepository $blogCategoryRepository // Властивість для категорій
    ) {
        //parent::__construct();
    }

    public function index()
    {
        // Отримуємо пагіновані дані з репозиторія
        $paginator = $this->blogPostRepository->getAllWithPaginate();

        // Обгортаємо пагінацію в API Ресурс
        return PostResource::collection($paginator);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogPostCreateRequest $request
    )
    {
        $data = $request->input(); //отримаємо масив даних, які надійшли з форми

        $item = (new BlogPost())->create($data); //створюємо об'єкт і додаємо в БД

        if ($item) {
            $job = new BlogPostAfterCreateJob($item);
            $this->dispatch($job);

            return ['success' => 'Успішно збережено',
                'data' => $item];
        } else {
            return ['msg' => 'Помилка збереження'];
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
    public function update(BlogPostUpdateRequest $request, $id)
    {
        $item = $this->blogPostRepository->getEdit($id);
        if (empty($item)) { //якщо ід не знайдено
            return ['message' => "Запис id=[{$id}] не знайдено"];
        }

        $data = $request->all(); //отримаємо масив даних, які надійшли з форми

//        if (empty($data['slug'])) { //якщо псевдонім порожній
//            $data['slug'] = Str::slug($data['title']); //генеруємо псевдонім
//        }
//        if (empty($item->published_at) && $data['is_published']) { //якщо поле published_at порожнє і нам прийшло 1 в ключі is_published, то
//            $data['published_at'] = Carbon::now(); //генеруємо поточну дату
//        }
        $result = $item->update($data); //оновлюємо дані об'єкта і зберігаємо в БД

        if ($result) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => $item
            ];
        } else {
            return ['message' => 'Помилка збереження'];
        }
        //dd(__METHOD__);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = BlogPost::destroy($id); //софт деліт, запис лишається

        //$result = BlogPost::find($id)->forceDelete(); //повне видалення з БД

        if ($result) {
            BlogPostAfterDeleteJob::dispatch($id)->delay(20);

            return ['success' => true,
                'message'=>"Статтю з id [{$id}] успішно видалено!"];
        } else {
            return ['success' => false,
                'message' => "Помилка видалення або статтю вже було видалено"];
        }
        //dd(__METHOD__);
    }
}
