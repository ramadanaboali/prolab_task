<?php

namespace App\Http\Repositories\Eloquent\School;

use App\Http\Repositories\Eloquent\AbstractRepo;
use App\Http\Repositories\Interfaces\School\SchoolRepoInterface;
use App\Models\School;


class SchoolRepo extends AbstractRepo implements SchoolRepoInterface
{
    public function __construct()
    {
        parent::__construct(School::class);
    }



}
