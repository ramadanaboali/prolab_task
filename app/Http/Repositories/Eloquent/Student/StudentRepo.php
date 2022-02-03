<?php

namespace App\Http\Repositories\Eloquent\Student;

use App\Http\Repositories\Eloquent\AbstractRepo;
use App\Http\Repositories\Interfaces\Student\StudentRepoInterface;
use App\Models\Student;


class StudentRepo extends AbstractRepo implements StudentRepoInterface
{
    public function __construct()
    {
        parent::__construct(Student::class);
    }



}
