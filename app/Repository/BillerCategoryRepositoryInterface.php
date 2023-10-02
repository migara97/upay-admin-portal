<?php

namespace App\Repository;

interface BillerCategoryRepositoryInterface
{
    public function findCategory($id);
    public function getActiveCategories();

    public function storeCategory(array $data);

    public function storeCategoryUpdate(int $id, array $data);
}
