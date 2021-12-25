<?php 
declare(strict_types=1);
use Zend\Crypt\Password\Bcrypt;

class Users
{
    public const ROLE_ADMIN = 10;
    public const ROLE_USER  = 11;
    
    /**
     * @var integer
     */
    private int $id;

    private string $firstName;

    private string $lastName;

    private string $email;

    private string $password;

    private int $role = self::ROLE_USER;

    private $is_valid = 0;

    private \DateTimeInterface $createdAt;

    private \DateTimeInterface $updatedAt;

    private int $images_id;

    public function __construct()
    {
        if (empty($this->createdAt)) {
            $this->createdAt = new DateTime();
        }else{
            $this->updatedAt = new DateTime();
        }
    }

    /**
     * Get the value of id
     *
     * @return  integer
     */ 
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of firstName
     */ 
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */ 
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $this->notNull(htmlspecialchars($firstName), "Le champs nom est obligatoire!");

        return $this;
    }

    /**
     * Get the value of lastName
     */ 
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */ 
    public function setLastName(string $lastName): self
    {
        $this->notNull($lastName, "Le champs prénom est obligatoire!");
        $this->lastName = htmlspecialchars($lastName);

        return $this;
    }

    private function notNull(string $champ, string $message)
    {
        if (!htmlspecialchars($champ)) {
            require_once 'Exception/NotNullException.php';
            throw new NotNullException($message);
        }
    }

    /**
     * Get the value of email
     */ 
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail(string $email): self
    {
        $this->notNull($email, "Le champs email est obligatoire!");
        if(!filter_var(htmlspecialchars($email), FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Cet Mail n'est pas valide");
        }
        $this->email = htmlspecialchars($email);

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword(string $password): self
    {
        $this->notNull($password, "Le mot de passe est obligatoire!");

        $bcrypt = new Bcrypt();
        $hash = $bcrypt->create(htmlspecialchars($_POST['password'])); // password hashed

        $this->password = $hash;

        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRole(): int
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole(int $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of is_valid
     */ 
    public function getIs_valid()
    {
        return $this->is_valid;
    }

    /**
     * Set the value of is_valid
     *
     * @return  self
     */ 
    public function setIs_valid($is_valid): self
    {
        $this->is_valid = $is_valid;

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of updatedAt
     */ 
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of images_id
     */ 
    public function getImages_id(): int
    {
        return $this->images_id;
    }

    /**
     * Set the value of images_id
     *
     * @return  self
     */ 
    public function setImages_id(?int $images_id): self
    {
        $this->images_id = $images_id;

        return $this;
    }
}