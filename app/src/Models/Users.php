<?php
namespace Membership\Models;

use Membership\Models;

class Users extends Models
{
    public function assertUsernameExists($username)
    {
        $users = $this->db->count('*', 'count')
            ->from('users')
            ->where('username', '=', strtolower($username))
            ->execute();

        return $users->fetch()['count'] > 0;
    }

    public function assertEmailExists($email)
    {
        $users = $this->db->count('*', 'count')
            ->from('users')
            ->where('email', '=', strtolower($email))
            ->execute();

        return $users->fetch()['count'] > 0;
    }
}
