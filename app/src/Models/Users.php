<?php
namespace Membership\Models;

use Membership\Models;
use InvalidArgumentException;

class Users extends Models
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'users';

    /**
     * {@inheritdoc}
     */
    protected $primary = 'user_id';

    /**
     * {@inheritdoc}
     */
    protected $authorize = true;

    public function updateLogin($userId)
    {
        return $this->update(['last_login' => date('Y-m-d H:i:s')], (int) $userId);
    }

    public function assertUsernameExists($username)
    {
        $username = strtolower($username);
        $count = $this->count(function ($query) use ($username) {
            $query->where('username', '=', $username);
        });

        return $count > 0;
    }

    public function assertEmailExists($email)
    {
        $email = strtolower($email);
        $count = $this->count(function ($query) use ($email) {
            $query->where('email', '=', $email);
        });

        return $count > 0;
    }

    public function assertActivationExists($userId, $key)
    {
        $count = $this->count(function ($query) use ($userId, $key) {
            $query->where('user_id', '=', $userId)
                ->where('activation_key', '=', $key)
                ->where('deleted', '=', 'N')
                ->where('expired_date', '>', date('Y-m-d'));
        });

        return $count > 0;
    }

    public function authenticate($login, $password)
    {
        $query = $this->db->select([
                'u.user_id', 'u.username', 'u.password', 'u.email', 'u.province_id', 'u.city_id',
                'u.deleted', 'u.activated', 'ur.role_id', 'up.fullname', 'up.photo', 'up.job_id'
            ])
            ->from('users u')
            ->leftJoin('users_roles ur', 'u.user_id', '=', 'ur.user_id')
            ->leftJoin('members_profiles up', 'u.user_id', '=', 'up.user_id')
            ->where('u.username', '=', $login)
            ->orWhere('u.email', '=', $login)
            ->execute();

        $user = $query->fetch() ?: false;

        if ($user === false) {
            throw new InvalidArgumentException('Wrong Credentials!');
        } elseif ($user['password'] != $password) {
            throw new InvalidArgumentException('Wrong Credentials!');
        } elseif (strtolower($user['deleted']) === 'y') {
            throw new InvalidArgumentException('Wrong Credentials!');
        } elseif (strtolower($user['activated']) === 'n') {
            throw new InvalidArgumentException('Your account is not activated!');
        }

        return $user;
    }

    public function getMembers($request)
    {
        $query = $this->db->select([
                'u.user_id',
                'u.username',
                'u.email',
                'u.created',
                'ur.role_id',
                'm.fullname',
                'm.gender',
                'm.photo',
                'reg_prv.regional_name province',
                'reg_cit.regional_name city',
            ])
            ->from('users u')
            ->leftJoin('members_profiles m', 'u.user_id', '=', 'm.user_id')
            ->leftJoin('users_roles ur', 'u.user_id', '=', 'ur.user_id')
            ->leftJoin('regionals reg_prv', 'reg_prv.id', '=', 'm.province_id')
            ->leftJoin('regionals reg_cit', 'reg_cit.id', '=', 'm.city_id')
            ->where('ur.role_id', '=', 'member')
            ->where('u.activated', '=', 'Y');

        if ($request->getQueryParam('province_id')) {
            $query->where('m.province_id', '=', (int) $request->getQueryParam('province_id'));
        }

        if ($request->getQueryParam('city_id')) {
            $query->where('m.city_id', '=', (int) $request->getQueryParam('city_id'));
        }

        if ($request->getQueryParam('area')) {
            $query->whereLike('m.area', $request->getQueryParam('area'));
        }

        $query->orderBy('u.created', 'DESC')->limit(18, $request->getQueryParam('page'));

        return $query->execute()->fetchAll();
    }
}
