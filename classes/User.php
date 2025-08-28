<?php

class User {
    private Database $db;

    public function __construct(Database $database) {
        $this->db = $database;
    }

    // Authenticate user
    public function authenticate(string $username, string $password): ?array {
        $username = $this->db->escape_value($username);

        $sql = "SELECT id, username, hashed_password 
                FROM users 
                WHERE username = '{$username}' 
                LIMIT 1";
        $result = $this->db->query($sql);

        if ($this->db->num_rows($result) === 1) {
            $user = $this->db->fetch_array($result);

            // Compare entered password with stored hash
            if ($user['hashed_password'] === sha1($password)) {
                return $user;
            }
        }

        return null; // not found or wrong password
    }

    // Create a new user
    public function create(string $username, string $password): bool {
        $username = $this->db->escape_value($username);
        $hashed_password = sha1($password); // replace later with password_hash()

        $sql = "INSERT INTO users (username, hashed_password) 
                VALUES ('{$username}', '{$hashed_password}')";
        return $this->db->query($sql);
    }

    // Get user by ID
    public function find_by_id(int $id): ?array {
        $id = $this->db->escape_value($id);

        $sql = "SELECT * FROM users WHERE id = '{$id}' LIMIT 1";
        $result = $this->db->query($sql);

        if ($this->db->num_rows($result) === 1) {
            return $this->db->fetch_array($result);
        }

        return null;
    }
}
