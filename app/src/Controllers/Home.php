<?php
namespace Membership\Controllers;

use Membership\Controllers;
use Membership\Models\Users;
use Membership\Models\Regionals;
use Slim\Exception\NotFoundException;

class Home extends Controllers
{
    public function index($request, $response)
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
