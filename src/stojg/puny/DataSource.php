<?php

namespace stojg\puny;

/**
 * DataSource interface that acts as a DataMapper
 */
interface DataSource {

	public function count();

	public function limit($limit);

	public function offset($offset);

	public function first();
}