<?php

namespace Membership\Http\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Http\Controllers;
use Membership\Models\Regionals;
use Slim\Exception\NotFoundException;

class RegionalsController extends Controllers
{
    public function cities(Request $request, Response $response, array $args)
    {
        $this->assertXhrRequest($request, $response);

        /** @var array|false $cities */
        if (!$cities = (new Regionals)->getCities($args['province_id'])) {
            throw new NotFoundException($request, $response);
        }

        return $response->withJson($cities);
    }

    public function provinces(Request $request, Response $response, array $args)
    {
        $this->assertXhrRequest($request, $response);

        return $response->withJson((new Regionals)->getProvinces());
    }
}
