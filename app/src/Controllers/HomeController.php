<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Controllers;
use Membership\Models\Users;
use Membership\Models\Regionals;

class HomeController extends Controllers
{
    public function index(Request $request, Response $response, array $args)
    {
        $members = Users::factory($this->db)->getMembers($request);
        $provinces = $cities = [];

        foreach (Regionals::factory($this->db)->getProvinces() as $prov) {
            $provinces[$prov['id']] = $prov['regional_name'];
        }

        if ($province_id = $request->getQueryParam('province_id')) {
            foreach (Regionals::factory($this->db)->getCities($province_id) as $city) {
                $cities[$city['id']] = $prov['regional_name'];
            }
        }

        $this->setPageTitle('Membership', 'Keanggotaan');

        return $this->view->render('home-index', compact('members','provinces', 'cities'));
    }
}
