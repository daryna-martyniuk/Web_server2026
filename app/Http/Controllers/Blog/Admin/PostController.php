<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
//use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Repositories\BlogPostRepository;
use Illuminate\Support\Str;
//use Illuminate\Http\Request;
use App\Http\Requests\BlogCategoryUpdateRequest;

class PostController extends BaseController{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private BlogPostRepository $blogPostRepository)
    {
        //parent::__construct();
    }

    public function index()
    {
        $paginator = $this->blogPostRepository->getAllWithPaginate();

        return $paginator;
        //dd(__METHOD__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {

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
    public function update()
    {
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
