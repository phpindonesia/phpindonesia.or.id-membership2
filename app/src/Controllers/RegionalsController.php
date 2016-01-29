<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Controllers;

class RegionalsController extends Controllers
{
    public function cities(Request $request, Response $response, array $args)
    {
        $this->assertXhrRequest($request, $response);

        $cities = $this->db->select(['id', 'regional_name'])
            ->from('regionals')
            ->where('parent_id', '=', $args['province_id'])
            ->execute();

        return $res->withJson($cities, 200);
    }
}
