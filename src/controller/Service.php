<?php

namespace controller;

class Service extends Helper
{


    public function add(): string
    {
        return $this->jsonResponse("success", "Service added!");
    }

    public function update(): string
    {
        return $this->jsonResponse("success", "Service updated!");
    }

    public function delete(): string
    {
        return $this->jsonResponse("success", "Service deleted!");
    }
}