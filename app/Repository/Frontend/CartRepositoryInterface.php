<?php

namespace App\Repository\Frontend;

interface CartRepositoryInterface {

    public function add($request, $id);
    public function index();
    public function update($request);

    public function remove($id);

}