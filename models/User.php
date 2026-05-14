<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string|null $patronymic
 * @property string $email
 * @property string $password
 * @property string $auth_key
 * @property string|null $phone
 * @property string|null $avatar
 * @property string $role
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Car[] $cars
 * @property Booking[] $bookings
 * @property Review[] $reviews
 * @property Favorite[] $favorites
 */
class User extends ActiveRecord implements IdentityInterface
{

    public $avatarFile;

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['username', 'first_name', 'last_name', 'email', 'password', 'auth_key'], 'required'],
            [['username', 'email'], 'unique'],
            ['email', 'email'],
            ['phone', 'string', 'max' => 20],
            ['role', 'in', 'range' => ['user', 'owner', 'admin']],
            ['role', 'default', 'value' => 'user'],
            ['avatar', 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
            [['avatarFile'], 'file', 'extensions' => 'png, jpg, jpeg, gif', 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => Yii::t('app', 'Имя пользователя'),
            'first_name' => Yii::t('app', 'Имя'),
            'last_name' => Yii::t('app', 'Фамилия'),
            'patronymic' => Yii::t('app', 'Отчество'),
            'email' => Yii::t('app', 'Почта'),
            'password' => Yii::t('app', 'Пароль'),
            'auth_key' => 'Auth Key',
            'phone' => Yii::t('app', 'Телефон'),
            'avatarFile' => Yii::t('app', 'Аватарка'),
            'role' => Yii::t('app', 'Роль'),
            'created_at' => Yii::t('app', 'Дата создания'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
        ];
    }

    public function uploadAvatar()
    {
        if ($this->avatarFile === null) {
            return true;
        }
        $path = 'uploads/avatars/' . $this->id . '_' . time() . '.' . $this->avatarFile->extension;
        if ($this->avatarFile->saveAs($path)) {
            $this->avatar = '/' . $path;
            return true;
        }
        return false;
    }
    
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException();
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Gets query for [[Cars]].
     */
    public function getCars()
    {
        return $this->hasMany(Car::class, ['owner_id' => 'id']);
    }

    /**
     * Gets query for [[Bookings]].
     */
    public function getBookings()
    {
        return $this->hasMany(Booking::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['user_id' => 'id'])->via('bookings');
    }

    /**
     * Gets query for [[Favorites]].
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorite::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for favorite cars via [[favorites]].
     */
    public function getFavoriteCars()
    {
        return $this->hasMany(Car::class, ['id' => 'car_id'])->via('favorites');
    }
}