<?php

namespace model;

class User
{
    private ?int $id;
    private string $email;
    private bool $validated;
    private ?string $password;
    private string $phone;

    public function __construct( string $email, string $phone, string $password = null, int $id = null, int $validated = null )
    {

        $this->id = $id;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;

        // == 0 checks if the value is null
        if ($validated == 0) {
            $this->validated = false;
        } else {
            $this->validated = true;
        }


    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getValidated(): bool
    {
        return $this->validated;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @param string $validated
     */
    public function setValidated(string $validated): void
    {
        $this->validated = $validated;
    }
}