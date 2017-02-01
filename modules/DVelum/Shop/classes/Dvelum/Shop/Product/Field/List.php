<?php

class Dvelum_Shop_Product_Field_List extends Dvelum_Shop_Product_Field_String
{
    protected function checkValue($value)
    {
        return in_array($value,$this->config['list'],true);
    }
}