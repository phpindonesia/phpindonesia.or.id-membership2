<?php

namespace Membership\Models;

use Membership\Models;

class UsersActivations extends Models
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'users_activations';

    /**
     * {@inheritdoc}
     */
    protected $primary = 'user_activation_id';

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
     * Activate user.
     *
     * @param int    $userId
     * @param string $activationKey
     *
     * @return bool
     */
    public function activate($userId, $activationKey)
    {
        $this->db->beginTransaction();

        try {
            $userId = (int) $userId;
            $user = new Users($this->db);

            $user->update(['activated' => 'Y'], $userId);

            $this->delete([
                $user->primary() => $userId,
                'activation_key' => $activationKey,
            ]);

            $this->db->commit();

            return true;
        } catch (Exception $e) {
            $this->db->rollback();

            return false;
        }
    }

    /**
     * Is activation $key for $userId already exists?
     *
     * @param string $userId
     * @param string $key
     *
     * @return bool
     */
    public function isExists($userId, $key)
    {
        $count = $this->count(function ($query) use ($userId, $key) {
            $query->where('user_id', '=', $userId)
                ->where('activation_key', '=', $key)
                ->where('deleted', '=', 'N')
                ->where('date(expired_date)', '>=', date('Y-m-d'));
        });

        return $count > 0;
    }
}
