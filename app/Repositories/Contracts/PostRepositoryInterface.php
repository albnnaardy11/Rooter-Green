<?php

namespace App\Repositories\Contracts;

interface PostRepositoryInterface extends BaseRepositoryInterface {
    public function findBySlug($slug);
}
