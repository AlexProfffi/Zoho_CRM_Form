<?php

namespace App\Contracts;

interface Record
{
    public function isCreate(): bool;
    public function create(array $zohoCRMForm);
}
