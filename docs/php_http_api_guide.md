# PHP HTTP Clients and API Development Guide
## For Python/FastAPI Developers

This guide shows PHP equivalents to popular Python libraries for HTTP requests and API development.

## HTTP Client Libraries (Python `requests` equivalent)

### 1. Guzzle HTTP - Most Popular
**Installation:**
```bash
composer require guzzlehttp/guzzle
```

**Basic Usage:**
```php
<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

$client = new Client();

// GET request (like requests.get())
try {
    $response = $client->request('GET', 'https://api.github.com/users/octocat');
    $statusCode = $response->getStatusCode();
    $body = $response->getBody()->getContents();
    $data = json_decode($body, true);
    
    echo "Status: $statusCode\n";
    print_r($data);
} catch (RequestException $e) {
    echo "Error: " . $e->getMessage();
}

// POST request with JSON (like requests.post())
$response = $client->post('https://api.example.com/users', [
    'json' => [
        'name' => 'John Doe',
        'email' => 'john@example.com'
    ],
    'headers' => [
        'Authorization' => 'Bearer your-token',
        'Accept' => 'application/json'
    ]
]);

// With query parameters
$response = $client->get('https://api.example.com/search', [
    'query' => [
        'q' => 'php',
        'limit' => 10
    ]
]);

// Form data
$response = $client->post('https://api.example.com/upload', [
    'form_params' => [
        'field1' => 'value1',
        'field2' => 'value2'
    ]
]);

// File upload
$response = $client->post('https://api.example.com/upload', [
    'multipart' => [
        [
            'name' => 'file',
            'contents' => fopen('/path/to/file.jpg', 'r'),
            'filename' => 'file.jpg'
        ]
    ]
]);
```

### 2. Symfony HttpClient
**Installation:**
```bash
composer require symfony/http-client
```

**Usage:**
```php
<?php
use Symfony\Component\HttpClient\HttpClient;

$client = HttpClient::create();

$response = $client->request('GET', 'https://api.github.com/users/octocat');
$statusCode = $response->getStatusCode();
$content = $response->getContent();
$data = $response->toArray(); // Auto JSON decode

// POST with options
$response = $client->request('POST', 'https://api.example.com/users', [
    'json' => [
        'name' => 'John Doe',
        'email' => 'john@example.com'
    ],
    'headers' => [
        'Authorization' => 'Bearer token'
    ]
]);
```

### 3. cURL Wrapper Libraries

**Curl/Curl:**
```bash
composer require php-curl-class/php-curl-class
```

```php
<?php
use Curl\Curl;

$curl = new Curl();
$curl->get('https://api.github.com/users/octocat');

if ($curl->error) {
    echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage;
} else {
    $data = $curl->response;
    print_r($data);
}

// POST request
$curl->post('https://api.example.com/users', [
    'name' => 'John Doe',
    'email' => 'john@example.com'
]);
```

## Web Frameworks (FastAPI equivalents)

### 1. Laravel - Full Framework
**Installation:**
```bash
composer create-project laravel/laravel my-api
```

**API Routes Example:**
```php
<?php
// routes/api.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// GET /api/users
Route::get('/users', function () {
    return response()->json(['users' => User::all()]);
});

// POST /api/users
Route::post('/users', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users'
    ]);
    
    $user = User::create($validated);
    
    return response()->json($user, 201);
});

// GET /api/users/{id}
Route::get('/users/{id}', function ($id) {
    $user = User::findOrFail($id);
    return response()->json($user);
});

// PUT /api/users/{id}
Route::put('/users/{id}', function (Request $request, $id) {
    $user = User::findOrFail($id);
    $user->update($request->validated());
    
    return response()->json($user);
});

// DELETE /api/users/{id}
Route::delete('/users/{id}', function ($id) {
    User::findOrFail($id)->delete();
    return response()->json(null, 204);
});
```

**Controller Example:**
```php
<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::paginate(10));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);
        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password'])
        ]);
        
        return response()->json($user, 201);
    }
    
    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->validated());
        
        return response()->json($user);
    }
    
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
```

### 2. Slim Framework - Lightweight (closer to FastAPI)
**Installation:**
```bash
composer require slim/slim slim/psr7
```

**Basic API:**
```php
<?php
require 'vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

// Middleware for JSON responses
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// GET /users
$app->get('/users', function (Request $request, Response $response) {
    $users = [
        ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
        ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com']
    ];
    
    $response->getBody()->write(json_encode($users));
    return $response->withHeader('Content-Type', 'application/json');
});

// POST /users
$app->post('/users', function (Request $request, Response $response) {
    $data = json_decode($request->getBody()->getContents(), true);
    
    // Validation
    if (!isset($data['name']) || !isset($data['email'])) {
        $error = ['error' => 'Name and email are required'];
        $response->getBody()->write(json_encode($error));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }
    
    // Create user (mock)
    $user = [
        'id' => rand(1000, 9999),
        'name' => $data['name'],
        'email' => $data['email'],
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    $response->getBody()->write(json_encode($user));
    return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
});

// GET /users/{id}
$app->get('/users/{id}', function (Request $request, Response $response, $args) {
    $id = $args['id'];
    
    // Mock user lookup
    $user = ['id' => $id, 'name' => 'John Doe', 'email' => 'john@example.com'];
    
    $response->getBody()->write(json_encode($user));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
```

### 3. Lumen - Laravel's Microframework
**Installation:**
```bash
composer create-project --prefer-dist laravel/lumen my-api
```

**Routes:**
```php
<?php
// routes/web.php
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('users', 'UserController@index');
    $router->post('users', 'UserController@store');
    $router->get('users/{id}', 'UserController@show');
    $router->put('users/{id}', 'UserController@update');
    $router->delete('users/{id}', 'UserController@destroy');
});
```

## API Development Packages

### 1. API Resources & Transformers

**Laravel API Resources:**
```php
<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at->toDateTimeString(),
            'profile' => new ProfileResource($this->whenLoaded('profile')),
        ];
    }
}

// Usage in controller
public function show($id)
{
    $user = User::with('profile')->findOrFail($id);
    return new UserResource($user);
}
```

**Fractal Transformer:**
```bash
composer require league/fractal
```

```php
<?php
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at->toISOString(),
        ];
    }
}

// Usage
$fractal = new Manager();
$resource = new Item($user, new UserTransformer());
$data = $fractal->createData($resource)->toArray();
```

### 2. Validation

**Laravel Validation:**
```php
<?php
use Illuminate\Support\Facades\Validator;

$validator = Validator::make($request->all(), [
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'age' => 'required|integer|min:18|max:120',
    'tags' => 'array',
    'tags.*' => 'string|max:50'
]);

if ($validator->fails()) {
    return response()->json(['errors' => $validator->errors()], 422);
}
```

**Respect Validation:**
```bash
composer require respect/validation
```

```php
<?php
use Respect\Validation\Validator as v;

$validator = v::key('name', v::stringType()->notEmpty())
             ->key('email', v::email())
             ->key('age', v::intType()->min(18));

try {
    $validator->assert($data);
} catch (Exception $e) {
    return response()->json(['error' => $e->getMessage()], 400);
}
```

### 3. Authentication & JWT

**Laravel Passport (OAuth2):**
```bash
composer require laravel/passport
php artisan passport:install
```

**JWT Authentication:**
```bash
composer require tymon/jwt-auth
```

```php
<?php
// Login endpoint
public function login(Request $request)
{
    $credentials = $request->only('email', 'password');
    
    if (!$token = auth()->attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60
    ]);
}

// Protected route
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
```

### 4. API Documentation

**L5-Swagger (OpenAPI/Swagger):**
```bash
composer require darkaonline/l5-swagger
```

```php
<?php
/**
 * @OA\Post(
 *     path="/api/users",
 *     summary="Create a new user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","email"},
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="User created successfully",
 *         @OA\JsonContent(ref="#/components/schemas/User")
 *     )
 * )
 */
public function store(Request $request)
{
    // Implementation
}
```

## HTTP Client Wrapper Class (FastAPI-style)

```php
<?php
class ApiClient
{
    private $client;
    private $baseUrl;
    private $defaultHeaders;
    
    public function __construct(string $baseUrl, array $defaultHeaders = [])
    {
        $this->client = new \GuzzleHttp\Client();
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->defaultHeaders = array_merge([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ], $defaultHeaders);
    }
    
    public function get(string $endpoint, array $params = []): array
    {
        $response = $this->client->get($this->baseUrl . $endpoint, [
            'headers' => $this->defaultHeaders,
            'query' => $params
        ]);
        
        return json_decode($response->getBody()->getContents(), true);
    }
    
    public function post(string $endpoint, array $data = []): array
    {
        $response = $this->client->post($this->baseUrl . $endpoint, [
            'headers' => $this->defaultHeaders,
            'json' => $data
        ]);
        
        return json_decode($response->getBody()->getContents(), true);
    }
    
    public function put(string $endpoint, array $data = []): array
    {
        $response = $this->client->put($this->baseUrl . $endpoint, [
            'headers' => $this->defaultHeaders,
            'json' => $data
        ]);
        
        return json_decode($response->getBody()->getContents(), true);
    }
    
    public function delete(string $endpoint): bool
    {
        $response = $this->client->delete($this->baseUrl . $endpoint, [
            'headers' => $this->defaultHeaders
        ]);
        
        return $response->getStatusCode() === 204;
    }
    
    public function setAuth(string $token): self
    {
        $this->defaultHeaders['Authorization'] = 'Bearer ' . $token;
        return $this;
    }
}

// Usage (similar to Python requests)
$api = new ApiClient('https://api.example.com');
$api->setAuth('your-token');

$users = $api->get('/users', ['limit' => 10]);
$newUser = $api->post('/users', ['name' => 'John', 'email' => 'john@example.com']);
$updatedUser = $api->put('/users/1', ['name' => 'John Doe']);
$deleted = $api->delete('/users/1');
```

## Package Manager (Composer vs pip)

**composer.json** (equivalent to requirements.txt):
```json
{
    "require": {
        "guzzlehttp/guzzle": "^7.0",
        "laravel/framework": "^10.0",
        "tymon/jwt-auth": "^2.0"
    },
    "require-dev": {
        "phpunit/phpunit": "^10.0",
        "mockery/mockery": "^1.5"
    }
}
```

**Commands:**
```bash
# Install packages
composer install

# Add new package
composer require guzzlehttp/guzzle

# Add dev dependency
composer require --dev phpunit/phpunit

# Update packages
composer update

# Auto-generate autoloader
composer dump-autoload
```

## Summary: Python/FastAPI vs PHP

| Python/FastAPI | PHP Equivalent |
|----------------|----------------|
| `requests` | Guzzle HTTP |
| `httpx` | Symfony HttpClient |
| `FastAPI` | Slim Framework |
| `Django REST` | Laravel API |
| `pydantic` | Laravel Validation |
| `pip` | Composer |
| `requirements.txt` | composer.json |
| `uvicorn` | PHP built-in server / Nginx |

The PHP ecosystem offers robust alternatives to Python's HTTP and API tools, with Guzzle being the most popular HTTP client and Laravel/Slim providing excellent API development frameworks.