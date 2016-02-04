<?php
namespace Membership\Models;

use Membership\Models;

class UsersResetPwd extends Models
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'users_reset_pwd';

    /**
     * {@inheritdoc}
     */
    protected $primary = 'user_reset_pwd_id';

    /**
     * {@inheritdoc}
     */
    protected $authorize = false;

    public function verifyUserKey($userId, $key)
    {
        $count = $this->count(function ($query) use ($userId, $key) {
            $query->where('user_id', '=', $userId)
                ->where('reset_key', '=', $key)
                ->where('deleted', '=', 'N')
                ->where('email_sent', '=', 'Y')
                ->where('expired_date', '>', date('d-m-Y H:i:s'));
        });

        return $count > 0;
    }
}
