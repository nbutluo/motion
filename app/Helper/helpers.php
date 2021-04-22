<?php
if (! function_exists('is_super_admin')) {
    function is_super_admin($id) {
        return (int)$id == 1 ? true : false;
    }
}
