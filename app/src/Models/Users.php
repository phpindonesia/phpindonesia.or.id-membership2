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

    /**
     * Create new user data
     *
     * @param string[] $pairs user data
     * @return int|false
     */
    public function create(array $pairs)
    {
        $this->db->beginTransaction();
        $pairs['city_id'] = 0;

        try {
            $newDate = date('Y-m-d h:i:s');

            $userId = parent::create([
                'username'    => $pairs['username'],
                'password'    => $pairs['password'],
                'email'       => $pairs['email'],
                'province_id' => $pairs['province_id'],
                'city_id'     => $pairs['city_id'],
                'area'        => $pairs['area'],
            ]);

            $values = [
                'users_roles' => [
                    'user_id'     => $userId,
                    'role_id'     => 'member',
                    'created_by'  => 0,
                ],
                'members_profiles' => [
                    'user_id'     => $userId,
                    'fullname'    => $pairs['fullname'],
                    'gender'      => $pairs['gender_id'],
                    'province_id' => $pairs['province_id'],
                    'city_id'     => $pairs['city_id'],
                    'area'        => $pairs['area'],
                    'job_id'      => $pairs['job_id'],
                    'created_by'  => 0
                ],
                'users_activations' => [
                    'user_id'        => $userId,
                    'activation_key' => $pairs['activation_key'],
                    'expired_date'   => $pairs['expired_date'],
                    'deleted'        => 'N'
                ]
            ];

            foreach ($values as $table => $pairs) {
                $pairs['created'] = $newDate;

                $this->db->insert(array_keys($pairs))
                    ->into($table)
                    ->values(array_values($pairs))
                    ->execute();
            }

            $this->db->commit();

            return $userId;
        } catch (\PDOException $e) {
            $this->db->rollback();

            throw $e;
        }
    }

    /**
     * Activate user
     *
     * @param int $userId
     * @param string $activationKey
     * @return bool
     */
    public function activate($userId, $activationKey)
    {
        $this->db->beginTransaction();

        try {
            $userId = (int) $userId;

            $this->update(['activated' => 'Y'], $userId);

            $this->db->update(['deleted' => 'Y'])
                ->table('users_activations')
                ->where($this->primary, '=', $userId)
                ->where('activation_key'. '=', $activationKey)
                ->execute();

            $this->db->commit();

            return true;
        } catch (Exception $e) {
            $this->db->rollback();

            return false;
        }
    }

    /**
     * Update user login data
     *
     * @param int $userId User ID
     * @return int
     */
    public function updateLogin($userId)
    {
        return $this->update(['last_login' => date('Y-m-d H:i:s')], (int) $userId);
    }

    /**
     * Retrieve user profile
     *
     * @param int|null $userId User ID
     * @return array
     */
    public function getProfile($userId = null)
    {
        $profile = new MemberProfile($this->db);
        !is_null($userId) || $userId = $this->current('user_id');

        return $profile->get([
            'm.*',
            'reg_prv.regional_name province',
            'reg_cit.regional_name city'
        ], function ($query) use ($userId) {
            $query->from('members_profiles m')
                ->leftJoin('regionals reg_prv', 'reg_prv.id', '=', 'm.province_id')
                ->leftJoin('regionals reg_cit', 'reg_cit.id', '=', 'm.city_id')
                ->where('m.user_id', '=', $userId)
                ->where('m.deleted', '=', 'N');
        })->fetch();
    }

    /**
     * Retrieve user social media accounts
     *
     * @param int|null $userId User ID
     * @return array
     */
    public function getSocmends($userId = null)
    {
        $socmeds = new MemberSocmeds($this->db);
        !is_null($userId) || $userId = $this->current('user_id');

        return $socmeds->get([
            'socmed_type', 'account_name', 'account_url'
        ], function ($query) use ($userId) {
            $query->where('user_id', '=', $userId)
                ->where('deleted', '=', 'N');
        })->fetchAll();
    }

    /**
     * Retrieve user portfolio
     *
     * @param int|null $userId User ID
     * @return array
     */
    public function getPortfolios($userId = null)
    {
        $portfolio = new MemberPortfolios($this->db);
        !is_null($userId) || $userId = $this->current('user_id');

        return $portfolio->get([
            'mp.member_portfolio_id',
            'mp.company_name', 'ids.industry_name',
            'mp.start_date_y', 'mp.start_date_m', 'mp.start_date_d',
            'mp.end_date_y', 'mp.end_date_m', 'mp.end_date_d',
            'mp.work_status', 'mp.job_title', 'mp.job_desc',
            'mp.created',
        ], function ($query) use ($userId) {
            $query->from('members_portfolios mp')
                ->leftJoin('industries ids', 'mp.industry_id', '=', 'ids.industry_id')
                ->where('mp.user_id', '=', $userId)
                ->where('mp.deleted', '=', 'N');
        })->fetchAll();
    }

    /**
     * Count user portfolios
     *
     * @param int|null $userId User ID
     * @return int
     */
    public function countPortfolios($userId = null)
    {
        $portfolio = new MemberPortfolios($this->db);
        !is_null($userId) || $userId = $this->current('user_id');

        return $portfolio->count(function ($query) use ($userId) {
            $query->where('user_id', '=', $userId)
                ->where('deleted', '=', 'N');
        });
    }

    /**
     * Retrieve user skills
     *
     * @param int|null $userId User ID
     * @return array
     */
    public function getSkills($userId = null)
    {
        $skills = new MemberSkills($this->db);
        !is_null($userId) || $userId = $this->current('user_id');

        return $skills->get([
            'ms.member_skill_id',
            'ms.skill_self_assesment',
            'sp.skill_name skill_parent_name',
            'ss.skill_name'
        ], function ($query) use ($userId) {
            $query->from('members_skills ms')
                ->leftJoin('skills sp', 'ms.skill_parent_id', '=', 'sp.skill_id')
                ->leftJoin('skills ss', 'ms.skill_id', '=', 'ss.skill_id')
                ->where('ms.user_id', '=', $userId)
                ->where('ms.deleted', '=', 'N')
                ->orderBy('sp.skill_name', 'ASC');
        })->fetchAll();
    }

    /**
     * Count user portfolios
     *
     * @param int|null $userId User ID
     * @return int
     */
    public function countSkills($userId = null)
    {
        $skills = new MemberSkills($this->db);
        !is_null($userId) || $userId = $this->current('user_id');

        return $skills->count(function ($query) use ($userId) {
            $query->where('user_id', '=', $userId)
                ->where('deleted', '=', 'N');
        });
    }

    /**
     * Authenticate user Credentials
     *
     * @param string $login    Should be email or username
     * @param string $password User password
     * @return int
     */
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

    /**
     * List all members
     *
     * @param \Slim\Http\Request $request Filter by request
     * @return array
     */
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

    /**
     * Is $username already exists?
     *
     * @param string $username
     * @return bool
     */
    public function assertUsernameExists($username)
    {
        $username = strtolower($username);
        $count = $this->count(function ($query) use ($username) {
            $query->where('username', '=', $username);
        });

        return $count > 0;
    }

    /**
     * Is $email already exists?
     *
     * @param string $email
     * @return bool
     */
    public function assertEmailExists($email)
    {
        $email = strtolower($email);
        $count = $this->count(function ($query) use ($email) {
            $query->where('email', '=', $email);
        });

        return $count > 0;
    }

    /**
     * Is activation $key for $userId already exists?
     *
     * @param string $userId
     * @param string $key
     * @return bool
     */
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
}
