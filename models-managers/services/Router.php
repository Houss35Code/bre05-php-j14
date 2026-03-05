<?php

class Router
{
    public function __construct(){}

    public function handleRequest(): void
    {
        if(!isset($_GET["route"]) || empty($_GET["route"]))
        {
            $ctrl = new DefaultController();
            $ctrl->index();
        }
        else
        {
            $ctrl = new DefaultController();
            $ctrl->notFound();
        }
    }
}