<?php
function logo($brand){
    $e = explode('/', $brand);
    return end($e);
}
