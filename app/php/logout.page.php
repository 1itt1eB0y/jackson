<?php
class php_logout
{
    public function PageEntry($inPath)
    {
        if (!session_id()) {
            session_start();
        }

        if ($_SESSION['islogin']) {
            unset($_SESSION['islogin']);
            unset($_SESSION['username']);
            session_destroy();
            header("Location: /login");
        }
        return 0;
    }

}