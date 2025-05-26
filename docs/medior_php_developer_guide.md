# Medior PHP Developer Knowledge Guide

## Table of Contents

- [What is a Medior PHP Developer?](#what-is-a-medior-php-developer)
- [Core PHP Knowledge](#core-php-knowledge)
- [Object-Oriented Programming](#object-oriented-programming)
- [Modern PHP Features](#modern-php-features)
- [Database Skills](#database-skills)
- [Framework Expertise](#framework-expertise)
- [Testing](#testing)
- [Security](#security)
- [Performance](#performance)
- [DevOps & Deployment](#devops--deployment)
- [Code Quality & Best Practices](#code-quality--best-practices)
- [Architecture & Design Patterns](#architecture--design-patterns)
- [API Development](#api-development)
- [Frontend Integration](#frontend-integration)
- [Tools & Ecosystem](#tools--ecosystem)
- [Debugging & Troubleshooting](#debugging--troubleshooting)
- [Soft Skills](#soft-skills)
- [Knowledge Assessment](#knowledge-assessment)
- [Career Progression](#career-progression)

## What is a Medior PHP Developer?

A medior PHP developer is typically someone with **2-5 years of experience** who has progressed beyond junior level but hasn't yet reached senior status. They should be able to work independently on most tasks, contribute to architectural decisions, and mentor junior developers.

### Key Characteristics:
- **Independent problem solver** - Can tackle complex features without constant guidance
- **Code reviewer** - Able to review others' code and provide constructive feedback
- **Technical contributor** - Participates in technical discussions and architecture decisions
- **Mentor** - Can guide junior developers and explain complex concepts
- **Product-minded** - Understands business requirements and translates them to technical solutions

## Core PHP Knowledge

### Language Fundamentals
- **Variables, constants, and data types**
- **Control structures** (if/else, loops, switch/match)
- **Functions** (parameters, return types, variable scope)
- **Arrays** (indexed, associative, multidimensional)
- **String manipulation** and regular expressions
- **File handling** and streams
- **Error handling** (exceptions, error reporting)
- **Include/require** and autoloading

### Advanced PHP Concepts
- **Namespaces** and PSR-4 autoloading
- **Traits** and when to use them
- **Magic methods** (`__construct`, `__toString`, `__call`, etc.)
- **Reflection** for meta-programming
- **Generators** for memory-efficient iteration
- **Closures** and anonymous functions
- **Variable functions** and callbacks

### PHP Configuration
- **php.ini** settings and their impact
- **Memory management** and garbage collection
- **Opcache** configuration and benefits
- **Extension management** (enabling/disabling modules)
- **Environment-specific** configurations

## Object-Oriented Programming

### Core OOP Concepts
- **Classes and objects** with proper encapsulation
- **Inheritance** and polymorphism
- **Abstract classes** vs interfaces
- **Visibility modifiers** (public, private, protected)
- **Static methods** and properties
- **Constructor and destructor**

### Advanced OOP
- **Dependency injection** patterns
- **Composition over inheritance**
- **Interface segregation**
- **Liskov substitution principle**
- **Open/closed principle**
- **Single responsibility principle**

### Design Patterns (Essential)
- **Singleton** (and why to avoid it)
- **Factory** and Abstract Factory
- **Strategy** pattern
- **Observer** pattern
- **Repository** pattern
- **Dependency Injection Container**
- **Command** pattern

## Modern PHP Features

### PHP 8.0+ Features
- **Union types** and proper usage
- **Named arguments** best practices
- **Match expressions** vs switch
- **Nullsafe operator** (`?->`)
- **Constructor property promotion**
- **Attributes** (annotations)
- **JIT compilation** understanding

### PHP 8.1+ Features
- **Enums** and their use cases
- **Readonly properties**
- **First-class callable syntax**
- **Intersection types**
- **Array unpacking** with string keys

### PHP 8.2+ Features
- **Readonly classes**
- **Disjunctive Normal Form (DNF) types**
- **Constants in traits**
- **Sensitive parameter redaction**

### When NOT to Use New Features
- **Backward compatibility** considerations
- **Team knowledge** and learning curve
- **Library support** and ecosystem readiness
- **Performance implications**

## Database Skills

### SQL Proficiency
- **Complex queries** with JOINs, subqueries
- **Indexing strategies** and query optimization
- **Transactions** and ACID principles
- **Stored procedures** and functions (basic)
- **Database design** and normalization
- **Migration strategies**

### PHP Database Integration
- **PDO** with prepared statements
- **Query builders** (Doctrine DBAL, etc.)
- **ORM usage** (Doctrine, Eloquent)
- **Connection pooling** and management
- **Database abstraction** patterns

### Database Technologies
- **MySQL/MariaDB** optimization
- **PostgreSQL** features and differences
- **Redis** for caching and sessions
- **MongoDB** basics (if applicable)
- **Database migrations** and versioning

## Framework Expertise

### At Least One Major Framework
**Laravel:**
- **Eloquent ORM** and relationships
- **Routing** and middleware
- **Artisan commands**
- **Service container** and providers
- **Blade templating**
- **Queue systems**
- **Event/listener patterns**

**Symfony:**
- **Dependency injection container**
- **Console commands**
- **Twig templating**
- **Doctrine integration**
- **Event dispatcher**
- **Form handling**
- **Security component**

### Framework-Agnostic Skills
- **MVC architecture** understanding
- **Routing concepts**
- **Middleware patterns**
- **Template engines**
- **Configuration management**
- **Service layer patterns**

## Testing

### Testing Types
- **Unit testing** with PHPUnit
- **Integration testing**
- **Feature/functional testing**
- **API testing**
- **Database testing** with fixtures

### Testing Best Practices
- **Test-driven development** (TDD) basics
- **Test structure** (Arrange, Act, Assert)
- **Mocking and stubbing**
- **Test doubles** and when to use them
- **Code coverage** understanding (not obsession)
- **Testing pyramid** concept

### Testing Tools
- **PHPUnit** advanced features
- **Mockery** for mocking
- **Pest** as alternative testing framework
- **Codeception** for acceptance testing
- **Continuous integration** test runs

## Security

### Common Vulnerabilities
- **SQL injection** prevention
- **XSS attacks** and mitigation
- **CSRF protection**
- **Authentication** vs authorization
- **Password hashing** (bcrypt, Argon2)
- **Session management**
- **File upload security**

### Security Best Practices
- **Input validation** and sanitization
- **Output encoding**
- **Secure headers** (CSP, HSTS, etc.)
- **Environment variables** for secrets
- **HTTPS enforcement**
- **Rate limiting**
- **Security auditing** basics

### Security Tools
- **Composer audit** for dependencies
- **Security scanners** (Psalm, PHPStan security rules)
- **Dependency vulnerability** checking
- **Code analysis** for security issues

## Performance

### Performance Optimization
- **Profiling** with Xdebug or Blackfire
- **Database query optimization**
- **Caching strategies** (Redis, Memcached)
- **HTTP caching** headers
- **Asset optimization**
- **Memory usage** optimization

### Caching
- **Application-level caching**
- **Database query caching**
- **Object caching**
- **HTTP response caching**
- **CDN integration**
- **Cache invalidation** strategies

### Monitoring
- **APM tools** (New Relic, Datadog)
- **Error tracking** (Sentry, Bugsnag)
- **Performance monitoring**
- **Log analysis**
- **Metrics collection**

## DevOps & Deployment

### Version Control
- **Git workflows** (GitFlow, GitHub Flow)
- **Branching strategies**
- **Code review** process
- **Merge vs rebase**
- **Conflict resolution**
- **Git hooks** usage

### Deployment
- **CI/CD pipelines** understanding
- **Docker** containerization basics
- **Environment management** (dev, staging, prod)
- **Blue-green deployments**
- **Database migrations** in production
- **Rollback strategies**

### Server Management
- **Web server configuration** (Nginx, Apache)
- **PHP-FPM** configuration
- **SSL/TLS** certificate management
- **Server monitoring** basics
- **Log management**
- **Backup strategies**

### Cloud Platforms
- **AWS basics** (EC2, S3, RDS)
- **Container orchestration** (basic Kubernetes)
- **Serverless** concepts (Lambda functions)
- **Cloud storage** integration
- **Cloud databases**

## Code Quality & Best Practices

### Code Standards
- **PSR standards** (PSR-1, PSR-2, PSR-4, PSR-12)
- **Code formatting** and consistency
- **Naming conventions**
- **Documentation** and comments
- **Type declarations** usage

### Static Analysis
- **PHPStan** for type checking
- **Psalm** for bug detection
- **PHP_CodeSniffer** for standards
- **PHP-CS-Fixer** for formatting
- **Integration** with IDEs and CI/CD

### Refactoring
- **Code smell** identification
- **Refactoring techniques**
- **Legacy code** improvement
- **Technical debt** management
- **Safe refactoring** practices

## Architecture & Design Patterns

### Architectural Patterns
- **MVC** and variations (MVP, MVVM)
- **Layered architecture**
- **Hexagonal architecture** basics
- **Domain-driven design** concepts
- **CQRS** understanding
- **Event sourcing** basics

### Enterprise Patterns
- **Service layer** pattern
- **Repository** and Unit of Work
- **Domain model** patterns
- **Data mapper** vs Active Record
- **Specification** pattern
- **Factory** patterns

### System Design
- **API design** principles
- **Database design** patterns
- **Caching** architectures
- **Queue systems** design
- **Microservices** basics
- **Event-driven** architectures

## API Development

### RESTful APIs
- **REST principles** and constraints
- **HTTP methods** proper usage
- **Status codes** and their meaning
- **Resource naming** conventions
- **Versioning strategies**
- **HATEOAS** concepts

### API Standards
- **OpenAPI/Swagger** documentation
- **JSON:API** specification
- **GraphQL** basics
- **Rate limiting** implementation
- **Authentication** (JWT, OAuth)
- **CORS** handling

### API Testing
- **Postman** for manual testing
- **Automated API testing**
- **Contract testing**
- **Load testing** basics
- **API monitoring**

## Frontend Integration

### Frontend Technologies
- **JavaScript** fundamentals
- **AJAX** and fetch API
- **JSON** handling
- **DOM manipulation** basics
- **Modern JS frameworks** awareness (React, Vue)

### Asset Management
- **Webpack** or Vite basics
- **CSS preprocessing** (Sass, Less)
- **JavaScript transpilation**
- **Asset optimization**
- **CDN integration**

### Template Engines
- **Twig** advanced features
- **Blade** components and directives
- **Template inheritance**
- **Partial rendering**
- **Frontend-backend** separation

## Tools & Ecosystem

### Development Tools
- **IDE proficiency** (PhpStorm, VS Code)
- **Debugging tools** (Xdebug)
- **Code analysis** tools
- **Database tools** (MySQL Workbench, phpMyAdmin)
- **API testing** tools

### Package Management
- **Composer** advanced usage
- **Private repositories**
- **Package versioning**
- **Dependency resolution**
- **Security advisories**

### Monitoring & Logging
- **Structured logging**
- **Log aggregation** (ELK stack)
- **Error tracking** systems
- **Performance monitoring**
- **Alerting systems**

## Debugging & Troubleshooting

### Debugging Skills
- **Systematic debugging** approach
- **Log analysis**
- **Stack trace** interpretation
- **Memory leak** detection
- **Performance bottleneck** identification

### Tools & Techniques
- **Xdebug** step debugging
- **Profiling** and analysis
- **Query optimization**
- **Error reproduction**
- **Production debugging** safely

### Problem-Solving Process
1. **Issue identification** and scope
2. **Information gathering**
3. **Hypothesis formation**
4. **Testing** and validation
5. **Solution implementation**
6. **Prevention** strategies

## Soft Skills

### Communication
- **Technical writing** for documentation
- **Code review** feedback
- **Explaining complex** concepts simply
- **Cross-team collaboration**
- **Client communication** basics

### Project Management
- **Agile methodologies** (Scrum, Kanban)
- **Task estimation**
- **Sprint planning** participation
- **Retrospective** contribution
- **Requirements analysis**

### Leadership
- **Junior developer** mentoring
- **Code review** leadership
- **Technical decision** participation
- **Knowledge sharing**
- **Process improvement** suggestions

## Knowledge Assessment

### Self-Assessment Questions

**Core PHP:**
- Can you explain the difference between `include` and `require`?
- How does PHP's garbage collection work?
- What are the benefits and drawbacks of using traits?

**OOP & Design Patterns:**
- When would you use an abstract class vs an interface?
- How do you implement dependency injection without a container?
- Can you explain the Repository pattern and its benefits?

**Modern PHP:**
- When should you use union types vs mixed?
- How do readonly properties affect object design?
- What are the performance implications of using match vs switch?

**Database:**
- How do you optimize a slow query?
- What's the difference between INNER JOIN and LEFT JOIN?
- How do you handle database migrations in a team environment?

**Framework:**
- How does your framework handle dependency injection?
- Can you explain the request lifecycle in your framework?
- How do you implement custom middleware?

**Testing:**
- What's the difference between a mock and a stub?
- How do you test database interactions?
- When is it okay to skip writing tests?

**Security:**
- How do you prevent SQL injection in prepared statements?
- What headers should you set for XSS protection?
- How do you securely store API keys?

**Performance:**
- How do you identify performance bottlenecks?
- What caching strategies have you implemented?
- How do you optimize memory usage in PHP?

### Practical Exercises

1. **Build a REST API** with authentication and rate limiting
2. **Refactor legacy code** using modern patterns
3. **Implement a caching layer** for a slow operation
4. **Write comprehensive tests** for a complex feature
5. **Optimize a slow database query**
6. **Design a simple microservice**
7. **Implement real-time features** using WebSockets or SSE

## Career Progression

### From Junior to Medior
- **Technical competency** in daily tasks
- **Independent problem solving**
- **Code review** participation
- **Junior developer** mentoring
- **Architecture discussion** participation

### From Medior to Senior
- **System design** leadership
- **Technical decision** making
- **Cross-team collaboration**
- **Process improvement** driving
- **Business impact** understanding

### Continuous Learning
- **Stay updated** with PHP releases
- **Follow PHP community** (PHP-FIG, internals)
- **Contribute to open source**
- **Attend conferences** and meetups
- **Read technical blogs** and books
- **Practice new technologies**

### Career Paths
- **Technical Lead** - Focus on architecture and technical decisions
- **Team Lead** - Combine technical skills with people management
- **Architect** - System design and technology strategy
- **DevOps Engineer** - Infrastructure and deployment expertise
- **Product Engineer** - Business-focused technical development

## Recommended Learning Resources

### Books
- "Clean Code" by Robert C. Martin
- "Refactoring" by Martin Fowler
- "Domain-Driven Design" by Eric Evans
- "Building Microservices" by Sam Newman

### PHP-Specific Resources
- PHP Manual and RFCs
- PHPUnit documentation
- Framework documentation (Laravel, Symfony)
- PHP The Right Way

### Practice Platforms
- LeetCode for algorithms
- HackerRank for PHP challenges
- GitHub for open source contribution
- Personal projects for experimentation

---

**Remember:** Being a medior developer is not just about technical knowledge—it's about applying that knowledge effectively, communicating well with your team, and continuously learning. The goal is to be a reliable, productive team member who can handle complex tasks independently while supporting others in their growth.