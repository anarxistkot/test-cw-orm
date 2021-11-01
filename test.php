<?php

namespace App\Entity;

use DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrganizationRepository")
 */
class Organization
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public int $id;

    /**
     * @ORM\Column(type="string")
     */
    public string $name;

    /**
     * @ORM\Column(type="string")
     */
    public string $inn;

    /**
     * @ORM\Column(type="string")
     */
    public string $kpp;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $active;
}

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public int $id;

    /**
     * @ORM\Column(type="string")
     */
    public string $name;
}

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public int $id;

    /**
     * @ORM\Column(type="string")
     */
    public string $state;

    /**
     * @ORM\Column(type="string")
     */
    public string $sum;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    public User $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product")
     */
    public Product $product;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     */
    private DateTime $updatedAt;

    /**
     * @ORM\Column(type="datetime", name="completed_at", nullable=true)
     */
    private DateTime $completedAt;
}

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public int $id;

    /**
     * @ORM\Column(type="string")
     */
    public string $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organization")
     */
    public Organization $organization;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $active;
}

?>

/** _______________________________________ */

<?php

namespace App\Service;

use App\Entity\Organization;
use App\Repository\OrganizationRepository;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use App\Repository\TransactionRepository;

class ReportService
{
    private OrganizationRepository $organizationRepository;

    private UserRepository $userRepository;

    private ProductRepository $productRepository;

    private TransactionRepository $transactionRepository;

    public function __construct(
        OrganizationRepository $organizationRepository,
        UserRepository $userRepository,
        ProductRepository $productRepository,
        TransactionRepository $transactionRepository
    ) {
        $this->organizationRepository = $organizationRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * На вход подается сущность родительской организации.
     * Необходимо построить отчет, который вернет следующие данные:
     * transaction.id, product.name, transaction.sum, user.name, organization.name, transaction.completed_at
     *
     * Данные необходимы по следующим условиям:
     * - Транзакции имеют state = 'Completed'
     * - Транзакции были совершены только активными пользователями из активных дочерних Организаций (ИНН дочерних Организаций совпадает с родительской)
     * - Отчет должен содержать транзакции завершенные только за последние 3 дня
     *
     * Данные в отчете должны быть отсортированы:
     * - по дате завершения транзакции от большей к меньшей
     */
    public function getReport(Organization $organization): array
    {
        // TODO:
    }
}

?>

/** _______________________________________ */

<?php

namespace App\Repository;

use App\Entity\Organization;
use App\Entity\Product;
use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Organization|null find($id, $lockMode = null, $lockVersion = null) * @method Organization|null findOneBy(array $criteria, array $orderBy = null)
 * @method Organization[]    findAll()
 * @method Organization[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganizationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Organization::class);
    }
}

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
}

/**
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }
}

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
}

?>
