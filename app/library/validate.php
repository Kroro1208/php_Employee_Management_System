<?php

declare(strict_types=1);

/**
 * 
 * 必須チェック
 * @param string
 * @return bool
 */

function validateRequired(string $str): bool
{
    if ($str === "") {
        return false;
    }
    return true;
}

/**
 *
 * 数値チェック
 * @param string
 * @return bool
 */

function validateNumber(string $str): bool
{
    if (!preg_match('/\A[0-9]+\z/', $str)) {
        return false;
    }
    return true;
}

//最大文字数チェック
function validateMaxLength(string $str, int $length): bool
{
    return mb_strlen($str, "utf-8") <= $length;
}

// 指定文字数チェック
function validateBetweenLength(string $str, int $minLength, int $maxLength): bool
{
    $length = mb_strlen($str, "utf-8");
    return ($length >= $minLength && $length <= $maxLength);
}

// 社員番号チェック
function validateId(string $str): bool
{
    if (!validateNumber($str) || !validateBetweenLength($str, 6, 6)) {
        return false;
    }
    return true;
}


// 日付チェック
function validateDate(string $str): bool
{
    if (!preg_match('/\A[0-9]{4}-[0-9]{2}-[0-9]{2}\z/', $str)) {
        return false;
    } else {
        list($year, $month, $day) = explode("-", $str);
        if (!checkdate((int)$month, (int)$day, (int)$year)) {
            return false;
        }
    }
    return true;
}

// 電話番号チェック

function validateTel(string $str): bool
{
    if (!validateNumber($str) || !validateMaxLength($str, 15)) {
        return false;
    }
    return true;
}

// メールアドレスチェック

function validateMailAddress(string $str): bool
{
    if (!preg_match("/\A[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $str)) {
        return false;
    }
    return true;
}

// 性別チェック

function validateGender(string $str): bool
{
    if (!in_array($str, GENDER_LISTS)) {
        return false;
    }
    return true;
}

// 部署チェック

function validateOrganization(string $str): bool
{
    if (!in_array($str, ORGANIZATION_LISTS)) {
        return false;
    }
    return true;
}

// 役職チェック
function validatePost(string $str): bool
{
    if (!in_array($str, POST_LISTS)) {
        return false;
    }
    return true;
}
