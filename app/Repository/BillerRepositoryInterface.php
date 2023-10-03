<?php

namespace App\Repository;

interface BillerRepositoryInterface
{

    public function findBiller($id);
    
    public function storeProvider(array $details);

}
