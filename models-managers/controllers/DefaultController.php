<?php

class DefaultController extends AbstractController
{
    public function index(): void
    {
        $manager = new UserManager();

        // findAll
        $users = $manager->findAll();
        echo "<h2>findAll</h2>";
        foreach($users as $user) {
            var_dump($user->getFirstName() . ' ' . $user->getLastName());
        }

        // findOne
        $user = $manager->findOne(1);
        echo "<h2>findOne (id=1)</h2>";
        var_dump($user->getFirstName() . ' ' . $user->getLastName());

        // create
        $newUser = new User('Clark', 'Kent', 'clark.kent@test.fr', 'superman');
        $newUser = $manager->create($newUser);
        echo "<h2>create</h2>";
        var_dump($newUser->getId());

        // update
        $newUser->setFirstName('Kal');
        $manager->update($newUser);
        echo "<h2>update</h2>";
        var_dump($newUser->getFirstName());

        // delete
        $manager->delete($newUser);
        echo "<h2>delete</h2>";
        echo "Utilisateur supprimé !";
    }

    public function notFound(): void
    {
        $this->render("notFound", []);
    }
}