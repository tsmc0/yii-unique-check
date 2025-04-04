<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        //return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        //return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    /**
    * Этот метод является встроенным методом класса ActiveRecord, он выполняется перед вызовом метода save()
    */
    public function beforeSave($insert)
    {
        // Здесь мы проверяем наличие в базе данных пользователя с таким именем
        // Если такого пользователя нет, то ничего не делаем
        // А если есть, то возвращаем false, тем самым прерывая сохранение пользователя
        // Далее выводим ошибку в SignupForm
        if (self::find()->where(['username' => $this->username])->exists()) {
            return false;
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
}
