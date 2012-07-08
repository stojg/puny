<?php

namespace stojg\puny;

interface DataSource {

	public function dataSource();

	public function count();

	public function limit($limit);

	public function offset($offset);

	public function first();
}