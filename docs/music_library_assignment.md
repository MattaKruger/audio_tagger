# Music Library Management System - PHP Assignment

## Overview

Build a comprehensive Music Library Management System that allows users to manage their music collection, create playlists, and discover new music. This assignment is designed to test junior to medior level PHP development skills.

## Project Requirements

### Phase 1: Core System (Junior Level)

#### Database Design
Create a MySQL database with the following entities:

**Artists Table:**
- id (Primary Key)
- name (Required)
- bio (Text)
- formed_year
- country
- genre_id (Foreign Key)
- created_at
- updated_at

**Albums Table:**
- id (Primary Key)
- title (Required)
- artist_id (Foreign Key)
- release_date
- total_tracks
- duration_minutes
- cover_image_url
- created_at
- updated_at

**Tracks Table:**
- id (Primary Key)
- title (Required)
- album_id (Foreign Key)
- track_number
- duration_seconds
- file_path
- file_size_mb
- created_at
- updated_at

**Genres Table:**
- id (Primary Key)
- name (Required, Unique)
- description
- created_at
- updated_at

**Users Table:**
- id (Primary Key)
- username (Required, Unique)
- email (Required, Unique)
- password_hash (Required)
- first_name
- last_name
- created_at
- updated_at

#### Core Functionality
1. **CRUD Operations** for all entities
2. **User Registration** and Login system
3. **Music Library** browsing (artists, albums, tracks)
4. **Search Functionality** (by artist, album, track name)
5. **Basic File Upload** for track files and album covers

#### Technical Requirements
- Use **PDO** with prepared statements
- Implement **password hashing** (bcrypt)
- Create a **simple routing system** or use a micro-framework
- **Input validation** and **sanitization**
- **Error handling** with try-catch blocks
- **Database migrations** (at least 3 migration files)

### Phase 2: Enhanced Features (Junior+ Level)

#### Playlist System
**Playlists Table:**
- id (Primary Key)
- name (Required)
- user_id (Foreign Key)
- description
- is_public (Boolean)
- created_at
- updated_at

**Playlist_Tracks Table:**
- id (Primary Key)
- playlist_id (Foreign Key)
- track_id (Foreign Key)
- position
- added_at

#### Advanced Features
1. **Playlist Management** (create, edit, delete, add/remove tracks)
2. **User Profile** management
3. **Music Statistics** (most played tracks, favorite genres)
4. **Advanced Search** with filters (genre, year, duration)
5. **Pagination** for large result sets
6. **Image Upload** with validation and resizing

#### Technical Requirements
- Implement **Repository Pattern**
- Use **Dependency Injection**
- Add **basic caching** (file-based or Redis)
- Implement **rate limiting** for API endpoints
- Add **logging system** (file-based logs)
- Create **database seeders** with sample data

### Phase 3: Professional Features (Medior Level)

#### Enhanced Database Design
**User_Favorites Table:**
- user_id (Foreign Key)
- favoritable_id (Polymorphic)
- favoritable_type (artist/album/track)
- created_at

**Play_History Table:**
- id (Primary Key)
- user_id (Foreign Key)
- track_id (Foreign Key)
- played_at
- play_duration_seconds
- device_type

**Album_Reviews Table:**
- id (Primary Key)
- user_id (Foreign Key)
- album_id (Foreign Key)
- rating (1-5)
- review_text
- created_at
- updated_at

#### Advanced Functionality
1. **RESTful API** with proper HTTP methods and status codes
2. **JWT Authentication** for API
3. **Real-time Features** (WebSocket for now playing)
4. **Music Recommendations** (based on listening history)
5. **Social Features** (follow users, share playlists)
6. **Audio Streaming** (basic file serving with range requests)
7. **Advanced Statistics** dashboard

#### Technical Requirements
- Implement **Service Layer Pattern**
- Use **Events and Listeners**
- Add **Queue System** for heavy operations
- Implement **Full-Text Search** (MySQL or Elasticsearch)
- Add **API Documentation** (OpenAPI/Swagger)
- Implement **Command Line Tools** (CLI commands)
- Add **Docker** containerization
- Create **automated tests** (Unit and Integration)

### Phase 4: Expert Features (Senior Level)

#### Microservices Architecture
1. **User Service** (authentication, profiles)
2. **Music Catalog Service** (artists, albums, tracks)
3. **Playlist Service** (playlist management)
4. **Recommendation Service** (ML-based recommendations)
5. **Streaming Service** (audio file serving)

#### Advanced Features
1. **OAuth Integration** (Spotify, Apple Music)
2. **Music Metadata Extraction** (ID3 tags)
3. **Audio Transcoding** (different quality levels)
4. **CDN Integration** for file serving
5. **Real-time Analytics** dashboard
6. **A/B Testing** framework
7. **Multi-tenant** support

## Technical Specifications

### Required Technologies
- **PHP 8.1+** with modern features
- **MySQL 8.0+** or **PostgreSQL**
- **Redis** for caching and sessions
- **Composer** for dependency management
- **PSR-4** autoloading
- **Docker** for development environment

### Recommended Packages
```json
{
    "require": {
        "vlucas/phpdotenv": "^5.0",
        "monolog/monolog": "^3.0",
        "guzzlehttp/guzzle": "^7.0",
        "ramsey/uuid": "^4.0",
        "league/flysystem": "^3.0",
        "intervention/image": "^2.7",
        "firebase/php-jwt": "^6.0"
    },
    "require-dev": {
        "phpunit/phpunit": "^10.0",
        "vimeo/psalm": "^5.0",
        "phpstan/phpstan": "^1.0",
        "squizlabs/php_codesniffer": "^3.7"
    }
}
```

### Code Quality Requirements
- **PSR-12** coding standards
- **Type declarations** for all methods
- **PHPStan level 6+** compliance
- **80%+ test coverage**
- **Documented APIs** with proper docblocks
- **Git workflow** with meaningful commits

## Project Structure

```
music-library/
├── public/
│   ├── index.php
│   ├── assets/
│   └── uploads/
├── src/
│   ├── Controllers/
│   ├── Models/
│   ├── Services/
│   ├── Repositories/
│   ├── Middleware/
│   ├── Events/
│   ├── Listeners/
│   └── Commands/
├── config/
│   ├── database.php
│   ├── cache.php
│   └── app.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── tests/
│   ├── Unit/
│   ├── Integration/
│   └── Feature/
├── storage/
│   ├── logs/
│   ├── cache/
│   └── uploads/
├── docker/
├── docs/
├── .env.example
├── composer.json
├── phpunit.xml
├── psalm.xml
└── README.md
```

## Assessment Criteria

### Code Quality (25%)
- Clean, readable code with proper naming
- Consistent code style (PSR-12)
- Proper error handling
- Security best practices
- Performance considerations

### Architecture (25%)
- Proper separation of concerns
- Design pattern implementation
- Database design quality
- API design principles
- Scalability considerations

### Functionality (25%)
- All required features implemented
- User experience quality
- Edge case handling
- Data validation
- Search and filtering accuracy

### Technical Implementation (25%)
- Modern PHP feature usage
- Testing coverage and quality
- Documentation completeness
- Git commit quality
- Deployment readiness

## Deliverables

### Phase 1 Deliverables
1. **Database schema** with migrations
2. **Core CRUD operations** working
3. **User authentication** system
4. **Basic search** functionality
5. **Simple web interface**
6. **Git repository** with commit history

### Phase 2 Deliverables
1. **Playlist system** fully functional
2. **Repository pattern** implemented
3. **Caching layer** working
4. **File upload** system secure
5. **Pagination** implemented
6. **Basic tests** written

### Phase 3 Deliverables
1. **RESTful API** documented
2. **JWT authentication** working
3. **Queue system** operational
4. **Full test suite** (Unit + Integration)
5. **Docker setup** complete
6. **Performance optimized**

### Phase 4 Deliverables
1. **Microservices** architecture
2. **Production deployment** ready
3. **Monitoring** and logging
4. **Load testing** completed
5. **Documentation** comprehensive
6. **CI/CD pipeline** configured

## Bonus Challenges

### For Music Enthusiasts
1. **Last.fm Integration** - Scrobble plays to Last.fm
2. **Spotify Web API** - Import playlists from Spotify
3. **Music Visualization** - Audio waveform generation
4. **Lyrics Integration** - Fetch and display song lyrics
5. **Smart Playlists** - Auto-updating playlists based on criteria

### For Performance Optimizers
1. **Audio Streaming** with HTTP range requests
2. **CDN Integration** for global file delivery
3. **Database Sharding** for massive music libraries
4. **Full-text Search** with Elasticsearch
5. **Real-time Analytics** with WebSockets

### For API Architects
1. **GraphQL API** alternative to REST
2. **API Versioning** strategy
3. **Rate Limiting** with different tiers
4. **Webhook System** for third-party integrations
5. **OpenAPI 3.0** specification complete

## Evaluation Timeline

- **Phase 1**: 1-2 weeks (Basic functionality)
- **Phase 2**: 2-3 weeks (Enhanced features)
- **Phase 3**: 3-4 weeks (Professional features)
- **Phase 4**: 4-6 weeks (Expert features)

## Sample Data

### Artists
- The Beatles (Rock, 1960, UK)
- Miles Davis (Jazz, 1944, USA)
- Radiohead (Alternative Rock, 1985, UK)
- Daft Punk (Electronic, 1993, France)
- Kendrick Lamar (Hip Hop, 2003, USA)

### Albums
- Abbey Road (The Beatles, 1969)
- Kind of Blue (Miles Davis, 1959)
- OK Computer (Radiohead, 1997)
- Random Access Memories (Daft Punk, 2013)
- To Pimp a Butterfly (Kendrick Lamar, 2015)

### Sample Tracks
Each album should have 8-12 tracks with realistic durations and metadata.

## Getting Started

1. **Fork** this assignment repository
2. **Set up** development environment with Docker
3. **Create** database and run migrations
4. **Implement** Phase 1 features first
5. **Write tests** as you develop
6. **Document** your progress and decisions
7. **Deploy** to a staging environment
8. **Submit** with comprehensive README

## Success Metrics

- **Clean Git History** with meaningful commits
- **Working Application** deployed and accessible
- **Comprehensive Tests** with good coverage
- **Quality Documentation** for setup and usage
- **Security Considerations** properly implemented
- **Performance Optimization** evidence
- **Modern PHP Features** appropriately used

Good luck building your Music Library Management System! Remember to focus on code quality, proper architecture, and user experience. This project will showcase your PHP development skills and passion for music.