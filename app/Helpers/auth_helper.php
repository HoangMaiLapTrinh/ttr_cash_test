<?php
    if (!function_exists('isAdmin')) {
        function isAdmin($roleId)
        {
            return (int)$roleId === 1;
        }
    }
?>