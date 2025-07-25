<?php

namespace controller;

use Respect\Validation\Validator as v;

class Admin extends Helper
{
    public function addPortfolioItem(): string
    {
        $portfolio = new Portfolio();
        return $portfolio->add('title', 'description', 'image', 1);
    }


    public function updatePortfolioItem(): string
    {
        $portfolio = new Portfolio();
        return $portfolio->update();
    }
    public function deletePortfolioItem(): string
    {
        $portfolio = new Portfolio();
        return $portfolio->delete();
    }

    public function addService(): string
    {
        $service = new Service();
        return $service->add();
    }

    public function updateService(): string
    {
        $service = new Service();
        return $service->update();
    }

    public function deleteService(): string
    {
        $service = new Service();
        return $service->delete();
    }

}



