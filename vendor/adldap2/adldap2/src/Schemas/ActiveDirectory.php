<?php

namespace Adldap\Schemas;

/**
 * Class ActiveDirectory.
 *
 * The active directory attribute schema for easy auto completion retrieval.
 */
class ActiveDirectory
{
    const ACCOUNT_EXPIRES = 'accountexpires';
    const ACCOUNT_NAME = 'samaccountname';
    const ACCOUNT_TYPE = 'samaccounttype';
    const ADDRESS_HOME = 'homepostaladdress';
    const ADMIN_DISPLAY_NAME = 'admindisplayname';
    const ANR = 'anr';
    const BAD_PASSWORD_COUNT = 'badpwdcount';
    const BAD_PASSWORD_TIME = 'badpasswordtime';
    const COMMON_NAME = 'cn';
    const COMPANY = 'company';
    const COMPUTER = 'computer';
    const CONFIGURATION_NAMING_CONTEXT = 'configurationnamingcontext';
    const CONTACT = 'contact';
    const COUNTRY = 'c';
    const CREATED_AT = 'whencreated';
    const DEFAULT_NAMING_CONTEXT = 'defaultnamingcontext';
    const DEPARTMENT = 'department';
    const DESCRIPTION = 'description';
    const DISPLAY_NAME = 'displayname';
    const DISTINGUISHED_NAME = 'dn';
    const DNS_HOST_NAME = 'dnshostname';
    const DOMAIN_COMPONENT = 'dc';
    const DRIVER_NAME = 'drivername';
    const DRIVER_VERSION = 'driverversion';
    const EMAIL = 'mail';
    const EMAIL_NICKNAME = 'mailnickname';
    const EMPLOYEE_ID = 'employeeid';
    const EMPLOYEE_NUMBER = 'employeenumber';
    const EMPLOYEE_TYPE = 'employeetype';
    const FALSE = 'FALSE';
    const FIRST_NAME = 'givenname';
    const GROUP_TYPE = 'grouptype';
    const HOME_MDB = 'homemdb';
    const INITIALS = 'initials';
    const INSTANCE_TYPE = 'instancetype';
    const IS_CRITICAL_SYSTEM_OBJECT = 'iscriticalsystemobject';
    const LAST_LOGOFF = 'lastlogoff';
    const LAST_LOGON = 'lastlogon';
    const LAST_LOGON_TIMESTAMP = 'lastlogontimestamp';
    const LAST_NAME = 'sn';
    const LEGACY_EXCHANGE_DN = 'legacyexchangedn';
    const LOCALE = 'l';
    const LOCATION = 'location';
    const LOCKOUT_TIME = 'lockouttime';
    const MAX_PASSWORD_AGE = 'maxpwdage';
    const MEMBER = 'member';
    const MEMBER_OF = 'memberof';
    const MESSAGE_TRACKING_ENABLED = 'messagetrackingenabled';
    const MS_EXCHANGE_SERVER = 'ms-exch-exchange-server';
    const NAME = 'name';
    const OBJECT_CATEGORY = 'objectcategory';
    const OBJECT_CATEGORY_COMPUTER = 'computer';
    const OBJECT_CATEGORY_CONTAINER = 'container';
    const OBJECT_CATEGORY_EXCHANGE_PRIVATE_MDB = 'msexchprivatemdb';
    const OBJECT_CATEGORY_EXCHANGE_SERVER = 'msExchExchangeServer';
    const OBJECT_CATEGORY_EXCHANGE_STORAGE_GROUP = 'msExchStorageGroup';
    const OBJECT_CATEGORY_GROUP = 'group';
    const OBJECT_CATEGORY_PERSON = 'person';
    const OBJECT_CATEGORY_PRINTER = 'print-queue';
    const OBJECT_CLASS = 'objectclass';
    const OBJECT_GUID = 'objectguid';
    const OBJECT_SID = 'objectsid';
    const OPERATING_SYSTEM = 'operatingsystem';
    const OPERATING_SYSTEM_SERVICE_PACK = 'operatingsystemservicepack';
    const OPERATING_SYSTEM_VERSION = 'operatingsystemversion';
    const ORGANIZATIONAL_PERSON = 'organizationalperson';
    const ORGANIZATIONAL_UNIT_LONG = 'organizationalunit';
    const ORGANIZATIONAL_UNIT_SHORT = 'ou';
    const PASSWORD_LAST_SET = 'pwdlastset';
    const PERSON = 'person';
    const PHYSICAL_DELIVERY_OFFICE_NAME = 'physicaldeliveryofficename';
    const PORT_NAME = 'portname';
    const POSTAL_CODE = 'postalcode';
    const PRIMARY_GROUP_ID = 'primarygroupid';
    const PRINTER_BIN_NAMES = 'printbinnames';
    const PRINTER_COLOR_SUPPORTED = 'printcolor';
    const PRINTER_DUPLEX_SUPPORTED = 'printduplexsupported';
    const PRINTER_END_TIME = 'printendtime';
    const PRINTER_MAX_RESOLUTION_SUPPORTED = 'printmaxresolutionsupported';
    const PRINTER_MEDIA_SUPPORTED = 'printmediasupported';
    const PRINTER_MEMORY = 'printmemory';
    const PRINTER_NAME = 'printername';
    const PRINTER_ORIENTATION_SUPPORTED = 'printorientationssupported';
    const PRINTER_PRINT_RATE = 'printrate';
    const PRINTER_PRINT_RATE_UNIT = 'printrateunit';
    const PRINTER_SHARE_NAME = 'printsharename';
    const PRINTER_STAPLING_SUPPORTED = 'printstaplingsupported';
    const PRINTER_START_TIME = 'printstarttime';
    const PRIORITY = 'priority';
    const PROFILE_PATH = 'profilepath';
    const PROXY_ADDRESSES = 'proxyaddresses';
    const SCRIPT_PATH = 'scriptpath';
    const SERIAL_NUMBER = 'serialnumber';
    const SERVER_NAME = 'servername';
    const SHOW_IN_ADDRESS_BOOK = 'showinaddressbook';
    const STREET = 'street';
    const STREET_ADDRESS = 'streetaddress';
    const SYSTEM_FLAGS = 'systemflags';
    const TELEPHONE = 'telephonenumber';
    const TITLE = 'title';
    const TOP = 'top';
    const TRUE = 'TRUE';
    const UNICODE_PASSWORD = 'unicodepwd';
    const UPDATED_AT = 'whenchanged';
    const URL = 'url';
    const USER = 'user';
    const USER_ACCOUNT_CONTROL = 'useraccountcontrol';
    const USER_PRINCIPAL_NAME = 'userprincipalname';
    const VERSION_NUMBER = 'versionnumber';
}
