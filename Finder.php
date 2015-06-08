<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dektrium\user;

use dektrium\user\models\Token;
use yii\authclient\ClientInterface;
use yii\base\Object;
use yii\db\ActiveQuery;

/**
 * Finder provides some useful methods for finding active record models.
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class Finder extends Object
{
    /** @var ActiveQuery */
    protected $userQuery;

    /** @var ActiveQuery */
    protected $tokenQuery;

    /** @var ActiveQuery */
    protected $accountQuery;

    /** @var ActiveQuery */
    protected $profileQuery;

    /**
     * @inheritdoc
     */
    public function __call( $name, $params )
    {
      if (preg_match('/^([gs]et)([A-Z].+)/', $name, $matches) === 1 ) {
        $var = Inflector::variablize($matches[2]);
        if (($matches[1] == 'get') && $this->canGetProperty($var)) {
          return $this->$var;
        }

        if (($matches[1] == 'set') && $this->canSetProperty($var)) {
          $this->$var = $params;
          return;
        }
      }

      parent::__call($name,$params);
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
      if ($this->canGetProperty($name)) {
        return $this->{$name};
      }

      parent::__get($name);

    }

    /**
     * @inheritdoc
     */
    public function __set($name, $value)
    {
      if ($this->canSetProperty($name)) {
        $this->{$name} = $value;
        return;
      }

      parent::__set($name, $value);
    }

    /**
     * Finds a user by the given id.
     *
     * @param int $id User id to be used on search.
     *
     * @return models\User
     */
    public function findUserById($id)
    {
        return $this->findUser(['id' => $id])->one();
    }

    /**
     * Finds a user by the given username.
     *
     * @param string $username Username to be used on search.
     *
     * @return models\User
     */
    public function findUserByUsername($username)
    {
        return $this->findUser(['username' => $username])->one();
    }

    /**
     * Finds a user by the given email.
     *
     * @param string $email Email to be used on search.
     *
     * @return models\User
     */
    public function findUserByEmail($email)
    {
        return $this->findUser(['email' => $email])->one();
    }

    /**
     * Finds a user by the given username or email.
     *
     * @param string $usernameOrEmail Username or email to be used on search.
     *
     * @return models\User
     */
    public function findUserByUsernameOrEmail($usernameOrEmail)
    {
        if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            return $this->findUserByEmail($usernameOrEmail);
        }

        return $this->findUserByUsername($usernameOrEmail);
    }

    /**
     * Finds a user by the given condition.
     *
     * @param mixed $condition Condition to be used on search.
     *
     * @return \yii\db\ActiveQuery
     */
    public function findUser($condition)
    {
        return $this->userQuery->where($condition);
    }

    /**
     * Finds an account by id.
     *
     * @param int $id
     *
     * @return models\Account|null
     */
    public function findAccountById($id)
    {
        return $this->accountQuery->where(['id' => $id])->one();
    }

    /**
     * Finds an account by client id and provider name.
     *
     * @param string $provider
     * @param string $clientId
     *
     * @return models\Account|null
     */
    public function findAccountByProviderAndClientId($provider, $clientId)
    {
        return $this->accountQuery->where([
            'provider'  => $provider,
            'client_id' => $clientId,
        ])->one();
    }

    /**
     * Finds an account by client.
     *
     * @param ClientInterface $client
     *
     * @return models\Account|null
     */
    public function findAccountByClient(ClientInterface $client)
    {
        return $this->accountQuery->where([
            'provider'  => $client->getId(),
            'client_id' => $client->getUserAttributes()['id'],
        ])->one();
    }

    /**
     * Finds a token by user id and code.
     *
     * @param mixed $condition
     *
     * @return ActiveQuery
     */
    public function findToken($condition)
    {
        return $this->tokenQuery->where($condition);
    }

    /**
     * Finds a token by params.
     *
     * @param integer $userId
     * @param string  $code
     * @param integer $type
     *
     * @return Token
     */
    public function findTokenByParams($userId, $code, $type)
    {
        return $this->findToken([
            'user_id' => $userId,
            'code'    => $code,
            'type'    => $type,
        ])->one();
    }

    /**
     * Finds a profile by user id.
     *
     * @param int $id
     *
     * @return null|models\Profile
     */
    public function findProfileById($id)
    {
        return $this->findProfile(['user_id' => $id])->one();
    }

    /**
     * Finds a profile.
     *
     * @param mixed $condition
     *
     * @return \yii\db\ActiveQuery
     */
    public function findProfile($condition)
    {
        return $this->profileQuery->where($condition);
    }
}
