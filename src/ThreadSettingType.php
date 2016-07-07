<?php
/**
 * Created by PhpStorm.
 * User: davidpiesse
 * Date: 07/07/2016
 * Time: 09:29
 */

namespace mapdev\FacebookMessenger;


abstract class ThreadSettingType
{
    const GREETING = 'greeting';
    const GET_STARTED_BUTTON = 'call_to_actions';
    const PERSISTENT_MENU = 'persistent_menu';
    const DELETE_GET_STARTED_BUTTON = 'delete_get_started';
    const DELETE_PERSISTENT_MENU = 'delete_persistent_menu';
}