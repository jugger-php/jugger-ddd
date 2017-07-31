<?php

interface Storage
{
    public function insert(StorageItem $row): string;

    public function update(string $id, StorageItem $row): bool;

    public function delete(string $id): StorageItem;

    public function findAll(array $fields = []): StorageItemCollection;

    public function findOne(array $fields = []): StorageItem;
}
