# PHP Design Patterns Guide

This guide demonstrates common design patterns used in PHP development with practical code examples.

## Table of Contents

1. [Creational Patterns](#creational-patterns)
   - [Singleton](#singleton)
   - [Factory Method](#factory-method)
   - [Builder](#builder)
2. [Structural Patterns](#structural-patterns)
   - [Adapter](#adapter)
   - [Decorator](#decorator)
   - [Facade](#facade)
3. [Behavioral Patterns](#behavioral-patterns)
   - [Observer](#observer)
   - [Strategy](#strategy)
   - [Command](#command)
   - [Template Method](#template-method)
4. [PHP-Specific Patterns](#php-specific-patterns)
   - [Repository](#repository)
   - [Dependency Injection](#dependency-injection)
   - [Middleware](#middleware)

## Creational Patterns

### Singleton

Ensures only one instance of a class exists throughout the application lifecycle.

```php
class Database
{
    private static $instance = null;
    private $connection;
    
    private function __construct()
    {
        $this->connection = new PDO('mysql:host=localhost;dbname=test', 'user', 'pass');
    }
    
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection(): PDO
    {
        return $this->connection;
    }
    
    // Prevent cloning and unserialization
    private function __clone() {}
    public function __wakeup() {}
}

// Usage
$db1 = Database::getInstance();
$db2 = Database::getInstance();
// $db1 and $db2 are the same instance
```

### Factory Method

Creates objects without specifying their exact classes.

```php
interface PaymentProcessor
{
    public function processPayment(float $amount): bool;
}

class PayPalProcessor implements PaymentProcessor
{
    public function processPayment(float $amount): bool
    {
        echo "Processing $amount via PayPal\n";
        return true;
    }
}

class StripeProcessor implements PaymentProcessor
{
    public function processPayment(float $amount): bool
    {
        echo "Processing $amount via Stripe\n";
        return true;
    }
}

class CreditCardProcessor implements PaymentProcessor
{
    public function processPayment(float $amount): bool
    {
        echo "Processing $amount via Credit Card\n";
        return true;
    }
}

class PaymentFactory
{
    public static function create(string $type): PaymentProcessor
    {
        switch ($type) {
            case 'paypal':
                return new PayPalProcessor();
            case 'stripe':
                return new StripeProcessor();
            case 'creditcard':
                return new CreditCardProcessor();
            default:
                throw new InvalidArgumentException("Unknown payment type: $type");
        }
    }
}

// Usage
$processor = PaymentFactory::create('stripe');
$processor->processPayment(100.00);
```

### Builder

Constructs complex objects step by step.

```php
class DatabaseQuery
{
    private $select = [];
    private $from = '';
    private $where = [];
    private $orderBy = [];
    private $limit = null;
    
    public function select(array $fields): self
    {
        $this->select = $fields;
        return $this;
    }
    
    public function from(string $table): self
    {
        $this->from = $table;
        return $this;
    }
    
    public function where(string $condition): self
    {
        $this->where[] = $condition;
        return $this;
    }
    
    public function orderBy(string $field, string $direction = 'ASC'): self
    {
        $this->orderBy[] = "$field $direction";
        return $this;
    }
    
    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }
    
    public function build(): string
    {
        $sql = 'SELECT ' . implode(', ', $this->select);
        $sql .= ' FROM ' . $this->from;
        
        if (!empty($this->where)) {
            $sql .= ' WHERE ' . implode(' AND ', $this->where);
        }
        
        if (!empty($this->orderBy)) {
            $sql .= ' ORDER BY ' . implode(', ', $this->orderBy);
        }
        
        if ($this->limit !== null) {
            $sql .= ' LIMIT ' . $this->limit;
        }
        
        return $sql;
    }
}

// Usage
$query = (new DatabaseQuery())
    ->select(['id', 'name', 'email'])
    ->from('users')
    ->where('active = 1')
    ->where('age > 18')
    ->orderBy('name')
    ->limit(10)
    ->build();

echo $query;
// SELECT id, name, email FROM users WHERE active = 1 AND age > 18 ORDER BY name LIMIT 10
```

## Structural Patterns

### Adapter

Allows incompatible interfaces to work together.

```php
// Third-party email service
class ThirdPartyEmailService
{
    public function sendEmail(string $to, string $subject, string $body): void
    {
        echo "Sending email via third-party service to $to\n";
    }
}

// Our application's email interface
interface EmailServiceInterface
{
    public function send(string $recipient, string $title, string $message): bool;
}

// Adapter to make third-party service compatible with our interface
class EmailServiceAdapter implements EmailServiceInterface
{
    private $thirdPartyService;
    
    public function __construct(ThirdPartyEmailService $service)
    {
        $this->thirdPartyService = $service;
    }
    
    public function send(string $recipient, string $title, string $message): bool
    {
        try {
            $this->thirdPartyService->sendEmail($recipient, $title, $message);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

// Usage
$thirdPartyService = new ThirdPartyEmailService();
$emailService = new EmailServiceAdapter($thirdPartyService);
$emailService->send('user@example.com', 'Hello', 'Welcome to our service!');
```

### Decorator

Adds behavior to objects dynamically without altering their structure.

```php
interface Coffee
{
    public function getCost(): float;
    public function getDescription(): string;
}

class SimpleCoffee implements Coffee
{
    public function getCost(): float
    {
        return 2.00;
    }
    
    public function getDescription(): string
    {
        return 'Simple coffee';
    }
}

abstract class CoffeeDecorator implements Coffee
{
    protected $coffee;
    
    public function __construct(Coffee $coffee)
    {
        $this->coffee = $coffee;
    }
    
    public function getCost(): float
    {
        return $this->coffee->getCost();
    }
    
    public function getDescription(): string
    {
        return $this->coffee->getDescription();
    }
}

class MilkDecorator extends CoffeeDecorator
{
    public function getCost(): float
    {
        return $this->coffee->getCost() + 0.50;
    }
    
    public function getDescription(): string
    {
        return $this->coffee->getDescription() . ', milk';
    }
}

class SugarDecorator extends CoffeeDecorator
{
    public function getCost(): float
    {
        return $this->coffee->getCost() + 0.25;
    }
    
    public function getDescription(): string
    {
        return $this->coffee->getDescription() . ', sugar';
    }
}

// Usage
$coffee = new SimpleCoffee();
$coffee = new MilkDecorator($coffee);
$coffee = new SugarDecorator($coffee);

echo $coffee->getDescription() . ' costs $' . $coffee->getCost();
// Simple coffee, milk, sugar costs $2.75
```

### Facade

Provides a simplified interface to a complex subsystem.

```php
class CPU
{
    public function freeze(): void { echo "CPU frozen\n"; }
    public function jump(int $position): void { echo "CPU jumped to $position\n"; }
    public function execute(): void { echo "CPU executing\n"; }
}

class Memory
{
    public function load(int $position, string $data): void
    {
        echo "Memory loaded $data at position $position\n";
    }
}

class HardDrive
{
    public function read(int $lba, int $size): string
    {
        echo "Hard drive reading $size bytes from LBA $lba\n";
        return "boot data";
    }
}

// Facade
class ComputerFacade
{
    private $cpu;
    private $memory;
    private $hardDrive;
    
    public function __construct()
    {
        $this->cpu = new CPU();
        $this->memory = new Memory();
        $this->hardDrive = new HardDrive();
    }
    
    public function start(): void
    {
        echo "Starting computer...\n";
        $this->cpu->freeze();
        $bootData = $this->hardDrive->read(0, 1024);
        $this->memory->load(0, $bootData);
        $this->cpu->jump(0);
        $this->cpu->execute();
        echo "Computer started successfully!\n";
    }
}

// Usage
$computer = new ComputerFacade();
$computer->start();
```

## Behavioral Patterns

### Observer

Defines a one-to-many dependency between objects so that when one object changes state, all dependents are notified.

```php
interface Observer
{
    public function update(string $event, $data): void;
}

interface Subject
{
    public function attach(Observer $observer): void;
    public function detach(Observer $observer): void;
    public function notify(string $event, $data): void;
}

class User implements Subject
{
    private $observers = [];
    private $email;
    private $name;
    
    public function __construct(string $email, string $name)
    {
        $this->email = $email;
        $this->name = $name;
    }
    
    public function attach(Observer $observer): void
    {
        $this->observers[] = $observer;
    }
    
    public function detach(Observer $observer): void
    {
        $key = array_search($observer, $this->observers, true);
        if ($key !== false) {
            unset($this->observers[$key]);
        }
    }
    
    public function notify(string $event, $data): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($event, $data);
        }
    }
    
    public function setEmail(string $email): void
    {
        $this->email = $email;
        $this->notify('email_changed', ['new_email' => $email, 'user' => $this->name]);
    }
    
    public function getEmail(): string
    {
        return $this->email;
    }
}

class EmailNotificationObserver implements Observer
{
    public function update(string $event, $data): void
    {
        if ($event === 'email_changed') {
            echo "Email notification: User {$data['user']} changed email to {$data['new_email']}\n";
        }
    }
}

class LoggingObserver implements Observer
{
    public function update(string $event, $data): void
    {
        echo "Log: Event '$event' occurred with data: " . json_encode($data) . "\n";
    }
}

// Usage
$user = new User('john@example.com', 'John Doe');
$user->attach(new EmailNotificationObserver());
$user->attach(new LoggingObserver());

$user->setEmail('john.doe@example.com');
```

### Strategy

Defines a family of algorithms, encapsulates each one, and makes them interchangeable.

```php
interface SortingStrategy
{
    public function sort(array $data): array;
}

class BubbleSortStrategy implements SortingStrategy
{
    public function sort(array $data): array
    {
        echo "Sorting using bubble sort\n";
        $n = count($data);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($data[$j] > $data[$j + 1]) {
                    $temp = $data[$j];
                    $data[$j] = $data[$j + 1];
                    $data[$j + 1] = $temp;
                }
            }
        }
        return $data;
    }
}

class QuickSortStrategy implements SortingStrategy
{
    public function sort(array $data): array
    {
        echo "Sorting using quick sort\n";
        if (count($data) < 2) {
            return $data;
        }
        
        $pivot = $data[0];
        $left = $right = [];
        
        for ($i = 1; $i < count($data); $i++) {
            if ($data[$i] < $pivot) {
                $left[] = $data[$i];
            } else {
                $right[] = $data[$i];
            }
        }
        
        return array_merge($this->sort($left), [$pivot], $this->sort($right));
    }
}

class SortContext
{
    private $strategy;
    
    public function setStrategy(SortingStrategy $strategy): void
    {
        $this->strategy = $strategy;
    }
    
    public function sort(array $data): array
    {
        return $this->strategy->sort($data);
    }
}

// Usage
$data = [64, 34, 25, 12, 22, 11, 90];
$sorter = new SortContext();

$sorter->setStrategy(new BubbleSortStrategy());
$result1 = $sorter->sort($data);

$sorter->setStrategy(new QuickSortStrategy());
$result2 = $sorter->sort($data);
```

### Command

Encapsulates a request as an object, allowing you to parameterize clients with different requests.

```php
interface Command
{
    public function execute(): void;
    public function undo(): void;
}

class Light
{
    private $isOn = false;
    
    public function turnOn(): void
    {
        $this->isOn = true;
        echo "Light is ON\n";
    }
    
    public function turnOff(): void
    {
        $this->isOn = false;
        echo "Light is OFF\n";
    }
    
    public function isOn(): bool
    {
        return $this->isOn;
    }
}

class LightOnCommand implements Command
{
    private $light;
    
    public function __construct(Light $light)
    {
        $this->light = $light;
    }
    
    public function execute(): void
    {
        $this->light->turnOn();
    }
    
    public function undo(): void
    {
        $this->light->turnOff();
    }
}

class LightOffCommand implements Command
{
    private $light;
    
    public function __construct(Light $light)
    {
        $this->light = $light;
    }
    
    public function execute(): void
    {
        $this->light->turnOff();
    }
    
    public function undo(): void
    {
        $this->light->turnOn();
    }
}

class RemoteControl
{
    private $command;
    private $lastCommand;
    
    public function setCommand(Command $command): void
    {
        $this->command = $command;
    }
    
    public function pressButton(): void
    {
        $this->command->execute();
        $this->lastCommand = $this->command;
    }
    
    public function pressUndo(): void
    {
        if ($this->lastCommand) {
            $this->lastCommand->undo();
        }
    }
}

// Usage
$light = new Light();
$lightOn = new LightOnCommand($light);
$lightOff = new LightOffCommand($light);

$remote = new RemoteControl();
$remote->setCommand($lightOn);
$remote->pressButton(); // Light is ON
$remote->pressUndo();   // Light is OFF
```

### Template Method

Defines the skeleton of an algorithm in a base class, letting subclasses override specific steps.

```php
abstract class DataProcessor
{
    // Template method
    public final function processData(): void
    {
        $data = $this->readData();
        $processedData = $this->process($data);
        $this->saveData($processedData);
    }
    
    abstract protected function readData(): array;
    abstract protected function process(array $data): array;
    abstract protected function saveData(array $data): void;
}

class CSVDataProcessor extends DataProcessor
{
    protected function readData(): array
    {
        echo "Reading data from CSV file\n";
        return ['csv', 'data', 'here'];
    }
    
    protected function process(array $data): array
    {
        echo "Processing CSV data\n";
        return array_map('strtoupper', $data);
    }
    
    protected function saveData(array $data): void
    {
        echo "Saving processed CSV data: " . implode(', ', $data) . "\n";
    }
}

class XMLDataProcessor extends DataProcessor
{
    protected function readData(): array
    {
        echo "Reading data from XML file\n";
        return ['<xml>', '<data>', '</xml>'];
    }
    
    protected function process(array $data): array
    {
        echo "Processing XML data\n";
        return array_map('strlen', $data);
    }
    
    protected function saveData(array $data): void
    {
        echo "Saving processed XML data: " . implode(', ', $data) . "\n";
    }
}

// Usage
$csvProcessor = new CSVDataProcessor();
$csvProcessor->processData();

$xmlProcessor = new XMLDataProcessor();
$xmlProcessor->processData();
```

## PHP-Specific Patterns

### Repository

Encapsulates the logic needed to access data sources.

```php
interface UserRepositoryInterface
{
    public function find(int $id): ?User;
    public function findAll(): array;
    public function save(User $user): void;
    public function delete(int $id): void;
}

class User
{
    private $id;
    private $name;
    private $email;
    
    public function __construct(?int $id, string $name, string $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }
    
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function setId(int $id): void { $this->id = $id; }
}

class DatabaseUserRepository implements UserRepositoryInterface
{
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function find(int $id): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$data) {
            return null;
        }
        
        return new User($data['id'], $data['name'], $data['email']);
    }
    
    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM users');
        $users = [];
        
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User($data['id'], $data['name'], $data['email']);
        }
        
        return $users;
    }
    
    public function save(User $user): void
    {
        if ($user->getId()) {
            $stmt = $this->pdo->prepare('UPDATE users SET name = ?, email = ? WHERE id = ?');
            $stmt->execute([$user->getName(), $user->getEmail(), $user->getId()]);
        } else {
            $stmt = $this->pdo->prepare('INSERT INTO users (name, email) VALUES (?, ?)');
            $stmt->execute([$user->getName(), $user->getEmail()]);
            $user->setId($this->pdo->lastInsertId());
        }
    }
    
    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$id]);
    }
}

// In-memory implementation for testing
class InMemoryUserRepository implements UserRepositoryInterface
{
    private $users = [];
    private $nextId = 1;
    
    public function find(int $id): ?User
    {
        return $this->users[$id] ?? null;
    }
    
    public function findAll(): array
    {
        return array_values($this->users);
    }
    
    public function save(User $user): void
    {
        if (!$user->getId()) {
            $user->setId($this->nextId++);
        }
        $this->users[$user->getId()] = $user;
    }
    
    public function delete(int $id): void
    {
        unset($this->users[$id]);
    }
}

// Usage
$repository = new InMemoryUserRepository();
$user = new User(null, 'John Doe', 'john@example.com');
$repository->save($user);
$foundUser = $repository->find($user->getId());
```

### Dependency Injection

Provides dependencies to a class rather than having the class create them itself.

```php
interface LoggerInterface
{
    public function log(string $message): void;
}

class FileLogger implements LoggerInterface
{
    private $filename;
    
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }
    
    public function log(string $message): void
    {
        file_put_contents($this->filename, date('Y-m-d H:i:s') . ": $message\n", FILE_APPEND);
    }
}

class ConsoleLogger implements LoggerInterface
{
    public function log(string $message): void
    {
        echo date('Y-m-d H:i:s') . ": $message\n";
    }
}

interface EmailServiceInterface
{
    public function send(string $to, string $subject, string $body): bool;
}

class SmtpEmailService implements EmailServiceInterface
{
    public function send(string $to, string $subject, string $body): bool
    {
        echo "Sending email via SMTP to $to\n";
        return true;
    }
}

class UserService
{
    private $userRepository;
    private $logger;
    private $emailService;
    
    public function __construct(
        UserRepositoryInterface $userRepository,
        LoggerInterface $logger,
        EmailServiceInterface $emailService
    ) {
        $this->userRepository = $userRepository;
        $this->logger = $logger;
        $this->emailService = $emailService;
    }
    
    public function createUser(string $name, string $email): User
    {
        $this->logger->log("Creating user: $name");
        
        $user = new User(null, $name, $email);
        $this->userRepository->save($user);
        
        $this->emailService->send($email, 'Welcome!', 'Welcome to our service!');
        $this->logger->log("User created with ID: " . $user->getId());
        
        return $user;
    }
}

// Simple DI Container
class Container
{
    private $bindings = [];
    
    public function bind(string $abstract, callable $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }
    
    public function resolve(string $abstract)
    {
        if (!isset($this->bindings[$abstract])) {
            throw new Exception("No binding found for $abstract");
        }
        
        return $this->bindings[$abstract]($this);
    }
}

// Usage
$container = new Container();

$container->bind(LoggerInterface::class, function ($c) {
    return new ConsoleLogger();
});

$container->bind(EmailServiceInterface::class, function ($c) {
    return new SmtpEmailService();
});

$container->bind(UserRepositoryInterface::class, function ($c) {
    return new InMemoryUserRepository();
});

$container->bind(UserService::class, function ($c) {
    return new UserService(
        $c->resolve(UserRepositoryInterface::class),
        $c->resolve(LoggerInterface::class),
        $c->resolve(EmailServiceInterface::class)
    );
});

$userService = $container->resolve(UserService::class);
$user = $userService->createUser('Jane Doe', 'jane@example.com');
```

### Middleware

Provides a convenient mechanism for filtering HTTP requests.

```php
interface MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response;
}

class Request
{
    private $uri;
    private $method;
    private $headers;
    private $body;
    
    public function __construct(string $uri, string $method = 'GET', array $headers = [], string $body = '')
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->headers = $headers;
        $this->body = $body;
    }
    
    public function getUri(): string { return $this->uri; }
    public function getMethod(): string { return $this->method; }
    public function getHeaders(): array { return $this->headers; }
    public function getHeader(string $name): ?string { return $this->headers[$name] ?? null; }
    public function getBody(): string { return $this->body; }
}

class Response
{
    private $statusCode;
    private $body;
    private $headers;
    
    public function __construct(int $statusCode = 200, string $body = '', array $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
        $this->headers = $headers;
    }
    
    public function getStatusCode(): int { return $this->statusCode; }
    public function getBody(): string { return $this->body; }
    public function getHeaders(): array { return $this->headers; }
}

class AuthenticationMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        $authHeader = $request->getHeader('Authorization');
        
        if (!$authHeader || $authHeader !== 'Bearer valid-token') {
            return new Response(401, 'Unauthorized');
        }
        
        echo "Authentication passed\n";
        return $next($request);
    }
}

class LoggingMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        echo "Logging request: {$request->getMethod()} {$request->getUri()}\n";
        
        $response = $next($request);
        
        echo "Logging response: {$response->getStatusCode()}\n";
        return $response;
    }
}

class RateLimitMiddleware implements MiddlewareInterface
{
    private static $requests = [];
    private $maxRequests;
    
    public function __construct(int $maxRequests = 10)
    {
        $this->maxRequests = $maxRequests;
    }
    
    public function handle(Request $request, callable $next): Response
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $currentTime = time();
        
        if (!isset(self::$requests[$ip])) {
            self::$requests[$ip] = [];
        }
        
        // Remove old requests (older than 1 minute)
        self::$requests[$ip] = array_filter(self::$requests[$ip], function ($timestamp) use ($currentTime) {
            return $currentTime - $timestamp < 60;
        });
        
        if (count(self::$requests[$ip]) >= $this->maxRequests) {
            return new Response(429, 'Too Many Requests');
        }
        
        self::$requests[$ip][] = $currentTime;
        echo "Rate limit check passed\n";
        
        return $next($request);
    }
}

class MiddlewareStack
{
    private $middlewares = [];
    
    public function add(MiddlewareInterface $middleware): void
    {
        $this->middlewares[] = $middleware;
    }
    
    public function handle(Request $request, callable $finalHandler): Response
    {
        $stack = array_reverse($this->middlewares);
        
        $next = $finalHandler;
        foreach ($stack as $middleware) {
            $next = function ($request) use ($middleware, $next) {
                return $middleware->handle($request, $next);
            };
        }
        
        return $next($request);
    }
}

// Usage
$middlewareStack = new MiddlewareStack();
$middlewareStack->add(new LoggingMiddleware());
$middlewareStack->add(new RateLimitMiddleware(5));
$middlewareStack->add(new AuthenticationMiddleware());

$request = new Request('/api/users', 'GET', ['Authorization' => 'Bearer valid-token']);

$response = $middlewareStack->handle($request, function ($request) {
    echo "Handling request in controller\n";
    return new Response(200, 'User data');
});

echo "Final response status: {$response->getStatusCode()}\n";
```

## Conclusion

These design patterns provide proven solutions to common problems in PHP development. They promote code reusability, maintainability, and help create more robust applications. When implementing these patterns:

1. **Don't over-engineer** - Use patterns when they solve real problems
2. **Understand the context** - Each pattern has specific use cases
3. **Keep it simple** - Patterns should make code clearer, not more complex
4. **Consider modern PHP features** - Use type hints, interfaces, and other PHP 7+ features
5. **Test your implementations** - Patterns should make testing easier, not harder

Remember that patterns are tools to help you write better code, not rules that must always be followed. Choose the right pattern for your specific situation and requirements.