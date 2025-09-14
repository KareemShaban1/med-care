<?php

namespace App\Repository\Admin;

interface OrderRepositoryInterface {

    public function index();
    public function data();
    public function create();
    public function store($request);
    public function show($uuid);
    public function edit($uuid);
    public function update($request, $uuid);
    public function destroy($uuid);
    public function changeStatus($request, $uuid);
}

