<?php

namespace machour\yii2\notifications\models;

use machour\yii2\notifications\NotificationsModule;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "notification".
 *
 * @property int $id
 * @property int $key_id
 * @property string $key
 * @property string $type
 * @property boolean $seen
 * @property string $created_at
 * @property int $user_id
 * @property boolean $send_email
 * @property string $email_sent Timestamp
 * @property string $date_due Timestamp
 */
abstract class Notification extends ActiveRecord
{

    /**
     * @var string Default notification
     */
    const TYPE_DEFAULT = 'default';
    /**
     * @var string  Error notification
     */
    const TYPE_ERROR   = 'error';
    /**
     * @var string  Warning notification
     */
    const TYPE_WARNING = 'warning';
    /**
     * @var string  Success notification type
     */
    const TYPE_SUCCESS = 'success';

    /**
     * @var array List of all enabled notification types
     */
    public static $types = [
        self::TYPE_WARNING,
        self::TYPE_DEFAULT,
        self::TYPE_ERROR,
        self::TYPE_SUCCESS,
    ];

    /**
     * Gets the notification title
     *
     * @return string
     */
    abstract public function getTitle();

    /**
     * Gets the notification description
     *
     * @return string
     */
    abstract public function getDescription();

    /**
     * Gets the notification route
     *
     * @return string
     */
    abstract public function getRoute();

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notification}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'user_id', 'key', 'created_at'], 'required'],
            [['id', 'key_id', 'created_at', 'date_due', 'send_email', 'email_sent'], 'safe'],
            [['key_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * Creates a notification
     *
     * @param string $key
     * @param int $user_id The user id that will get the notification
     * @param int $key_id The foreign instance id
     * @param string $type
     * @return bool Returns TRUE on success, FALSE on failure
     * @throws \Exception
     */
    public static function notify($key, $user_id, $key_id = null, $type = self::TYPE_DEFAULT)
    {
        $class = self::className();
        return NotificationsModule::notify(new $class(), $key, $user_id, $key_id, $type);
    }

    /**
     * Creates a notification in the future
     *
     * @param string $date The due date for this notification
     * @param string $key
     * @param int $user_id The user id that will get the notification
     * @param int $key_id The foreign instance id
     * @param bool $send_email
     * @return bool Returns TRUE on success, FALSE on failure
     * @throws \Exception
     */
    public static function scheduledNotification($date, $key, $user_id, $key_id = null, $send_email = false)
    {
        $class = self::className();
        return NotificationsModule::scheduledNotification(new $class(), $date, $key, $user_id, $key_id, $send_email);
    }

    /**
     * Creates a notification in the future which sends an email at the due date
     *
     * @param string $date The due date for this notification
     * @param string $key
     * @param int $user_id The user id that will get the notification
     * @param int $key_id The foreign instance id
     * @return bool Returns TRUE on success, FALSE on failure
     * @throws \Exception
     */
    public static function scheduledEmailNotification($date, $key, $user_id, $key_id = null)
    {
        $class = self::className();
        return NotificationsModule::scheduledNotification(new $class(), $date, $key, $user_id, $key_id, true);
    }


    /**
     * Creates a warning notification
     *
     * @param string $key
     * @param int $user_id The user id that will get the notification
     * @param int $key_id The notification key id
     * @return bool Returns TRUE on success, FALSE on failure
     */
    public static function warning($key, $user_id, $key_id = null)
    {
        return static::notify($key, $user_id, $key_id, self::TYPE_WARNING);
    }


    /**
     * Creates an error notification
     *
     * @param string $key
     * @param int $user_id The user id that will get the notification
     * @param int $key_id The notification key id
     * @return bool Returns TRUE on success, FALSE on failure
     */
    public static function error($key, $user_id, $key_id = null)
    {
        return static::notify($key, $user_id, $key_id, self::TYPE_ERROR);
    }


    /**
     * Creates a success notification
     *
     * @param string $key
     * @param int $user_id The user id that will get the notification
     * @param int $key_id The notification key id
     * @return bool Returns TRUE on success, FALSE on failure
     */
    public static function success($key, $user_id, $key_id = null)
    {
        return static::notify($key, $user_id, $key_id, self::TYPE_SUCCESS);
    }
}
