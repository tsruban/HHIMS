# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

HHIMS (Hospital Health Information Management System) is a PHP web application built on **CodeIgniter 2.x** for managing hospital operations including patient records, admissions, outpatient visits, laboratory, and pharmacy.

## Development Environment

- **Stack**: LAMP/XAMPP (Apache, MySQL, PHP)
- **Framework**: CodeIgniter 2.x with Modular Extensions (HMVC)
- **Database**: MySQL with UTF-8 encoding
- **Default URL**: http://127.0.0.1 or http://localhost
- **Default Login**: username `demo`, password `123`

### Database Setup

```bash
mysql -p
CREATE DATABASE hhims;
USE hhims;
SOURCE install/install.sql;
SOURCE install/data.sql;
```

Configure database credentials in `/application/config/database.php`.

## Architecture

### HMVC Pattern

The application uses **Modular Extensions (MX)** for HMVC architecture:

- **Core Extensions**: `/application/third_party/MX/` provides `MX_Controller`, `MX_Loader`, `MX_Router`
- **Custom Core**: `/application/core/` contains `MY_Loader`, `MY_Router` extending MX classes
- **Module Calls**: Use `Modules::run('module/controller/method', $params)` to invoke module controllers

### Module Structure

Feature modules in `/application/modules/`:
```
module_name/
├── controllers/
├── views/
└── index.html
```

Key modules: `patient`, `admission`, `opd`, `login`, `security`, `laboratory`, `pharmacy`, `clinic`, `report`, `form`, `table`, `lookup`

### Base Model Pattern

All models extend `My_Model` (`/application/core/My_Model.php`) which provides generic CRUD:

```php
class Mpatient extends My_Model {
    function __construct() {
        $this->_table = 'patient';
        $this->_key = 'PID';
    }
}
```

Models are prefixed with 'm' (e.g., `mpatient.php`, `madmission.php`).

### Access Control

Role-based permissions defined in `/application/config/hhims_access_config.php`:
- **User groups**: Programmer, Doctor, Admin, Nurse, LabTech, Pharm, Admission, Procedure_Room_Staff, Visitor
- **Permission levels**: `can_view`, `can_edit`, `can_create` per table/feature
- **Security check**: `Modules::run('security/check_edit_access', $table, 'permission')`

### Configuration Files

- `/application/config/database.php` - Database connection
- `/application/config/hhims_config.php` - Application settings (versions, colors, email, uploads)
- `/application/config/hhims_access_config.php` - RBAC definitions
- `/application/config/routes.php` - Default controller is `hhims`

### Dynamic Forms

Form definitions in `/application/forms/` define table structures and validation rules. The generic `Form` module controller uses these for CRUD operations.

## Key Conventions

- Controllers in modules extend `MX_Controller`
- Models use `$this->_table` and `$this->_key` for table mapping
- Session-based authentication with user data in `$_SESSION`
- Multi-mode support: Government Hospital (GH), Pain Clinic (PC), Private Practice (PP) via config
- Utility methods in `/application/libraries/mdscore.php`

## Important Notes

- Legacy codebase uses deprecated MySQL functions (e.g., `mysql_escape_string`)
- No automated test suite exists
- No build/CI pipeline - manual deployment expected
# CLAUDE.md - AI Assistant Guide for HHIMS

## Project Overview

**HHIMS (Hospital Health Information Management System)** is a comprehensive web-based hospital management platform built on **CodeIgniter 2.0.3** PHP framework. Originally developed by the Information and Communication Technology Agency of Sri Lanka, it provides complete healthcare facility management including patient registration, outpatient department (OPD), admissions, pharmacy, laboratory, and reporting.

- **License:** GNU Affero General Public License v3
- **Primary Author:** Mr. Thurairajasingam Senthilruban (TSRuban@mdsfoss.org)
- **Website:** www.hhims.org

## Technology Stack

| Component | Technology |
|-----------|------------|
| Backend | PHP 5.1.6+ |
| Framework | CodeIgniter 2.0.3 (HMVC - Modular Extensions) |
| Database | MySQL with InnoDB engine |
| Frontend | jQuery (1.4.2/1.5.2), jQuery UI, Angular.js, Bootstrap |
| PDF Generation | FPDF library |
| Email | PHPMailer library |

## Directory Structure

```
HHIMS_trruban/
├── application/              # Main application code
│   ├── config/               # Configuration files
│   │   ├── config.php        # Application settings
│   │   ├── database.php      # Database connection (edit credentials here)
│   │   └── routes.php        # URL routing (default: hhims controller)
│   ├── controllers/          # Base controllers (welcome.php, AjaxController.php)
│   ├── modules/              # HMVC modules (35+ healthcare modules)
│   │   ├── patient/          # Patient registration and management
│   │   ├── opd/              # Outpatient Department
│   │   ├── admission/        # Hospital admissions
│   │   ├── pharmacy/         # Pharmacy management
│   │   ├── appointment/      # Appointment scheduling
│   │   ├── lab/              # Laboratory management
│   │   ├── drug_stock/       # Drug inventory
│   │   ├── report/           # Reporting module
│   │   └── [20+ more modules...]
│   ├── models/               # Data models (27 model files)
│   ├── views/                # Base view templates
│   ├── forms/                # Form definitions (65+ forms)
│   ├── helpers/              # Helper functions
│   ├── libraries/            # Custom libraries
│   │   ├── mdscore.php       # Core MDS library
│   │   └── class/            # MDSIMMR, MDSReporter, MDSUpload, etc.
│   └── core/                 # CodeIgniter extensions
│       ├── My_Model.php      # Base model with CRUD operations
│       ├── MY_Loader.php     # Custom loader
│       └── MY_Router.php     # Custom router
├── system/                   # CodeIgniter framework (DO NOT MODIFY)
├── install/                  # Database installation scripts
│   ├── new/
│   │   ├── install.sql       # Database schema (2,377 lines)
│   │   └── data.sql          # Sample data (168,730 lines)
│   └── update/               # Migration scripts
├── js/                       # JavaScript libraries
├── css/                      # Stylesheets
├── images/                   # Image assets
├── attach/                   # File attachments storage
├── logs/                     # Application logs
├── index.php                 # Front controller entry point
└── mdsfoss.key               # License key file
```

## Module Structure (HMVC Pattern)

Each module in `application/modules/` follows this structure:

```
modules/{module_name}/
├── controllers/
│   └── {module_name}.php    # Controller extending MX_Controller
├── models/
│   └── m{module_name}.php   # Model extending My_Model (optional)
└── views/
    └── {view_name}.php      # View templates
```

## Key Conventions

### File Naming

| Type | Convention | Example |
|------|-----------|---------|
| Controllers | PascalCase, matches module name | `Patient.php`, `Opd.php` |
| Models | Prefix `m` + lowercase | `mpatient.php`, `madmission.php` |
| Views | Lowercase, underscore-separated | `patient_banner.php`, `opd_visits.php` |
| Forms | Lowercase, underscore-separated | `patient.php`, `opd_visits.php` |

### Controller Pattern

```php
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ModuleName extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checkLogin();  // Required authentication check
        $this->load->library('session');
    }

    public function index()
    {
        // Default action
    }

    public function action_name($param)
    {
        $this->load->model('mmodelname');
        $data["result"] = $this->mmodelname->get_data($param);
        $this->load->vars($data);
        $this->load->view('view_name');
    }
}
```

### Model Pattern

```php
<?php

class Mmodelname extends My_Model
{
    function __construct()
    {
        parent::__construct();
        $this->_table = 'table_name';    // Database table
        $this->_key = 'PrimaryKeyField'; // Primary key
        $this->load->database();
    }

    function get_custom_data($param)
    {
        $param = stripslashes($param);
        $param = mysql_real_escape_string($param);  // Legacy sanitization

        $dataset = array();
        $sql = "SELECT * FROM table WHERE field = '$param'";
        $Q = $this->db->query($sql);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $dataset[] = $row;
            }
        }
        $Q->free_result();
        return $dataset;
    }
}
```

### Form Definition Pattern

Forms are defined in `application/forms/` as PHP arrays:

```php
<?php
$form = array();
$form["OBJID"] = "PrimaryKeyField";   // Primary key field name
$form["TABLE"] = "table_name";         // Database table
$form["SAVE"] = "module/save";         // Save action URL
$form["CONTINUE"] = "module/view";     // Continue URL
$form["NEXT"] = "module/view";         // Next action URL
$form["FLD"] = array(
    array(
        "id" => "field_name",
        "name" => "field_name",
        "label" => "Display Label",
        "type" => "text|select|textarea|date|hidden",
        "value" => "",
        "option" => array("Option1", "Option2"),  // For select type
        "placeholder" => "Help text",
        "rules" => "trim|required|xss_clean",     // Validation rules
        "style" => "",
        "class" => "input",
        "can_edit" => array("Admin")              // Role permissions
    ),
    // More fields...
);
```

## Database Conventions

### Table Design Patterns

- **Primary Keys:** Uppercase abbreviations (e.g., `PID`, `OPDID`, `ADMID`)
- **Foreign Keys:** Prefixed with `fk_` in constraints
- **Indexes:** Prefixed with `IX_`
- **Audit Fields:** All tables include:
  - `CreateDate` - Record creation timestamp
  - `CreateUser` - User who created the record
  - `LastUpDate` - Last modification timestamp
  - `LastUpDateUser` - User who last modified
  - `Active` - Soft delete flag (1=active, 0=deleted)

### Key Tables

| Table | Purpose | Primary Key |
|-------|---------|-------------|
| `patient` | Patient registry | `PID` |
| `opd_visits` | OPD visit records | `OPDID` |
| `admission` | Hospital admissions | `ADMID` |
| `opd_presciption` | OPD prescriptions | `PRSID` |
| `lab_order` | Laboratory orders | `LABOID` |
| `drug_stock` | Drug inventory | `DrugStockID` |
| `user` | System users | `UserID` |

## Development Setup

### Prerequisites

- LAMP stack (Linux, Apache, MySQL, PHP 5.1.6+)
- MySQL client for database setup
- Web browser (Chrome recommended)

### Quick Setup

1. Clone to `/var/www`
2. Set permissions: `chmod 755 /var/www -R`
3. Configure database in `application/config/database.php`:
   ```php
   $db['default']['username'] = 'your_username';
   $db['default']['password'] = 'your_password';
   $db['default']['database'] = 'hhims';
   ```
4. Create database and import:
   ```sql
   CREATE DATABASE hhims;
   USE hhims;
   SOURCE /var/www/install/new/install.sql;
   SOURCE /var/www/install/new/data.sql;
   ```
5. Access via browser: `http://127.0.0.1`
6. Default login: `demo` / `123`

## URL Routing

URLs follow CodeIgniter conventions:

```
http://host/index.php/module/controller/method/param1/param2
```

Examples:
- `index.php/patient/create` - Create new patient
- `index.php/patient/view/123` - View patient ID 123
- `index.php/opd/visits/456` - OPD visits for patient
- `index.php/admission/create/789` - Create admission for patient

## Common Patterns

### Loading Models

```php
$this->load->model('mpatient');
$data = $this->mpatient->get_allergy_list($pid);
```

### Running Module Actions

```php
// Call another module's method
echo Modules::run('form/create', 'patient');
```

### Session Data

```php
$this->session->userdata('user_info');      // Current user info
$this->session->userdata('hospital_info');  // Hospital configuration
$this->session->userdata('mid');            // Module ID
```

### View Loading

```php
$data["patient_info"] = $result;
$this->load->vars($data);       // Pass data to view
$this->load->view('view_name'); // Load view template
```

## Security Considerations

This is a legacy codebase with known security patterns that should be improved:

1. **SQL Injection:** Uses deprecated `mysql_real_escape_string()` - consider using PDO prepared statements or CodeIgniter's query binding
2. **XSS:** Uses CodeIgniter's `xss_clean` in form validation rules
3. **Authentication:** `checkLogin()` method in controllers enforces login
4. **Authorization:** Form-level permissions via `can_edit` arrays

## Healthcare Domain Knowledge

### Key Terminology

- **HIN:** Hospital Identification Number (patient identifier with Luhn checksum)
- **PID:** Patient ID (internal database identifier)
- **OPD:** Outpatient Department
- **ICD-10:** International Classification of Diseases (diagnosis codes)
- **SNOMED-CT:** Systematized Nomenclature of Medicine (clinical terms)
- **IMMR:** Indoor Morbidity and Mortality Returns (reporting)

### Patient Flow

1. Patient Registration (`patient` module) - Creates HIN
2. OPD Visit (`opd` module) - Consultation, prescription
3. Admission (`admission` module) - If hospitalization needed
4. Laboratory (`lab` module) - Test orders and results
5. Pharmacy (`pharmacy` module) - Medication dispensing
6. Discharge/Follow-up

## Testing

CodeIgniter includes a unit testing library at `system/libraries/Unit_test.php`. Test views exist at:
- `application/views/test.php`
- `application/views/test2.php`

## Files to Never Commit

Per `.gitignore`:
- `application/logs/` - Log files
- `.buildpath` - IDE configuration
- `.project` - IDE configuration

Additionally, never commit:
- `application/config/database.php` with production credentials
- `mdsfoss.key` license file with production keys
- Any files in `attach/` containing patient data

## Making Changes

### Adding a New Module

1. Create folder: `application/modules/{module_name}/`
2. Create subfolders: `controllers/`, `views/`, optionally `models/`
3. Create controller extending `MX_Controller`
4. Create form definition in `application/forms/`
5. Add menu entry via admin interface

### Adding Database Tables

1. Create migration SQL in `install/update/`
2. Follow existing table patterns (audit fields, InnoDB, utf8)
3. Update `install/new/install.sql` for fresh installations

### Modifying Forms

1. Edit form definition in `application/forms/{form_name}.php`
2. Add/modify field arrays with appropriate validation rules
3. Update corresponding view if custom display needed

## Debugging

- Error logs: `application/logs/`
- Enable debug: Set `$db['default']['db_debug'] = TRUE` in database.php
- PHP errors: Set `error_reporting(E_ALL)` in `index.php` (development only)

## Important Notes for AI Assistants

1. **Always include the HHIMS license header** when creating new PHP files
2. **Use the existing patterns** - this codebase has established conventions
3. **Test database queries** carefully - patient data is sensitive
4. **Follow HMVC structure** - keep modules self-contained
5. **Sanitize all user input** - healthcare data requires strong security
6. **Document changes** - add comments explaining healthcare domain logic
7. **Preserve audit fields** - always set CreateDate/CreateUser on inserts, LastUpDate/LastUpDateUser on updates
