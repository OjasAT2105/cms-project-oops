# CMS OOP Usage Guide

## Quick Start

1. **Test the Installation**
   - Open your browser and go to: `http://localhost/cms-project-oops/cms-project-oops/test.php`
   - This will verify that all components are working correctly

2. **Access the Main Application**
   - Main page: `http://localhost/cms-project-oops/cms-project-oops/public/index.php`
   - Add new subject: `http://localhost/cms-project-oops/cms-project-oops/public/new_subject.php`
   - Add new page: `http://localhost/cms-project-oops/cms-project-oops/public/new_page.php?subj=1` (replace 1 with actual subject ID)

## Features Working

### ✅ Subject Management
- **Create Subject**: `new_subject.php` - Add new subjects with name, position, and visibility
- **Edit Subject**: `edit_subject.php?subj=ID` - Modify existing subjects
- **Delete Subject**: Automatic deletion from edit page (with confirmation)
- **View Subjects**: All subjects displayed in navigation

### ✅ Page Management
- **Create Page**: `new_page.php?subj=ID` - Add new pages to subjects
- **Edit Page**: `edit_page.php?page=ID&subj=ID` - Modify existing pages
- **Delete Page**: Automatic deletion from edit page (with confirmation)
- **View Pages**: All pages displayed under their subjects in navigation

### ✅ Navigation
- Dynamic navigation showing all subjects and pages
- Selected items highlighted
- Proper linking between pages

### ✅ Form Validation
- Required field validation
- Length validation
- Numeric validation
- Error display and form state preservation

### ✅ Security
- SQL injection protection
- XSS protection
- Input sanitization
- Access control

## URL Structure

The OOP version maintains the same URL structure as the original:

- **Main page**: `index.php`
- **View subject**: `index.php?subj=ID`
- **View page**: `index.php?page=ID`
- **Edit subject**: `edit_subject.php?subj=ID`
- **Edit page**: `edit_page.php?page=ID&subj=ID`
- **New subject**: `new_subject.php`
- **New page**: `new_page.php?subj=ID`

## Database Requirements

The system expects these tables:

### subjects
```sql
CREATE TABLE subjects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    menu_name VARCHAR(255) NOT NULL,
    position INT NOT NULL,
    visible TINYINT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### pages
```sql
CREATE TABLE pages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    subject_id INT NOT NULL,
    menu_name VARCHAR(255) NOT NULL,
    position INT NOT NULL,
    visible TINYINT NOT NULL DEFAULT 1,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);
```

## Configuration

Edit `config/config.php` to set your database connection:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'widget_corp');
```

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check your database credentials in `config/config.php`
   - Ensure MySQL is running
   - Verify the database exists

2. **Page Not Found Errors**
   - Make sure all files are in the correct directory structure
   - Check file permissions

3. **Form Validation Errors**
   - All required fields must be filled
   - Menu names cannot exceed 30 characters
   - Position must be a number between 1-100

### Testing

Run the test file to verify everything is working:
`http://localhost/cms-project-oops/cms-project-oops/test.php`

## Comparison with Original

The OOP version provides the same functionality as the original procedural version:

- ✅ Same user interface
- ✅ Same database operations
- ✅ Same form validation
- ✅ Same navigation structure
- ✅ Same URL patterns
- ✅ Enhanced security and maintainability
- ✅ Better error handling
- ✅ Object-oriented architecture

## Next Steps

Once you've verified everything is working:

1. Start by creating a few subjects
2. Add pages to those subjects
3. Test editing and deleting functionality
4. Customize the CSS in `stylesheets/public.css` if needed

The OOP version is ready for production use and maintains full compatibility with the original procedural version.
