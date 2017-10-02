<?php 

namespace App\Middleware;

use Interop\Container\ContainerInterface;

abstract class Middleware
{
	protected $c;

	public function __construct(ContainerInterface $c)
	{
		$this->c = $c;
	}
}