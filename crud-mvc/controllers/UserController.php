<?php

class UserController extends AbstractController
{
    public function list(): void
    {
        $manager = new UserManager();
        $users = $manager->findAll();
        $this->render("users/list", ["users" => $users]);
    }

    public function show(): void
    {
        $id = (int)$_GET["id"];
        $manager = new UserManager();
        $user = $manager->findOne($id);
        $this->render("users/show", ["user" => $user]);
    }

    public function create(): void
    {
        $this->render("users/create", []);
    }

    public function checkCreate(): void
    {
        $user = new User(
            htmlspecialchars($_POST["email"]),
            htmlspecialchars($_POST["first_name"]),
            htmlspecialchars($_POST["last_name"])
        );

        $manager = new UserManager();
        $manager->create($user);

        $this->redirect("index.php");
    }

    public function update(): void
    {
        $id = (int)$_GET["id"];
        $manager = new UserManager();
        $user = $manager->findOne($id);
        $this->render("users/update", ["user" => $user]);
    }

    public function checkUpdate(): void
    {
        $id = (int)$_POST["id"];
        $manager = new UserManager();
        $user = $manager->findOne($id);

        $user->setEmail(htmlspecialchars($_POST["email"]));
        $user->setFirstName(htmlspecialchars($_POST["first_name"]));
        $user->setLastName(htmlspecialchars($_POST["last_name"]));

        $manager->update($user);

        $this->redirect("index.php");
    }

    public function delete(): void
    {
        $id = (int)$_GET["id"];
        $manager = new UserManager();
        $user = $manager->findOne($id);
        $manager->delete($user);

        $this->redirect("index.php");
    }
}