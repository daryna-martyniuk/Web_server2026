<?php

namespace App\Http\Controllers\Api\Blog;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use App\Repositories\BlogPostRepository;
use App\Http\Resources\Api\Blog\Public\PostResource as PublicPostResource;
class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    private $blogPostRepository;
    public function __construct(BlogPostRepository $blogPostRepository)
    {
        $this->blogPostRepository = $blogPostRepository;
    }
    public function index(Request $request)
    {
        $perPage = $request->query('per_page');
        $search = $request->query('search');

        $paginator = $this->blogPostRepository->getPublishedWithPaginate($perPage, $search);
        return PublicPostResource::collection($paginator);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = $this->blogPostRepository->getEdit($id);

        if (!$post || !$post->is_published) {
            return response()->json(['message' => 'Статтю не знайдено'], 404);
        }

        $post->load(['category:id,title', 'user:id,name']);

        return new PublicPostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
