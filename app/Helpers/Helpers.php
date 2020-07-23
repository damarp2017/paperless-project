<?php

use App\Category;
use App\Employee;
use App\Store;

function isOwner(Store $store)
{
    return $store->owner->id === auth()->user()->id;
}

function isStaff(Store $store)
{
    $employee = Employee::where('store_id', $store->id)->where('user_id', auth()->user()->id)->where('role', 1)->first();
    if ($employee) {
        return true;
    } else {
        return false;
    }
}

function isCashier(Store $store)
{
    $employee = Employee::where('store_id', $store->id)->where('user_id', auth()->user()->id)->where('role', 0)->first();
    if ($employee) {
        return true;
    } else {
        return false;
    }
}

function isNotCategory(string $category) {
    $result = Category::where('id',$category)->first();
    return $result ? false : true;
}
