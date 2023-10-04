<?php

namespace App\Repository;

interface BillerRepositoryInterface
{

    public function findBiller($id);
    
    public function storeProvider(array $details);

    public function updateProvider(int $id, array $details);

}
