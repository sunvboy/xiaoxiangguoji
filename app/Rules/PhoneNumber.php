<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumber implements Rule
{
    protected $prefixTenNumers = '086|096|097|098|088|091|094|089|090|093|092|056|058|099|032|033|034|035|036|037|038|039|081|082|083|084|085|070|079|077|076|078|059';
    protected $prefixElevenNumbers = '028|024|0225|0236|0206|0213|0214|0207|0205|0209|0208|0216|0212|0210|0211|0203|0204|0222|0220|0221|0218|0226|0228|0227|0229|0237|0238|0232|0233|0234|0235|0255|0260|0256|0269|0257|0262|0258|0263|0271|0274|0259|0276|0252|0251|0272|0277|0296|0254|0273|0297|0292|0275|0270|0294|0299|0291|0290|0215|0261|0293|023';
    protected $errorType;

    protected const ERROR_TYPE_FORMAT = 1;
    protected const ERROR_TYPE_NUMERIC = 2;
    protected const ERROR_TYPE_LENGTH = 3;
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $value = $this->removeCountryCode($value);

        if (!preg_match('/^[0-9]+$/', $value)) {
            $this->errorType = self::ERROR_TYPE_NUMERIC;
            return false;
        }

        $phoneLength = strlen($value);
        if ($phoneLength < 10 || $phoneLength > 11) {
            $this->errorType = self::ERROR_TYPE_LENGTH;
            return false;
        }

        if ($phoneLength === 10 && !preg_match('/^' . $this->prefixTenNumers . '/', $value)) {
            $this->errorType = self::ERROR_TYPE_FORMAT;
            return false;
        }

        if ($phoneLength === 11 && !preg_match('/^' . $this->prefixElevenNumbers . '/', $value)) {
            $this->errorType = self::ERROR_TYPE_FORMAT;
            return false;
        }

        return true;
    }

    public function validate($attribute, $value)
    {
        return $this->passes($attribute, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        switch ($this->errorType) {
            case self::ERROR_TYPE_NUMERIC:
                $msg = 'Điện thoại phải là chữ số';
                break;
            case self::ERROR_TYPE_LENGTH:
                $msg = 'Điện thoại phải có độ dài từ 10 hoặc 11 số';
                break;
            default:
                $msg = 'Số điện thoại không đúng định dạng';
                break;
        }
        return $msg;
    }

    protected function removeCountryCode($phone)
    {
        $phone = preg_replace('/^\+84/', '', $phone);
        if (!preg_match('/^0/', $phone)) {
            $phone = '0' . $phone;
        }
        return $phone;
    }
}
