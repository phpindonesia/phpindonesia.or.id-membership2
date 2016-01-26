<?php
namespace Membership\Controllers;

use Membership\Controllers;

class CommonData extends Controllers
{
    public function sities($request, $response, $args)
    {
        $this->assertXhrRequest($request, $response);

        $cities = $this->db->select(['id', 'regional_name'])
            ->from('regionals')
            ->where('parent_id', '=', $args['province_id'])
            ->execute();

        return $res->withJson($cities, 200);
    }
}
