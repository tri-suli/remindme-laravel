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

    /**
     * Get the eloquent model as entity
     *
     * @return Entity
     */
    abstract public function toEntity(): Entity;
}
