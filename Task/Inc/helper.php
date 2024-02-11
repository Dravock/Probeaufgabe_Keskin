<?php
declare(strict_types=1);

Class Helper extends AppInit
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_Appdata(): array
    {
        $init = new AppInit();
        $employees = $init->getAllEmployees();

        return $employees;
    }

    public function get_chronik_data():array
    {
        $chronik = new Chronik();
        $chronik_data = $chronik->get_chronik_data();

        return $chronik_data;
    }
}