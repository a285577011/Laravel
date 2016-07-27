<?php

namespace App\Helpers;

/**
 * Description of Password
 *
 * @author wangw
 */
class Password
{
    /**
     * 判断密码强度
     * @param int $finalScore
     * @param boolean $scoreOnly true:只获取评分，false:获取评分和信息
     * @return array
     */
    public static function getPasswordRank($password, $scoreOnly=false)
    {
        $typeCount = 0;
        $lengScore = self::getPasswordLengthScore($password);
        $lengScore ? $typeCount++ : '';
        $letterScore = self::getPasswordLetterScore($password);
        $letterScore ? $typeCount++ : '';
        $digitScore = self::getPasswordDigitScore($password);
        $digitScore ? $typeCount++ : '';
        $specialScore = self::getPasswordSpecialScore($password);
        $specialScore ? $typeCount++ : '';
        $finalScore = $lengScore + $letterScore + $digitScore + $specialScore + self::getPasswordPlusScore($typeCount) - self::getPasswordMinusScore($password);
        return $scoreOnly ? $finalScore : self::getPasswordRankByScore($finalScore);
    }

    /**
     * 根据评分获取密码强度信息
     * @param int $finalScore
     * @return array
     */
    public static function getPasswordRankByScore($finalScore)
    {
        switch (true) {
            case $finalScore >= 30:
                $strength = trans('member.password_high');
                break;
            case $finalScore >= 20:
                $strength = trans('member.password_medium');
                break;
            case $finalScore >= 10:
                $strength = trans('member.password_soso');
                break;
            default:
                $strength = trans('member.password_weak');
                break;
        }
        return [
            'score' => $finalScore,
            'text' => $strength,
        ];
    }

    /**
     * 获取密码长度评分
     * @param string $password
     * @return int
     */
    public static function getPasswordLengthScore($password)
    {
        $length = mb_strlen($password);
        $score = 0;
        switch (true) {
            case $length <= 6:
                $score = 0;
                break;
            case $length > 6 && $length <= 8:
                $score = 5;
                break;
            case $length > 8:
                $score = 10;
                break;
            default:
                break;
        }
        return $score;
    }

    /**
     * 获取密码字母评分
     * @param string $password
     * @return int
     */
    public static function getPasswordLetterScore($password)
    {
        $score = 0;
        if (preg_match('/[A-Z]/', $password)) {
            $score += 5;
        }
        if (preg_match('/[a-z]/', $password)) {
            $score += 5;
        }
        return $score;
    }

    /**
     * 密码数字评分
     * @param string $password
     * @return int
     */
    public static function getPasswordDigitScore($password)
    {
        $score = 0;
        if (preg_match_all('/[0-9]/', $password, $matches)) {
            $count = count(array_unique($matches[0]));
            if ($count < 3) {
                $score += 5;
            } else {
                $score += 10;
            }
        }
        return $score;
    }

    /**
     * 密码特殊字符评分
     * @param string $password
     * @return int
     */
    public static function getPasswordSpecialScore($password)
    {
        $score = 0;
        if (preg_match_all('/[^0-9A-Za-z]/', $password, $matches)) {
            $count = count($matches[0]);
            if ($count > 1) {
                $score += 15;
            } else {
                $score += 5;
            }
        }
        return $score;
    }

    /**
     * 获取密码加分
     * @param int $typeCount
     * @return int
     */
    public static function getPasswordPlusScore($typeCount)
    {
        $score = 0;
        switch ($typeCount) {
            case 2:
                $score = 2;
                break;
            case 3:
                $score = 3;
                break;
            case 4:
                $score = 5;
                break;
            default:
                break;
        }
        return $score;
    }

    /**
     * 获取密码减分
     * @param type $password
     * @return int
     */
    public static function getPasswordMinusScore($password)
    {
        $score = 0;
        if (preg_match_all('/(.)(\\1+)/', $password, $matches)) {
            array_map(function($str) use (&$score) {
                $score += mb_strlen($str);
            }, $matches[2]);
        }
        return $score;
    }

    /**
     * 检查用户密码是否匹配
     * @param obj $user
     * @param string $plain
     * @return boolean
     */
    public static function checkUserPassword($user, $plain)
    {
        if(is_null($user)
            || ($user->type == 0 && !\Hash::check($plain, $user->getAuthPassword()))
            || ($user->type == 1 && $user->getAuthPassword() !== md5(md5($plain).$user->salt))
        ) {
            return false;
        }
        return true;
    }

}
