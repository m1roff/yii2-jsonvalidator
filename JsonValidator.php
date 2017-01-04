<?php
namespace mirkhamidov\validators;

use Yii;
use yii\validators\Validator;

/**
 * JsonValidator checks if the attribute value is a valid json value.
 *
 * @author Jasur Mirkhamidov <mirkhamidov.jasur@gmail.com>
 */
class JsonValidator extends Validator
{
    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        if (!is_string($model->{$attribute})) {
            $this->addError($model, $attribute, Yii::t('app', 'Invalid JSON'));
        }
        $_json = @json_decode($model->{$attribute});
        $_jsonError = json_last_error();

        switch ($_jsonError) {
            case JSON_ERROR_NONE:
                // there is no error
                if(!is_object($_json)) {
                    $this->addError($model, $attribute, Yii::t('app', 'Invalid JSON'));
                }
                break;

            case JSON_ERROR_DEPTH:
                $this->addError($model, $attribute,
                    Yii::t('app','The maximum stack depth has been exceeded'));
                break;

            case JSON_ERROR_STATE_MISMATCH:
                $this->addError($model, $attribute,
                    Yii::t('app','Invalid or malformed JSON'));
                break;

            case JSON_ERROR_CTRL_CHAR:
                $this->addError($model, $attribute,
                    Yii::t('app','Control character error, possibly incorrectly encoded'));
                break;

            case JSON_ERROR_SYNTAX:
                $this->addError($model, $attribute,
                    Yii::t('app','Syntax error'));
                break;

            case JSON_ERROR_UTF8:
                $this->addError($model, $attribute,
                    Yii::t('app','Malformed UTF-8 characters, possibly incorrectly encoded'));
                break;

            case JSON_ERROR_RECURSION:
                $this->addError($model, $attribute,
                    Yii::t('app','One or more recursive references in the value to be encoded'));
                break;

            case JSON_ERROR_INF_OR_NAN:
                $this->addError($model, $attribute,
                    Yii::t('app','One or more NAN or INF values in the value to be encoded'));
                break;

            case JSON_ERROR_UNSUPPORTED_TYPE:
                $this->addError($model, $attribute,
                    Yii::t('app','A value of a type that cannot be encoded was given'));
                break;

            default:
                if (((int)phpversion()) >= 7) {
                    if ($_jsonError == JSON_ERROR_INVALID_PROPERTY_NAME) {
                        $this->addError($model, $attribute,
                            Yii::t('app','A property name that cannot be encoded was given'));
                    }

                    if ($_jsonError == JSON_ERROR_UTF16) {
                        $this->addError($model, $attribute,
                            Yii::t('app','Malformed UTF-16 characters, possibly incorrectly encoded'));
                    }
                }
                break;
        }
    }
}