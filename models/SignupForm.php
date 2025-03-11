<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class SignupForm extends Model
{
    public $username;
    public $password;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
        ];
    }

    /**
    * Этот метод сохраняет пользователя в БД
     */
    public function signup()
    {
        $user = new User();
        $user->username = $this->username;
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);

        // Пробуем сохранить пользователя
        if ($isSave = $user->save()) {
            // Если всё хорошо, то возвращаем в контроллер результат функции сохранения
            return $isSave;
        } else {
            // Иначе, если произошла ошибка при сохранении, выводим её

            $this->addError('username', 'Пользователь с таким именем уже существует');

            return false;
        }

    }
}
