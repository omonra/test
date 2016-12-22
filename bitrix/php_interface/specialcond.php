<?

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/sale/general/sale_cond.php');

class CSaleCondStolnik extends CSaleCondCtrlComplex
{
    public static function GetClassName()
    {
        return __CLASS__;
    }

    public static function GetControlShow($arParams)
    {
        $arControls = static::GetControls();
        $arResult = array(
            'controlgroup' => true,
            'group' =>  false,
            'label' => 'Акция',
            'showIn' => static::GetShowIn($arParams['SHOW_IN_GROUPS']),
            'children' => array()
        );
        foreach ($arControls as &$arOneControl)
        {
            $arOne = array(
                'controlId' => $arOneControl['ID'],
                'group' => ('Y' == $arOneControl['GROUP']),
                'label' => $arOneControl['LABEL'],
                'showIn' => static::GetShowIn($arParams['SHOW_IN_GROUPS']),
                'control' => array(
                    array(
                        'id' => 'prefix',
                        'type' => 'prefix',
                        'text' => $arOneControl['PREFIX']
                    ),
                    static::GetLogicAtom($arOneControl['LOGIC']),
                    static::GetValueAtom($arOneControl['JS_VALUE'])
                )
            );
            if ($arOneControl['ID'] == 'CondBsktFldPrice' || $arOneControl['ID'] == 'CondBsktFldSumm')
            {
                $boolCurrency = false;
                if (static::$boolInit)
                {
                    if (isset(static::$arInitParams['CURRENCY']))
                    {
                        $arOne['control'][] = static::$arInitParams['CURRENCY'];
                        $boolCurrency = true;
                    }
                    elseif (isset(static::$arInitParams['SITE_ID']))
                    {
                        $strCurrency = CSaleLang::GetLangCurrency(static::$arInitParams['SITE_ID']);
                        if (!empty($strCurrency))
                        {
                            $arOne['control'][] = $strCurrency;
                            $boolCurrency = true;
                        }
                    }
                }
                if (!$boolCurrency)
                    $arOne = array();
            }
            elseif ('CondBsktFldWeight' == $arOneControl['ID'])
            {
                $arOne['control'][] = 'bbb';//Loc::getMessage('BT_MOD_SALE_COND_MESS_WEIGHT_UNIT');
            }
            if (!empty($arOne))
                $arResult['children'][] = $arOne;
        }
        if (isset($arOneControl))
            unset($arOneControl);

        return $arResult;
    }

    public static function Generate($arOneCondition, $arParams, $arControl, $arSubs = false)
    {
        $strResult = '';
        if (is_string($arControl))
        {
            $arControl = static::GetControls($arControl);
        }
        $boolError = !is_array($arControl);

        if (!$boolError)
        {
            $arValues = static::Check($arOneCondition, $arOneCondition, $arControl, false);
            $boolError = ($arValues === false);
        }

        if (!$boolError)
        {
            // $arLogic = static::SearchLogic($arValues['logic'], $arControl['LOGIC']);
            // if (!isset($arLogic['OP'][$arControl['MULTIPLE']]) || empty($arLogic['OP'][$arControl['MULTIPLE']]))
            // {
            //     $boolError = true;
            // }
            // else
            // {
            //     $multyField = is_array($arControl['FIELD']);
            //     $issetField = '';
            //     $valueField = '';
            //     if ($multyField)
            //     {
            //         $fieldsList = array();
            //         foreach ($arControl['FIELD'] as &$oneField)
            //         {
            //             $fieldsList[] = $arParams['BASKET_ROW'].'[\''.$oneField.'\']';
            //         }
            //         unset($oneField);
            //         $issetField = implode(') && isset (', $fieldsList);
            //         $valueField = implode('*',$fieldsList);
            //         unset($fieldsList);
            //     }
            //     else
            //     {
            //         $issetField = $arParams['BASKET_ROW'].'[\''.$arControl['FIELD'].'\']';
            //         $valueField = $issetField;
            //     }
            //     switch ($arControl['FIELD_TYPE'])
            //     {
            //         case 'int':
            //         case 'double':
            //             $strResult = str_replace(array('#FIELD#', '#VALUE#'), array($valueField, $arValues['value']), $arLogic['OP'][$arControl['MULTIPLE']]);
            //             break;
            //         case 'char':
            //         case 'string':
            //         case 'text':
            //             $strResult = str_replace(array('#FIELD#', '#VALUE#'), array($valueField, '"'.EscapePHPString($arValues['value']).'"'), $arLogic['OP'][$arControl['MULTIPLE']]);
            //             break;
            //         case 'date':
            //         case 'datetime':
            //             $strResult = str_replace(array('#FIELD#', '#VALUE#'), array($valueField, $arValues['value']), $arLogic['OP'][$arControl['MULTIPLE']]);
            //             break;
            //     }
            //     $strResult = 'isset('.$issetField.') && '.$strResult;
            // }

            $strResult = 'CheckActionIsApplyed($row, ' . (intval($arValues['value']) > 0 || $arValues['value'] == 'true' ? 1 : 0) . ')';
        }

        return (!$boolError ? $strResult : false);
    }

    /**
     * @param bool|string $strControlID
     * @return array|bool
     */
    public static function GetControls($strControlID = false)
    {
        $arControlList = array(
            'CondSpecialStolnikAction' => array(
                'ID' => 'CondSpecialStolnikAction',
                'FIELD' => 'ORDER_PRICE',
                'FIELD_TYPE' => 'double',
                'LABEL' => 'В корзине есть товары участвующие в акции', //Loc::getMessage('BT_MOD_SALE_COND_BASKET_ROW_SUMM_LABEL'),
                'PREFIX' => 'Есть акционные товары', //Loc::getMessage('BT_MOD_SALE_COND_BASKET_ROW_SUMM_EXT_PREFIX'),
                'LOGIC' => static::GetLogic(
                        array(
                            BT_COND_LOGIC_EQ,
                        )
                    ),
                'JS_VALUE' => array(
                    'type' => 'input'
                )
            ),
        );
        foreach ($arControlList as &$control)
        {
            $control['MODULE_ID'] = 'sale';
            $control['MODULE_ENTITY'] = 'sale';
            $control['ENTITY'] = 'BASKET';
            $control['MULTIPLE'] = 'N';
            $control['GROUP'] = 'N';
        }
        unset($control);

        if ($strControlID === false)
        {
            return $arControlList;
        }
        elseif (isset($arControlList[$strControlID]))
        {
            return $arControlList[$strControlID];
        }
        else
        {
            return false;
        }
    }

    public static function GetShowIn($arControls)
    {
        $arControls = CSaleCondCtrlBasketGroup::GetControlID();
        return $arControls;
    }
}

AddEventHandler("sale", "OnCondSaleControlBuildList", array("CSaleCondStolnik", "GetControlDescr"));
