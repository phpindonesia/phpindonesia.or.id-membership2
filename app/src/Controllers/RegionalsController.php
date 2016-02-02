<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Controllers;
use Membership\Models\Regionals;

class RegionalsController extends Controllers
{
    public function cities(Request $request, Response $response, array $args)
    {
        $this->assertXhrRequest($request, $response);

        return $res->withJson($this->data(Regionals::class)->getCities(), 200);
    }

    public function provinces(Request $request, Response $response, array $args)
    {
        $this->assertXhrRequest($request, $response);

        return $res->withJson($this->data(Regionals::class)->getProvinces(), 200);
    }
}
