<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Controllers;
use Membership\Models\Regionals;
use Slim\Exception\NotFoundException;

class RegionalsController extends Controllers
{
    public function cities(Request $request, Response $response, array $args)
    {
        $this->assertXhrRequest($request, $response);
        $provinces = $this->data(Regionals::class)->getCities($args['province_id']);

        if (!$provinces) {
            throw new NotFoundException($request, $response);
        }

        return $response->withJson($provinces);
    }

    public function provinces(Request $request, Response $response, array $args)
    {
        $this->assertXhrRequest($request, $response);
        $provinces = $this->data(Regionals::class)->getProvinces();

        return $request->withJson($provinces);
    }
}
