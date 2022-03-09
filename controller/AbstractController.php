<?php 
namespace controller;

abstract class AbstractController {
    private string $root;

    public function __construct() {
        $this->root = $_SERVER["DOCUMENT_ROOT"];
    }

    protected function getPathViewLogin() {
        return '../../view/user/login.php';
    }

    protected function getPathViewRegister() {
        return '../../view/user/register.php';
    }

    protected function getPathViewVerification() {
        return '../../view/user/verification.php';
    }

    protected function getPathViewIndex() {
        return '../../view/main/index.php';
    }

    protected function getPathViewError500() {
        return '../../view/error/error_500.php';
    }

    protected function getPathErrorLog() {
        return $this->root . '/errors.log';
    }
}
