<?php

namespace App\Repository\Admin;

interface ActivityLogRepositoryInterface {

    public function index();

    public function data($request);

}