<?php

namespace App\Factory;

use App\Entity\Transaction;
// use App\Entity\Imprint;
// use App\Entity\Promise;

class TransactionFactory
{
    public static function getTransaction(string $type=null){

        $className = ucfirst($type);

        return new $className();
    }

}

// usage :
// TransactionFactory->getTransaction(thingIWant)