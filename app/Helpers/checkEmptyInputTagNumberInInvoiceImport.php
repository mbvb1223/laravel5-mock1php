<?php

function checkEmptyInputTagNumberInInvoiceImport($inputNumber)
{
    foreach($inputNumber as $check){
        if($check != null){
            return false;
            break;
        }
    }
    return true;

}


