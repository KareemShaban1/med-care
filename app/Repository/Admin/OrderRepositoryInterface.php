<?php

namespace App\Repository\Admin;

interface OrderRepositoryInterface {

    public function index();
    public function data();
    public function create();
    public function store($request);
    public function show($order);
    public function edit($order);
    public function update($request, $order);
    public function destroy($order);
    public function changeStatus($request, $order);
}

