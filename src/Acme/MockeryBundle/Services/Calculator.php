<?php
/**
 * Created by JetBrains PhpStorm.
 * User: marcos
 * Date: 10/12/12
 * Time: 22:54
 * To change this template use File | Settings | File Templates.
 */
namespace Acme\MockeryBundle\Services;

class Calculator
{
    public function __construct($service)
    {
        $this->service = $service;
    }

    public function average()
    {
        $values = $this->service->getValues();
        $totalItems = count($values);
        $total = 0;
        for ($i=0;$i< $totalItems;$i++) {
            $total += $values[$i];
        }
        return $total/$totalItems;
    }

    public function sumatory()
    {
        $total = 0;
        for ($i=0; $i<4 ;$i++) {
            $total += $this->service->getValues();
        }

        return $total;
    }

    public function getNextObj()
    {
        return $this->service->next();
    }
}
