<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 *
 * @package App\Repositories
 */
class BaseRepository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function findById(int $id)
    {
        return $this->model->where('id', $id)->first();
    }

    /**
     * Get's all users.
     *
     * @return mixed
     */
    public function all() 
    {
        return $this->model->all();
    }

    /**
     * Deletes a model.
     *
     * @param int
     */
    public function delete($model_id)
    {
        return $this->model->where('id',$model_id)->delete();
    }

    /**
     * Updates a model.
     *
     * @param int
     * @param array
     */
    public function update($model_id, array $model_data)
    {
        return $this->model->find($model_id)->update($model_data);
    }

    /**
     * Updates a model.
     *
     * @param array
     */
    public function create(array $model_data)
    {
        return $this->model->create($model_data);
    }
}