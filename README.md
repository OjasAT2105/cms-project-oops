# CMS Project - Object-Oriented Version

This is an object-oriented version of the CMS (Content Management System) project, designed to be simple and educational for students learning PHP OOP concepts.

## Project Structure

```
cms-project-oops/
├── classes/                 # All PHP classes
│   ├── Database.php        # Database connection and operations
│   ├── Session.php         # Session management
│   ├── User.php            # User authentication and management
│   ├── Subject.php         # Subject (category) management
│   ├── Page.php            # Page management
│   ├── Navigation.php      # Navigation menu generation
│   ├── FormValidator.php   # Form validation utilities
│   └── Autoload.php        # Class autoloader
├── includes/               # Configuration and layout files
│   ├── constants.php       # Database configuration
│   ├── header.php          # HTML header template
│   └── footer.php          # HTML footer template
├── stylesheets/            # CSS styling
│   └── public.css          # Main stylesheet
├── init.php                # Application initialization
├── index.php               # Public homepage
├── login.php               # User login
├── staff.php               # Admin dashboard
├── logout.php              # User logout
├── content.php             # Content management
├── new_user.php            # Create new user
├── new_subject.php         # Create new subject form
├── create_subject.php      # Process subject creation
├── edit_subject.php        # Edit subject
├── delete_subject.php      # Delete subject
├── new_page.php            # Create new page
├── edit_page.php           # Edit page
├── delete_page.php         # Delete page
├── page_form.php           # Shared page form
└── README.md               # This file
```

## Database Structure

The project uses the same database as the original CMS (`widget_corp`):

### Tables:
- **users**: id, username, hashed_password
- **subjects**: id, menu_name, position, visible
- **pages**: id, subject_id, menu_name, position, visible, content

## OOP Classes Explained

### 1. Database Class
- **Purpose**: Handles all database operations
- **Key Methods**:
  - `__construct()`: Creates database connection
  - `query($sql)`: Executes SQL queries
  - `escape_value($value)`: Prevents SQL injection
  - `fetch_array($result)`: Gets result rows
  - `num_rows($result)`: Counts result rows

### 2. Session Class
- **Purpose**: Manages user sessions and authentication
- **Key Methods**:
  - `__construct()`: Starts session and checks login status
  - `login($user)`: Logs in a user
  - `logout()`: Logs out a user
  - `is_logged_in()`: Checks if user is logged in
  - `set_message($msg)`: Sets flash messages

### 3. User Class
- **Purpose**: Handles user authentication and management
- **Key Methods**:
  - `authenticate($username, $password)`: Validates login credentials
  - `create($username, $password)`: Creates new user
  - `find_by_id($id)`: Finds user by ID

### 4. Subject Class
- **Purpose**: Manages subjects (categories)
- **Key Methods**:
  - `get_all($public)`: Gets all subjects (public or admin view)
  - `find_by_id($id)`: Finds subject by ID
  - `create($menu_name, $position, $visible)`: Creates new subject
  - `update($id, $menu_name, $position, $visible)`: Updates subject
  - `delete($id)`: Deletes subject and its pages

### 5. Page Class
- **Purpose**: Manages pages within subjects
- **Key Methods**:
  - `get_for_subject($subject_id, $public)`: Gets pages for a subject
  - `find_by_id($id)`: Finds page by ID
  - `get_default_for_subject($subject_id)`: Gets default page for subject
  - `create($subject_id, $menu_name, $position, $visible, $content)`: Creates new page
  - `update($id, $menu_name, $position, $visible, $content)`: Updates page
  - `delete($id)`: Deletes page

### 6. Navigation Class
- **Purpose**: Generates navigation menus
- **Key Methods**:
  - `admin_navigation($sel_subject, $sel_page)`: Admin navigation menu
  - `public_navigation($sel_subject, $sel_page)`: Public navigation menu
  - `find_selected_page()`: Determines current page/subject from URL

### 7. FormValidator Class
- **Purpose**: Handles form validation and output sanitization
- **Key Methods**:
  - `check_required_fields($required_array)`: Validates required fields
  - `check_max_field_lengths($field_length_array, $database)`: Validates field lengths
  - `display_errors($error_array)`: Shows validation errors
  - `sanitize_output($value)`: Sanitizes output for XSS prevention
  - `strip_tags($value)`: Removes HTML tags from content

## Key OOP Concepts Demonstrated

### 1. Encapsulation
- Private properties and methods
- Public interfaces for external access
- Data hiding through proper access modifiers

### 2. Single Responsibility Principle
- Each class has one specific purpose
- Database class handles only database operations
- Session class handles only session management
- FormValidator class handles only validation

### 3. Dependency Injection
- Database object is passed to other classes
- Classes depend on abstractions, not concrete implementations

### 4. Constructor Injection
- Database connection is injected into classes that need it
- Promotes loose coupling between classes

### 5. Static Methods
- FormValidator uses static methods for utility functions
- No need to instantiate the class for validation

## How to Use

1. **Setup Database**: Ensure the `widget_corp` database exists with the required tables
2. **Configure**: Check `includes/constants.php` for database settings
3. **Access**: Navigate to the project folder in your web browser
4. **Login**: Use the login system to access admin features

## Security Features

- **SQL Injection Prevention**: Uses `escape_value()` method
- **XSS Prevention**: Uses `sanitize_output()` for output
- **Session Security**: Proper session management
- **Input Validation**: Form validation on all inputs

## Learning Benefits

This OOP version demonstrates:
- How to structure PHP applications using classes
- Proper separation of concerns
- Database abstraction
- Session management
- Form validation
- Security best practices
- Code reusability through inheritance and composition

## Comparison with Procedural Version

The OOP version offers:
- **Better Organization**: Code is organized into logical classes
- **Reusability**: Classes can be reused across different parts of the application
- **Maintainability**: Easier to maintain and extend
- **Testability**: Classes can be unit tested independently
- **Scalability**: Easier to add new features without affecting existing code

This structure is perfect for students learning PHP OOP concepts as it shows real-world application of object-oriented principles in a simple, understandable way.
