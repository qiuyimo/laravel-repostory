<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PostRepository;
use App\Entities\Post;
use App\Validators\PostValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Repository\Traits\CacheableRepository;
use Prettus\Repository\Contracts\Transformable;
use App\Presenters\PostPresenter;

/**
 * Class PostRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PostRepositoryEloquent extends BaseRepository implements PostRepository, CacheableInterface
{
    use CacheableRepository;

    protected $cacheMinutes = 90;

    /**
     * @return string
     */
    public function presenter()
    {
        return PostPresenter::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Post::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PostValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        try {
            $this->pushCriteria(app(RequestCriteria::class));
        } catch (RepositoryException $e) {
            dd($e->getMessage());
        }
    }

    public function getLastPost()
    {
        return $this->model->latest()->first();
    }
    
}
