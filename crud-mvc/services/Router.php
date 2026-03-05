<?php

class Router
{
    public function __construct(){}

    public function handleRequest(): void
    {
        if(isset($_GET["route"]))
        {
            if($_GET["route"] === "show_user")
            {
                $ctrl = new UserController();
                $ctrl->show();
            }
            elseif($_GET["route"] === "create_user")
            {
                $ctrl = new UserController();
                $ctrl->create();
            }
            elseif($_GET["route"] === "check_create_user")
            {
                $ctrl = new UserController();
                $ctrl->checkCreate();
            }
            elseif($_GET["route"] === "update_user")
            {
                $ctrl = new UserController();
                $ctrl->update();
            }
            elseif($_GET["route"] === "check_update_user")
            {
                $ctrl = new UserController();
                $ctrl->checkUpdate();
            }
            elseif($_GET["route"] === "delete_user")
            {
                $ctrl = new UserController();
                $ctrl->delete();
            }
            else
            {
                $ctrl = new UserController();
                $ctrl->list();
            }
        }
        else
        {
            $ctrl = new UserController();
            $ctrl->list();
        }
    }
}