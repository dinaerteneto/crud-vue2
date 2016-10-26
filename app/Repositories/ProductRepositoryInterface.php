<?php

namespace App\Repositories;

interface ProductRepositoryInterface {

	public function getAll(int $iPerPage);
	public function find(int $id);

}