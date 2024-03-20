<?php

namespace App\DTO\School;

use App\DTO\InitializeDtoTrait;

class UpdateSchoolDto
{
    use InitializeDtoTrait;


    public string $name;
    public string $type;
    public int $sector_id;
}