<?php

class UserManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll(): array
    {
        $query = $this->db->prepare('SELECT * FROM users');
        $query->execute([]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $users = [];

        foreach($results as $result)
        {
            $user = new User(
                $result["email"],
                $result["first_name"],
                $result["last_name"],
                $result["id"]
            );
            $users[] = $user;
        }

        return $users;
    }

    public function findOne(int $id): User
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $query->execute(['id' => $id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        return new User(
            $result["email"],
            $result["first_name"],
            $result["last_name"],
            $result["id"]
        );
    }

    public function create(User $user): User
    {
        $query = $this->db->prepare('
            INSERT INTO users (email, first_name, last_name)
            VALUES (:email, :firstName, :lastName)
        ');
        $query->execute([
            'email'     => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName'  => $user->getLastName()
        ]);

        $user->setId((int) $this->db->lastInsertId());
        return $user;
    }

    public function update(User $user): User
    {
        $query = $this->db->prepare('
            UPDATE users
            SET email      = :email,
                first_name = :firstName,
                last_name  = :lastName
            WHERE id = :id
        ');
        $query->execute([
            'email'     => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName'  => $user->getLastName(),
            'id'        => $user->getId()
        ]);

        return $user;
    }

    public function delete(User $user): void
    {
        $query = $this->db->prepare('DELETE FROM users WHERE id = :id');
        $query->execute(['id' => $user->getId()]);
    }
}