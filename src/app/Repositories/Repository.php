<?php

namespace App\Repositories;

use App\EAV\Entity;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\AssignOp\Mod;

abstract class Repository
{
    /**
     * The eloquent model instance
     *
     * @var Model|mixed
     */
    protected Model $model;

    /**
     * Create a new repository instance
     *
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->model = app()->make($this->model());
    }

    /**
     * Get one record by id
     *
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Update existing record by id
     *
     * @param int $id
     * @param array $attributes
     * @return Model
     */
    public function update(int $id, array $attributes): Model
    {
        $this->find($id)->update($attributes);

        return $this->find($id);
    }

    /**
     * Delete one record by id
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return (bool) $this->find($id)->delete();
    }

    /**
     * Get the eloquent model instance
     *
     * @return Model
     */
    public function eloquent(): Model
    {
        return $this->model;
    }

    /**
     * Get eloquent model abstract
     *
     * @return string
     */
    abstract public function model(): string;
}
