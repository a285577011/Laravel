<?php

namespace App\Repository;

use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class DatabaseTokenRepository implements TokenRepositoryInterface
{
    /**
     * The database connection instance.
     *
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $connection;

    /**
     * The token database table.
     *
     * @var string
     */
    protected $table;

    /**
     * The hashing key.
     *
     * @var string
     */
    protected $hashKey;

    /**
     * The number of seconds a token should last.
     *
     * @var int
     */
    protected $expires;

    /**
     * Create a new token repository instance.
     *
     * @param  \Illuminate\Database\ConnectionInterface  $connection
     * @param  string  $table
     * @param  string  $hashKey
     * @param  int  $expires
     * @return void
     */
    public function __construct(ConnectionInterface $connection, $table, $hashKey, $expires = 60)
    {
        $this->table = $table;
        $this->hashKey = $hashKey;
        $this->expires = $expires * 60;
        $this->connection = $connection;
    }

    /**
     * Create a new token record.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param int $type token 用于何种目的 1 找回密码（默认）
     * @return string
     */
    public function create(CanResetPasswordContract $user, $type=1)
    {
        $email = $user->getEmailForPasswordReset();

        $this->deleteExisting($user, $type);

        // We will create a new, random token for the user so that we can e-mail them
        // a safe link to the password reset form. Then we will insert a record in
        // the database so that we can verify the token within the actual reset.
        $token = $this->createNewToken();

        $this->getTable()->insert($this->getPayload($email, $token, $type));

        return $token;
    }

    /**
     * Delete all existing reset tokens from the database.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param int $type token 用于何种目的 1 找回密码（默认）
     * @return int
     */
    protected function deleteExisting(CanResetPasswordContract $user, $type=1)
    {
        return $this->getTable()->where('email', $user->getEmailForPasswordReset())->where('find_type', $type)->delete();
    }

    /**
     * Build the record payload for the table.
     *
     * @param  string  $email
     * @param  string  $token
     * @param int $type token 用于何种目的 1 找回密码（默认）
     * @return array
     */
    protected function getPayload($email, $token, $type=1)
    {
        return ['email' => $email, 'token' => $token, 'ctime' => \time(), 'find_type' => $type];
    }

    /**
     * Determine if a token record exists and is valid.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $token
     * @param int $type token 用于何种目的 1 找回密码（默认）
     * @return bool
     */
    public function exists(CanResetPasswordContract $user, $token, $type=1)
    {
        $email = $user->getEmailForPasswordReset();
        $token = (array) $this->getTable()->where('email', $email)->where('token', $token)->where('find_type', $type)->first();
        return $token && ! $this->tokenExpired($token);
    }

    /**
     * Determine if the token has expired.
     *
     * @param  array  $token
     * @return bool
     */
    protected function tokenExpired($token)
    {
        $expirationTime = $token['ctime'] + $this->expires;
        return $expirationTime < $this->getCurrentTime();
    }

    /**
     * Get the current UNIX timestamp.
     *
     * @return int
     */
    protected function getCurrentTime()
    {
        return time();
    }

    /**
     * Delete a token record by token.
     *
     * @param  string  $token
     * @param int $type token 用于何种目的 1 找回密码（默认）
     * @return void
     */
    public function delete($token, $type=1)
    {
        $this->getTable()->where('token', $token)->where('find_type', $type)->delete();
    }

    /**
     * Delete expired tokens.
     *
     * @param int $type token 用于何种目的 1 找回密码（默认）
     * @return void
     */
    public function deleteExpired($type=1)
    {
        $expiredAt = Carbon::now()->subSeconds($this->expires)->getTimestamp();

        $this->getTable()->where('ctime', '<', $expiredAt)->where('find_type', $type)->delete();
    }

    /**
     * Create a new token for the user.
     *
     * @return string
     */
    public function createNewToken()
    {
        return hash_hmac('sha256', Str::random(40), $this->hashKey);
    }

    /**
     * Begin a new database query against the table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getTable()
    {
        return $this->connection->table($this->table);
    }

    /**
     * Get the database connection instance.
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }
}
