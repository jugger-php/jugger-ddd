<?php

abstract class Repository
{
    public function findOne(Criteria $criteria): Model
    {
        # code...
    }

    public function findAll(Criteria $criteria): Collection
    {
        # code...
    }

    public function save(Model $model): bool
    {
        # code...
    }

    public function delete(Model $model): bool
    {
        # code...
    }
}
