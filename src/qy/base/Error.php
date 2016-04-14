<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 16/3/10
 * Time: 10:45
 */

namespace weixin\qy\base;


class Error
{
    const E_SYSTEM_BUSY                                 = -1;
    const E_SUCCESS                                     = 0;
    const E_INVALID_CORP_SECRET                         = 40001;
    const E_INVALID_TOKEN_TYPE                          = 40002;
    const E_INVALID_USER_ID                             = 40003;
    const E_INVALID_MEDIA_TYPE                          = 40004;
    const E_INVALID_FILE_TYPE                           = 40005;
    const E_INVALID_FILE_SIZE                           = 40006;
    const E_INVALID_MEDIA_ID                            = 40007;
    const E_INVALID_MESSAGE_TYPE                        = 40008;
    const E_INVALID_CORP_ID                             = 40013;
    const E_INVALID_ACCESS_TOKEN                        = 40014;
    const E_INVALID_MENU_TYPE                           = 40015;
    const E_INVALID_MENU_BUTTON_COUNT                   = 40016;
    const E_INVALID_MENU_BUTTON_TYPE                    = 40017;
    const E_INVALID_MENU_BUTTON_NAME                    = 40018;
    const E_INVALID_MENU_BUTTON_KEY                     = 40019;
    const E_INVALID_MENU_BUTTON_URL                     = 40020;
    const E_INVALID_MENU_VERSION                        = 40021;
    const E_INVALID_SUB_MENU_LEVEL                      = 40022;
    const E_INVALID_SUB_MENU_BUTTON_COUNT               = 40023;
    const E_INVALID_SUB_MENU_BUTTON_TYPE                = 40024;
    const E_INVALID_SUB_MENU_BUTTON_NAME                = 40025;
    const E_INVALID_SUB_MENU_BUTTON_KEY                 = 40026;
    const E_INVALID_SUB_MENU_BUTTON_URL                 = 40027;
    const E_INVALID_MENU_MEMBER                         = 40028;
    const E_INVALID_OAUTH_CODE                          = 40029;
    const E_INVALID_USER_ID_LIST                        = 40031;
    const E_INVALID_USER_ID_LIST_LENGTH                 = 40032;
    const E_INVALID_CHARACTER                           = 40033;
    const E_INVALID_PARAMETER                           = 40035;
    const E_INVALID_FORMAT                              = 40038;
    const E_INVALID_URL_LENGTH                          = 40039;
    const E_INVALID_PLUGIN_TOKEN                        = 40040;
    const E_INVALID_PLUGIN_ID                           = 40041;
    const E_INVALID_PLUGIN_SESSION                      = 40042;
    const E_INVALID_URL_DOMAIN                          = 40048;
    const E_INVALID_SUB_MENU_DOMAIN                     = 40054;
    const E_INVALID_BUTTON_DOMAIN                       = 40055;
    const E_INVALID_AGENT_ID                            = 40056;
    const E_INVALID_CALLBACK                            = 40057;
    const E_RED_ENVELOPES_PARAMETER                     = 40058;
    const E_INVALID_LOCATION_FLAG                       = 40059;
    const E_LOCATION_REQUIRED_CALLBACK                  = 40060;
    const E_UPDATE_AVATAR_FAILED                        = 40061;
    const E_INVALID_APP_MODE                            = 40062;
    const E_PARAMETER_EMPTY                             = 40063;
    const E_MANAGER_GROUP_NAME_EXIST                    = 40064;
    const E_INVALID_MANAGER_GROUP_NAME                  = 40065;
    const E_INVALID_DEPARTMENT_LIST                     = 40066;
    const E_INVALID_TITLE                               = 40067;
    const E_INVALID_TAG_ID                              = 40068;
    const E_INVALID_TAG_ID_LIST                         = 40069;
    const E_ALL_TAG_ID_INVALID                          = 40070;
    const E_TAG_NAME_EXIST                              = 40071;
    const E_INVALID_TAG_NAME                            = 40072;
    const E_INVALID_OPENID                              = 40073;
    const E_NEWS_NOT_SUPPORT_HIGH_SECRET                = 40074;
    const E_INVALID_PRE_AUTHORIZATION_CODE              = 40077;
    const E_INVALID_TEMPORARY_AUTHORIZATION_CODE        = 40078;
    const E_INVALID_AUTHORIZATION_INFO                  = 40079;
    const E_INVALID_SUITE_SECRET                        = 40080;
    const E_INVALID_SUITE_TOKEN                         = 40082;
    const E_INVALID_SUITE_ID                            = 40083;
    const E_INVALID_PERMANENT_AUTHORIZATION_CODE        = 40084;
    const E_INVALID_SUITE_TICKET                        = 40085;
    const E_INVALID_THIRTY_APP_ID                       = 40086;
    const E_FILE_INCLUDE_INVALID_CONTENT                = 40092;
    const E_INVALID_REDIRECT_TARGET                     = 40093;
    const E_INVALID_URL                                 = 40094;
    const E_MISSING_ACCESS_TOKEN                        = 41001;
    const E_MISSING_CORP_ID                             = 41002;
    const E_MISSING_REFRESH_TOKEN                       = 41003;
    const E_MISSING_CORP_SECRET                         = 41004;
    const E_MISSING_MEDIA_DATA                          = 41005;
    const E_MISSING_MEDIA_ID                            = 41006;
    const E_MISSING_SUB_MENU_DATA                       = 41007;
    const E_MISSING_OAUTH_CODE                          = 41008;
    const E_MISSING_USER_ID                             = 41009;
    const E_MISSING_URL                                 = 41010;
    const E_MISSING_AGENT_ID                            = 41011;
    const E_MISSING_APP_AVATAR                          = 41012;
    const E_MISSING_APP_NAME                            = 41013;
    const E_MISSING_APP_DESC                            = 41014;
    const E_MISSING_CONTENT                             = 41015;
    const E_MISSING_TITLE                               = 41016;
    const E_MISSING_TAG_ID                              = 41017;
    const E_MISSING_TAG_NAME                            = 41018;
    const E_MISSING_SUITE_ID                            = 41021;
    const E_MISSING_SUITE_TOKEN                         = 41022;
    const E_MISSING_SUITE_TICKET                        = 41023;
    const E_MISSING_SUITE_SECRET                        = 41024;
    const E_MISSING_PERMANENT_AUTHORIZATION_CODE        = 41025;
    const E_MISSING_LOGIN_TICKET                        = 41034;
    const E_MISSING_REDIRECT_TARGET                     = 41035;
    const E_ACCESS_TOKEN_TIMEOUT                        = 42001;
    const E_REFRESH_TOKEN_TIMEOUT                       = 42002;
    const E_OAUTH_CODE_TIMEOUT                          = 42003;
    const E_PLUGIN_TOKEN_TIMEOUT                        = 42004;
    const E_PRE_AUTHORIZATION_CODE_FAILURE              = 42007;
    const E_TEMPORARY_AUTHORIZATION_CODE_FAILURE        = 42008;
    const E_SUITE_TOKEN_FAILURE                         = 42009;
    const E_GET_METHOD_REQUIRED                         = 43001;
    const E_POST_METHOD_REQUIRED                        = 43002;
    const E_HTTPS_PROTOCOL_REQUIRED                     = 43003;
    const E_REQUIRE_MEMBER_FOLLOWED                     = 43004;
    const E_REQUIRE_FRIENDS                             = 43005;
    const E_REQUIRE_SUBSCRIBE                           = 43006;
    const E_REQUIRE_AUTHORIZED                          = 43007;
    const E_REQUIRE_PAY_AUTHORIZED                      = 43008;
    const E_REQUIRE_CALLBACK_MODE                       = 43010;
    const E_REQUIRE_CORP_AUTHORIZED                     = 43011;

    const E_MEDIA_FILE_EMPTY                            = 44001;
    const E_POST_DATA_EMPTY                             = 44002;
    const E_MPNEWS_CONTENT_EMPTY                        = 44003;
    const E_TEXT_CONTENT_EMPTY                          = 44004;

    const E_MEDIA_FILE_OVER_LIMIT                       = 45001;
    const E_CONTENT_OVER_LIMIT                          = 45002;
    const E_TITLE_OVER_LIMIT                            = 45003;
    const E_DESCRIPTION_OVER_LIMIT                      = 45004;
    const E_LINK_OVER_LIMIT                             = 45005;
    const E_IMAGE_LINK_OVER_LIMIT                       = 45006;
    const E_VOICE_OVER_LIMIT                            = 45007;
    const E_ARTICLE_COUNT_OVER_LIMIT                    = 45008;
    const E_API_CALLED_TIMES_OVER_LIMIT                 = 45009;
    const E_MENU_COUNT_OVER_LIMIT                       = 45010;
    const E_REPLY_TIME_OVER_LIMIT                       = 45015;
    const E_SYSTEM_GROUP_NOT_ALLOWED_CHANGE             = 45016;
    const E_GROUP_NAME_TOO_LONG                         = 45017;
    const E_GROUP_COUNT_OVER_LIIT                       = 45018;
    const E_APP_NAME_INVALID                            = 45022;
    const E_ACCOUNT_COUNT_OVER_LIMIT                    = 45024;
    const E_MEMBER_FOLLOWED_ONCE_ONE_WEEK               = 45025;
    const E_TRIGGER_USER_PROTECTED                      = 45026;
    const E_MPNEWS_SEND_TIMES_OVER_LIMIT                = 45027;
    const E_MATERIAL_COUNT_OVER_LIMIT                   = 45028;
    const E_MEDIA_ID_INVALID_IN_APP                     = 45029;

    const E_MEDIA_DATA_NOT_EXIST                        = 46001;
    const E_MENU_VERSION_NOT_EXIST                      = 46002;
    const E_MENU_DATA_NOT_EXIST                         = 45003;
    const E_MEMBER_NOT_EXIST                            = 46004;

    const E_PARSE_JSON_XML_FAILED                       = 47001;

    const E_API_NOT_AUTHORIZED                          = 48001;
    const E_API_DISABLED                                = 48002;
    const E_SUITE_TOKEN_NOT_VALID                       = 48003;
    const E_AUTHORIZATION_RELATIONS_NOT_VALID           = 48004;

    const E_REDIRECT_URL_NOT_AUTHORIZED                 = 50001;
    const E_MEMBER_NOT_AUTHORIZED                       = 50002;
    const E_APP_DISABLED                                = 50003;
    const E_MEMBER_STATUS_INVALID                       = 50004;
    const E_CORP_DISABLED                               = 50005;

    const E_INVALID_DEPARTMENT_NAME                     = 60001;
    const E_DEPARTMENT_LEVEL_OVER_TIME                  = 60002;
    const E_DEPARTMENT_NOT_EXIST                        = 60003;
    const E_PARENTS_DEPARTMENT_NOT_EXIST                = 60004;
    const E_DEPARTMENT_OF_MEMBER_NOT_ALLOWED_DELETE     = 60005;
    const E_DEPARTMENT_OF_SUB_NOT_ALLOWED_DELETE        = 60006;
    const E_ROOT_DEPARTMENT_NOT_ALLOWED_DELETE          = 60007;
    const E_DEPARTMENT_NAME_EXIST                       = 60008;
    const E_DEPARTMENT_NAME_INVALID_CHARACTERS          = 60009;
    const E_DEPARTMENT_CYCLE_EXIST                      = 60010;
    const E_DEPARTMENT_NO_PERMISSIONS                   = 60011;
    const E_NOT_ALLOWED_DELETE_DEFAULT_APP              = 60012;
    const E_NOT_ALLOWED_DISABLE_APP                     = 60013;
    const E_NOT_ALLOWED_ENABLE_APP                      = 60014;
    const E_NOT_ALLOWED_UPDATE_APP_                     = 60015;
    const E_NOT_ALLOWED_DELETE_TAG_HAS_MEMBERS          = 60016;
    const E_NOT_ALLOWED_SETTING_CORP                    = 60017;
    const E_NOT_ALLOWED_SETTING_LOCATION_SWITCHER       = 60019;
    const E_IP_NOT_IN_WHITE_LIST                        = 60020;
    const E_NOT_SUPPORTED_MESSAGE_TYPE                  = 60025;
    const E_NOT_SUPPORTED_THIRTY_UPDATE_APP             = 60027;
    const E_NOT_ALLOWED_THIRTY_UPDATE_URL               = 60028;
    const E_NOT_ALLOWED_THIRTY_TRUST_DOMAIN             = 60029;

    const E_USER_ID_EXIST                               = 60102;
    const E_MOBILE_INVALID                              = 60103;
    const E_MOBILE_EXIST                                = 60104;
    const E_EMAIL_INVALID                               = 60105;
    const E_EMAIL_EXIST                                 = 60106;
    const E_WEIXIN_ID                                   = 60107;
    const E_WEIXIN_ID_EXIST                             = 60108;
    const E_QQ_EXIST                                    = 60109;
    const E_DEPARTMENTS_OF_USER_OVER_LIMIT              = 60110;
    const E_USER_ID_NOT_EXIST                           = 60111;
    const E_MEMBER_NAME_INVALID                         = 60112;
    const E_MEMBER_INFO_INVALID                         = 60113;
    const E_GENDER_INVALID                              = 60114;
    const E_FOLLOWED_MEMBER_WEIXIN_NOT_ALLOWED_UPDATE   = 60115;
    const E_EXTEND_PROPERTY_EXIST                       = 60116;
    const E_MEMBER_NO_VALID_FIELDS                      = 60118;
    const E_MEMBER_FOLLOWED                             = 60119;
    const E_MEMBER_DISABLED                             = 60120;
    const E_MEMBER_NOT_FOUND                            = 60121;
    const E_EMAIL_USER_BY_EXTERNAL_ADMIN                = 60122;
    const E_DEPARTMENT_ID_INVALID                       = 60123;
    const E_PARENTS_DEPARTMENT_ID_INVALID               = 60124;
    const E_DEPARTMENT_NAME_LENGTH_INVALID              = 60125;
    const E_CREATE_DEPARTMENT_FAILED                    = 60126;
    const E_MISSING_DEPARTMENT_ID                       = 60127;
    const E_FIELDS_INVALID                              = 60128;
    const E_MEMBER_REFUSED_INVITED                      = 60129;

    const E_DOMAIN_NOT_BEIAN                            = 80001;

    const E_INVITE_QUOTA_OVER_LIMIT                     = 81003 ;

    const E_MESSAGE_OR_INVITE_PARAMETER_EMPTY           = 82001;
    const E_PARTY_ID_LIST_LENGTH_INVALID                = 82002;
    const E_TAG_ID_LIST_LENGTH_INVALID                  = 82003;
    const E_WEIXIN_VERSION_TOO_LOWER                    = 82004;

    const E_INVALID_SESSION_ID                          = 86001;
    const E_SESSION_ID_NOT_EXIST                        = 86003;
    const E_INVALID_SESSION_NAME                        = 86004;
    const E_INVALID_SESSION_ADMIN                       = 86005;
    const E_INVALID_MEMBER_LIST_SIZE                    = 86006;
    const E_MEMBER_NOT_EXIST_2                          = 86007;
    const E_SESSION_REQUIRE_ADMIN_PERMISSION            = 86101;
    const E_MISSING_SESSION_ID                          = 86201;
    const E_MISSING_SESSION_NAME                        = 86202;
    const E_MISSING_SESSION_ADMIN                       = 86203;
    const E_MISSING_SESSION_MEMBER                      = 86204;
    const E_INVALID_SESSION_ID_LENGTH                   = 86205;
    const E_INVALID_SESSION_ID_VALUE                    = 86206;
    const E_SESSION_ADMIN_NOT_IN_MEMBER_LIST            = 86207;
    const E_MESSAGE_SERVICE_DISABLED                    = 86208;
    const E_MISSING_OPERATOR                            = 86209;
    const E_MISSING_SESSION_PARAMETER                   = 86210;
    const E_MISSING_SESSION_TYPE                        = 86211;
    const E_MISSING_SENDER_1                            = 86213;
    const E_INVALID_SESSION_TYPE                        = 86214;
    const E_SESSION_EXIST                               = 86215;
    const E_INVALID_SESSION_MEMBER                      = 86216;
    const E_SESSION_OPERATOR_NOT_IN_MEMBER_LIST         = 86217;
    const E_INVALID_SESSION_SENDER                      = 86218;
    const E_INVALID_SESSION_RECEIVER                    = 86219;
    const E_INVALID_SESSION_OPERATOR                    = 86220;
    const E_SENDER_RECEIVER_CANNOT_SAME_MEMBER          = 86221;
    const E_NOT_ALLOWED_ACCESSED_API                    = 86222;
    const E_INVALID_CHAT_MESSAGE_TYPE                   = 86304;
    const E_CUSTOMER_SERVICE_DISABLED                   = 86305;
    const E_MISSING_SENDER_2                            = 86306;
    const E_MISSING_SENDER_TYPE                         = 86307;
    const E_MISSING_SENDER_ID                           = 86308;
    const E_MISSING_RECEIVER                            = 86309;
    const E_MISSING_RECEIVER_TYPE                       = 86310;
    const E_MISSING_RECEIVER_ID                         = 86311;
    const E_MISSING_MESSAGE_TYPE                        = 86312;
    const E_MISSING_CUSTOMER_SERVICE                    = 86313;
    const E_CUSTOMER_SERVICE_NOT_UNIQUE                 = 86314;
    const E_INVALID_SENDER_TYPE                         = 86315;
    const E_INVALID_SENDER_ID                           = 86316;
    const E_INVALID_RECEIVER_TYPE                       = 86317;
    const E_INVALID_RECEIVER_ID                         = 86318;
    const E_INVALID_CUSTOMER_SERVICE                    = 86319;
    const E_INVALID_CUSTOMER_SERVICE_TYPE               = 86320;

    const E_NOT_AUTHORIZED_SHAKE_AROUND                 = 90001;
    const E_MISSING_SHAKE_TICKET                        = 90002;
    const E_INVALID_SHADE_TICKET                        = 90003;
    const E_SHAKE_TICKET_EXPIRE                         = 90004;
    const E_SHAKE_SERVICE_DISABLED                      = 90005;


    public static $messages = [

    ];


    public static function error($errno)
    {
        return isset(static::$messages[$errno]) ? static::$messages[$errno] : false;
    }
}