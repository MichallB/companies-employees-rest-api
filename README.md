
# Companies and employees REST API

## Overview
This project is a REST API built with Symfony, designed to manage companies and their employees. The API allows CRUD operations on companies and employees, providing a robust backend service for any application in need of such functionality. 

## Requirements 
- PHP 8.2 or higher 
- Composer 
- Symfony CLI (optional but recommended)
- Database (e.g., SQLite, MySQL, PostgreSQL)



## Installation

1. Clone the repository:
``` 
git clone https://github.com/MichallB/companies-employees-rest-api.git
cd companies-employees-rest-api
```

2. Install dependencies:
``` 
composer install
```

3. Set up the environment file:

By default, the local SQLite database is used. If you want to use a different database: 
- Copy the `.env` file to `.env.local`:
```
cp .env .env.local
```
- Edit the `.env.local` file to set your credentials:
```
# EXAMPLE
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
```

4. Create the database:
```
php bin/console doctrine:database:create
```

5. Run migrations (if any):
```
php bin/console doctrine:migrations:migrate
```

6. Start the server:
```
symfony server:start
```

## Routes Overview

### Companies
| Method | Endpoint                            | Description                                                    |
| ------ | ----------------------------------- | -------------------------------------------------------------- |
| GET    | /api/companies                      | Retrieves a list of companies                                  |
| GET    | /api/companies/{id}                 | Retrieves a specific company by ID                             |
| POST   | /api/companies                      | Creates a new company                                          |
| PUT    | /api/companies/{id}                 | Updates a specific company by ID                               |
| DELETE | /api/companies/{id}                 | Deletes a specific company by ID                               |
| GET    | /api/companies/{id}/employees       | Retrieves a list of employees specific company by ID           |
| GET    | /api/companies/{id}/employees/{eid} | Retrieves a specific employee by EID of specific company by ID |
| PUT    | /api/companies/{id}/employees/{eid} | Add a specific employee by EID to specific company by ID       |
| DELETE | /api/companies/{id}/employees/{eid} | Remove a specific employee by EID from specific company by ID  |

### Employees
| Method | Endpoint            | Description                         |
| ------ | ------------------- | ----------------------------------- |
| GET    | /api/employees      | Retrieves a list of employees       |
| GET    | /api/employees/{id} | Retrieves a specific employee by ID |
| POST   | /api/employees      | Creates a new employee              |
| PUT    | /api/employees/{id} | Updates a specific employee by ID   |
| DELETE | /api/employees/{id} | Deletes a specific employee by ID   |

## TODO

- [ ] Add more user input validation
- [ ] Add tests
