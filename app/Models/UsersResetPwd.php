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

    /**
     * {@inheritdoc}
     */
    public function delete($terms = null)
    {
        return $this->update([
            'deleted' => 'Y',
            'modified' => false,
        ], $terms);
    }

    /**
     * Verify reset password $key for $userId
     *
     * @param int    $userId
     * @param string $key
     * @return bool
     */
    public function verifyUserKey($userId, $key)
    {
        $count = $this->count(function ($query) use ($userId, $key) {
            $query->where('user_id', '=', $userId)
                ->where('reset_key', '=', $key)
                ->where('deleted', '=', 'N')
                // ->where('email_sent', '=', 'Y')
                ->where('date(expired_date)', '>=', date('Y-m-d'));
        });

        return $count > 0;
    }
}
