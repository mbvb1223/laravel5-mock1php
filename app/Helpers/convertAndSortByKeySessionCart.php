<?php
/**
 * Convert $sessionCart[$productid|colorid|sizeid] => $sessionCart[($productid*100.000)+(colorid*100)+(sizeid)]
 * @param $sessionCart
 * @return array
 */
function convertAndSortByKeySessionCart($sessionCart)
{
    foreach ($sessionCart as $key => $itemCart) {
        $explodeKey = explode("|",$key);
        $newKey = $explodeKey[0]*100000 + $explodeKey[1]*100 + $explodeKey[2];
        $itemCart['key'] = $key;
        $returnArray[$newKey] = $itemCart;
    }
    ksort($returnArray);
    return $returnArray;
}
