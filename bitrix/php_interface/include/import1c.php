<?php

namespace Stolnik24\PhpInterface;

// mark session as import

AddEventHandler('catalog', 'OnBeforeCatalogImport1C', array(
    'Stolnik24\PhpInterface\Import1c',
    'onBeforeCatalogImport1c'
));

AddEventHandler('catalog', 'OnSuccessCatalogImport1C', array(
    'Stolnik24\PhpInterface\Import1c',
    'onSuccessCatalogImport1C'
));

// unset active state in import session

/*AddEventHandler('iblock', 'OnBeforeIBlockElementAdd', array(
    'Stolnik24\PhpInterface\Import1c',
    'onBeforeIBlockElementAdd'
));

AddEventHandler('iblock', 'OnBeforeIBlockElementUpdate', array(
    'Stolnik24\PhpInterface\Import1c',
    'onBeforeIBlockElementUpdate'
));*/

class Import1c
{
    public static function onBeforeIBlockElementAdd(&$fields)
    {
        /*if (
            static::isImportSession()
            && isset($fields['ACTIVE'])
            && $fields['ACTIVE'] != 'N'
        )
        {
            $fields['ACTIVE'] = 'N';
        }*/
    }

    public static function onBeforeIBlockElementUpdate(&$fields)
    {
        /*if (
            static::isImportSession()
            && isset($fields['ACTIVE'])
        )
        {
            unset($fields['ACTIVE']);
        }*/
    }

    public static function onBeforeCatalogImport1c()
    {
        static::setImportSession(true);
    }

    public static function onSuccessCatalogImport1C()
    {
        static::setImportSession(false);
    }

    public static function setImportSession($value)
    {
        $_SESSION['STOLNIK24_IS_IMPORT_1C'] = $value;
    }

    public static function isImportSession()
    {
        return !!$_SESSION['STOLNIK24_IS_IMPORT_1C'];
    }
}