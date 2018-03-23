<?php namespace App\Enums;

class ActivityTypes
{
    CONST user_login = 1;
    CONST user_logout = 2;

    CONST add_member = 4;
    CONST add_agent = 6;
    CONST add_company = 8;
    CONST add_call_out_service = 9;

    CONST view_member = 3;
    CONST view_agent = 5;
    CONST view_company = 7;

    CONST generate_invoice = 10;
    CONST py_passed_payment = 11;
    CONST py_passed_notification = 12;
    CONST payment_completed = 13;
    CONST renew_membership = 14;

}