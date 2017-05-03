<?php

namespace Membership\Models;

use Membership\Models;
use InvalidArgumentException;
use Valitron\Validator;

class Users extends Models
{
    const IDENTITY_TYPES = ['ktp' => 'KTP', 'sim' => 'SIM', 'ktm' => 'Kartu Mahasiswa'];
    const GENDERS = ['female' => 'Wanita', 'male' => 'Pria'];

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
     * @param Validator|null $validator
     * @return array
     */
    public function rules(Validator $validator = null)
    {
        $validator->addRule('notExists', function ($field, $value) {
            return ! $this->isExists($field, $value);
        }, 'tersebut sudah terdaftar!');

        $validator->addRule('usable', function ($field, $value) {
            return ! in_array($value, [
                'admin',
                'account', 'login', 'register', 'logout',
                'activate', 'reactivate', 'regionals',
                'forgot-password', 'reset-password'
            ]);
        }, 'tersebut tidak diijinkan!');

        return [
            'regex' => [
                ['fullname', ':^[A-z\s]+$:'],
                ['username', ':^[A-z\d\-\.\_]+$:'],
                ['contact_phone', ':^[-\+\d]+$:'],
                ['identity_number', ':^[^\W_]+$:'],
            ],
            'email' => 'email',
            'usable' => 'username',
            'notExists' => ['email', 'username'],
            'dateFormat' => [
                ['birth_date', 'Y-m-d']
            ],
            'equals' => [
                ['repassword', 'password']
            ],
            'in' => [
                ['identity_type', array_keys(static::IDENTITY_TYPES)]
            ],
            'lengthMax' => [
                ['fullname', 32],
                ['username', 64],
                ['contact_phone', 16],
                ['area', 64],
                ['identity_number', 32],
                ['birth_place', 32],
            ],
            'lengthMin' => [
                ['username', 6],
                ['password', 6],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function create($pairs)
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
     * Update user login database
     *
     * @param int $userId User ID
     * @return int
     */
    public function updateLogin($userId)
    {
        return $this->update(['last_login' => date('Y-m-d H:i:s')], (int) $userId);
    }

    /**
     * Retrieve user profile by User Id
     *
     * @param string|null $userId User Id
     * @return array
     */
    public function getProfile($userId = null)
    {
        $profile = new MemberProfile($this->db);
        !is_null($userId) || $userId = $this->current('user_id');

        return $profile->get([
            'u.user_id', 'u.username', 'u.email', 'u.created', 'm.*', 'r.religion_name',
            'reg_prv.regional_name province',
            'reg_cit.regional_name city'
        ], function ($query) use ($userId) {
            $query->from('users u')
                ->leftJoin('members_profiles m', 'u.user_id', '=', 'm.user_id')
                ->leftJoin('regionals reg_cit', 'reg_cit.id', '=', 'm.city_id')
                ->leftJoin('regionals reg_prv', 'reg_prv.id', '=', 'm.province_id')
                ->leftJoin('religions r', 'r.religion_id', '=', 'm.religion_id')
                ->where('u.user_id', '=', $userId)
                ->where('u.deleted', '=', 'N');
        })->fetch();
    }

    /**
     * Retrieve user profile by Username
     *
     * @param string|null $username Username
     * @return array
     */
    public function getProfileUsername($username = null)
    {
        $profile = new MemberProfile($this->db);

        return $profile->get([
            'u.user_id', 'u.username', 'u.email', 'u.created', 'm.*', 'r.religion_name',
            'reg_prv.regional_name province',
            'reg_cit.regional_name city'
        ], function ($query) use ($username) {
            $query->from('users u')
                ->leftJoin('members_profiles m', 'u.user_id', '=', 'm.user_id')
                ->leftJoin('regionals reg_cit', 'reg_cit.id', '=', 'm.city_id')
                ->leftJoin('regionals reg_prv', 'reg_prv.id', '=', 'm.province_id')
                ->leftJoin('religions r', 'r.religion_id', '=', 'm.religion_id')
                ->where('u.username', '=', $username)
                ->where('u.deleted', '=', 'N');
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
     * Get query statement to list all members
     *
     * @param \Slim\Http\Request $request  Filter by request
     * @param array $selector
     * @return \Slim\PDO\Statement\StatementContainer
     */
    private function createQueryMembers($request, array $selector)
    {
        $query = $this->db->select($selector)
            ->from('users u')
            ->leftJoin('members_profiles m', 'u.user_id', '=', 'm.user_id')
            ->leftJoin('users_roles ur', 'u.user_id', '=', 'ur.user_id')
            ->leftJoin('regionals reg_prv', 'reg_prv.id', '=', 'm.province_id')
            ->leftJoin('regionals reg_cit', 'reg_cit.id', '=', 'm.city_id')
            ->where('ur.role_id', '=', 'member')
            ->where('u.activated', '=', 'Y');

        if ($nama = $request->getQueryParam('nama')) {
            $combined = $query->combine()
                ->whereLike('u.username', "%$nama%")
                ->orWhereLike('m.fullname', "%$nama%");
            $query->where($combined);
        }

        if ($daerah = $request->getQueryParam('daerah')) {
            $combined = $query->combine()
                ->whereLike('m.area', "%$daerah%")
                ->orWhereLike('reg_prv.regional_name',  "%$daerah%")
                ->orWhereLike('reg_cit.regional_name', "%$daerah%");
            $query->where($combined);
        }

        return $query;
    }

    /**
     * List all members
     *
     * @param \Slim\Http\Request $request Filter by request
     * @return array
     */
    function getMembers($request)
    {
        $selector = [
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
        ];

        $limit = 18;
        $page  = (int) $request->getQueryParam('page') ?: 1;
        $query = $this->createQueryMembers($request, $selector)
            ->orderBy('u.created', 'DESC')
            ->limit($limit, ($page - 1) * $limit)
            ->execute();

        return $query->fetchAll();
    }

    /**
     * Get Total Member
     *
     * @param \Slim\Http\Request $request Filter by request
     * @return integer
     */
    public function getTotalMember($request)
    {
        $query = $this->createQueryMembers($request, ['u.user_id']);

        return $query->execute()->rowCount();
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
}
