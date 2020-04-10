<?php

namespace App\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface BaseRepositoryInterface
 *
 * @package App\Repositories
 */
interface RepositoryInterface
{
    /**
     * Get's a model by it's ID
     *
     * @param int
     */
    public function findById(int $id);

    /**
     * Get's all models.
     *
     * @return mixed
     */
    public function all();

    /**
     * Deletes a model.
     *
     * @param int
     */
    public function delete($model_id);

    /**
     * Updates a model.
     *
     * @param int
     * @param array
     */
    public function update($model_id, array $model_data);

    /**
     * Updates a model.
     *
     * @param int
     * @param array
     */
    public function create(array $model_data);
}