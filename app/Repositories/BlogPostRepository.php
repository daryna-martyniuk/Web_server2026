<?php

namespace App\Repositories;

use App\Models\BlogPost as Model;
use Illuminate\Database\Eloquent\Collection;


/**
 * Class BlogСategoryRepository.
 */
class BlogPostRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class; //абстрагування моделі BlogCategory, для легшого створення іншого репозиторія
    }

    public function getPublishedWithPaginate($perPage = null, $search = null)
    {
        $perPage = (int) $perPage > 0 ? (int) $perPage : 10;

        $columns = ['id', 'title', 'slug', 'is_published', 'published_at', 'user_id', 'category_id'];

        return $this->startConditions()
            ->select($columns)
            ->where('is_published', 1)
            ->searchByField($search, 'title')
            ->orderBy('id', 'DESC')
            ->with([
                'category:id,title',
                'user:id,name',
            ])
            ->paginate($perPage);
    }

    public function getAllWithPaginate($perPage = null, $search = null)
    {
        $perPage = (int) $perPage > 0 ? (int) $perPage : 25;

        $columns = ['id', 'title', 'slug', 'is_published', 'published_at', 'user_id', 'category_id'];

        return $this->startConditions()
            ->select($columns)
            ->searchByField($search, 'title')
            ->orderBy('id', 'DESC')
            ->with([
                'category:id,title',
                'user:id,name',
            ])
            ->paginate($perPage);
    }

    /**
     *  Отримати модель для редагування в адмінці
     *  @param int $id
     *  @return Model
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }
}
