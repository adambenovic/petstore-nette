<?php

declare(strict_types=1);

namespace App\Core;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router->addRoute('/api/v1/pet', 'Pet:CreatePet');
		$router->addRoute('/api/v1/pet/<id>', 'Pet:GetPet');
        $router->addRoute('<presenter>/<action>[/<id>]', 'Home:default');

        return $router;
	}
}
