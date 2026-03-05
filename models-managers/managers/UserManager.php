<?php

class UserManager extends AbstractManager
{
    public function __construct()
    {
        // On appelle le constructeur du parent (AbstractManager)
        // pour initialiser la connexion à la base de données ($this->db)
        parent::__construct();
    }

    // Récupère TOUS les utilisateurs de la base de données
    // Retourne un tableau d'objets User
    public function findAll(): array
    {
        // On prépare la requête SQL pour récupérer tous les utilisateurs
        $query = $this->db->prepare('SELECT * FROM users');

        // On exécute la requête (pas de paramètres ici)
        $query->execute([]);

        // fetchAll récupère TOUTES les lignes du résultat
        // PDO::FETCH_ASSOC retourne chaque ligne sous forme de tableau associatif
        // ex: ["firstName" => "John", "lastName" => "Doe", ...]
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        // Tableau vide qui va accueillir nos objets User
        $users = [];

        // Pour chaque ligne récupérée en base, on crée un objet User
        foreach($results as $result)
        {
            $user = new User(
                $result["firstName"],  // prénom
                $result["lastName"],   // nom
                $result["email"],      // email
                $result["password"],   // mot de passe
                $result["created_at"], // date de création
                $result["id"]          // id
            );
            // On ajoute l'objet User dans le tableau
            $users[] = $user;
        }

        // On retourne le tableau contenant tous les objets User
        return $users;
    }

    // Récupère UN seul utilisateur par son id
    // Retourne un objet User
    public function findOne(int $id): User
    {
        // On prépare la requête avec un paramètre :id
        $query = $this->db->prepare('SELECT * FROM users WHERE id = :id');

        // On exécute en remplaçant :id par la valeur reçue en paramètre
        $query->execute(['id' => $id]);

        // fetch récupère UNE SEULE ligne (la première)
        $result = $query->fetch(PDO::FETCH_ASSOC);

        // On crée et retourne directement un objet User avec les données récupérées
        return new User(
            $result["firstName"],
            $result["lastName"],
            $result["email"],
            $result["password"],
            $result["created_at"],
            $result["id"]
        );
    }

    // Insère un nouvel utilisateur en base de données
    // Reçoit un objet User et retourne ce même objet avec son id mis à jour
    public function create(User $user): User
    {
        // On prépare la requête INSERT avec des paramètres nommés
        // NOW() est une fonction SQL qui insère la date et l'heure actuelle
        $query = $this->db->prepare('
            INSERT INTO users (firstName, lastName, email, password, created_at)
            VALUES (:firstName, :lastName, :email, :password, NOW())
        ');

        // On exécute en passant les valeurs de l'objet User via ses getters
        $query->execute([
            'firstName' => $user->getFirstName(),
            'lastName'  => $user->getLastName(),
            'email'     => $user->getEmail(),
            'password'  => $user->getPassword()
        ]);

        // lastInsertId() récupère l'id auto-généré par MySQL pour la nouvelle ligne
        // On met à jour l'objet User avec cet id
        $user->setId((int) $this->db->lastInsertId());

        // On retourne l'objet User avec son id mis à jour
        return $user;
    }

    // Met à jour un utilisateur existant en base de données
    // Reçoit un objet User et retourne ce même objet
    public function update(User $user): User
    {
        // On prépare la requête UPDATE
        // SET définit les colonnes à modifier
        // WHERE id = :id cible uniquement l'utilisateur concerné
        $query = $this->db->prepare('
            UPDATE users
            SET firstName = :firstName,
                lastName  = :lastName,
                email     = :email,
                password  = :password
            WHERE id = :id
        ');

        // On exécute avec les nouvelles valeurs + l'id pour cibler le bon utilisateur
        $query->execute([
            'firstName' => $user->getFirstName(),
            'lastName'  => $user->getLastName(),
            'email'     => $user->getEmail(),
            'password'  => $user->getPassword(),
            'id'        => $user->getId()
        ]);

        // On retourne l'objet User mis à jour
        return $user;
    }

    // Supprime un utilisateur de la base de données
    // Reçoit un objet User, ne retourne rien (void)
    public function delete(User $user): void
    {
        // On prépare la requête DELETE avec l'id de l'utilisateur à supprimer
        $query = $this->db->prepare('DELETE FROM users WHERE id = :id');

        // On exécute en passant l'id de l'objet User
        $query->execute(['id' => $user->getId()]);
    }
}