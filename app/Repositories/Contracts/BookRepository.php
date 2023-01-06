<?php

namespace App\Repositories\Contracts;


interface BookRepository extends BaseRepository
{
    public function filter($filter);
}
