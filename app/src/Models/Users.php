<?php
namespace Membership\Models;

use Membership\Models;

class Users extends Models implements \Countable
{
    public function count(callable $callable = null)
    {
        $query = $this->db->count('user_id', 'count')->from('users');

        if (null !== $callable) {
            $callable($query);
        }

        return (int) $query->execute()->fetch()['count'];
    }

    public function updateLogin($userId)
    {
        return $this->db
            ->update(['last_login' => date('Y-m-d H:i:s')])
            ->table('users')
            ->where('user_id', '=', $userId)
            ->execute();
    }

    public function assertUsernameExists($username)
    {
        $username = strtolower($username);
        $result = $this->count(function ($query) use ($username) {
            $query->where('username', '=', $username);
        });

        return $result > 0;
    }

    public function assertEmailExists($email)
    {
        $email = strtolower($email);
        $result = $this->count(function ($query) use ($email) {
            $query->where('email', '=', $email);
        });

        return $result > 0;
    }

    public function getMembers($request)
    {
        $stmt = $this->db->select([
                'u.user_id',
                'u.username',
                'u.email',
                'u.created',
                'ur.role_id',
                'm.fullname',
                'm.gender',
                'm.photo',
                'reg_prv.regional_name AS province',
                'reg_cit.regional_name AS city',
            ])
            ->from('users u')
            ->leftJoin('members_profiles m', 'u.user_id', '=', 'm.user_id')
            ->leftJoin('users_roles ur', 'u.user_id', '=', 'ur.user_id')
            ->leftJoin('regionals reg_prv', 'reg_prv.id', '=', 'm.province_id')
            ->leftJoin('regionals reg_cit', 'reg_cit.id', '=', 'm.city_id')
            ->where('ur.role_id', '=', 'member')
            ->where('u.activated', '=', 'Y');

        if ($request->getQueryParam('province_id') !== null) {
            $stmt->where('m.province_id', '=', $request->getQueryParam('province_id'));
        }

        if ($request->getQueryParam('city_id') !== null) {
            $stmt->where('m.city_id', '=', $request->getQueryParam('city_id'));
        }

        if ($request->getQueryParam('area') !== null) {
            $stmt->whereLike('m.area', $request->getQueryParam('area'));
        }

        $stmt->orderBy('u.created', 'DESC');
        $stmt->limit(20);
        $stmt->offset($request->getQueryParam('page') ?: 0);

        return $stmt->execute()->fetchAll();
    }
}
