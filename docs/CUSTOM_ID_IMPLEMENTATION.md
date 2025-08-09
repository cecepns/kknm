# ANCHOR: Custom ID Implementation for Internal Users

## Overview
Sistem KMS KKN telah diimplementasikan dengan fitur Custom ID untuk pengguna internal yang memungkinkan identifikasi yang lebih mudah dan deskriptif.

## Format Custom ID
Format: `[PREFIX][NUMBER]`
- **PREFIX**: 3 huruf yang menunjukkan role
- **NUMBER**: 3 digit angka (001, 002, dst.)

### Mapping Role Prefix
| Role | Prefix | Contoh |
|------|--------|--------|
| Kepala PPM | `Kep` | Kep001 |
| Koordinator KKN | `Kor` | Kor001 |
| Admin | `Adm` | Adm001 |
| Mahasiswa KKN | `Mah` | Mah001 |
| Dosen Pembimbing Lapangan | `Dos` | Dos001 |

## Implementasi

### 1. Database Changes
- **Migration**: `2025_01_15_000000_add_custom_id_to_users_table.php`
- **Field**: `custom_id` (string, unique, nullable)
- **Migration Data**: `2025_01_15_000001_populate_custom_id_for_existing_users.php`

### 2. Model Updates
- **User Model**: Menambahkan `custom_id` ke fillable fields
- **Auto-generation**: Custom ID otomatis dibuat saat user baru dibuat
- **Helper Methods**: Method untuk format dan validasi custom ID

### 3. Controller Updates
- **UserController**: Menggunakan custom_id untuk display dan ordering
- **Permission Check**: Tetap menggunakan permission `kelola-pengguna-internal`

### 4. View Updates
- **Daftar View**: Menampilkan custom_id dengan badge styling
- **Form View**: Menampilkan custom_id saat edit user
- **Formatting**: Menggunakan helper method untuk konsistensi

### 5. Helper Class
- **UserHelper**: Class utility untuk custom ID operations
- **Methods**:
  - `generateCustomId($roleId)`: Generate custom ID baru
  - `getRolePrefix($roleId)`: Get prefix berdasarkan role
  - `formatCustomId($customId)`: Format untuk display
  - `validateCustomIdFormat($customId)`: Validasi format

### 6. Artisan Command
- **Command**: `php artisan users:generate-custom-ids`
- **Options**: `--force` untuk regenerate semua custom ID
- **Features**: Progress bar, summary report, validation

## Usage Examples

### Generate Custom ID for New User
```php
// Otomatis saat create user baru
$user = User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'role_id' => 3, // Admin
    // custom_id akan otomatis dibuat: Adm002
]);
```

### Manual Generation
```php
use App\Helpers\UserHelper;

$customId = UserHelper::generateCustomId(3); // Returns: Adm002
```

### Display in Views
```php
// Di view
{!! $user->getFormattedCustomId() !!}

// Output: <span class="badge badge-primary">Adm001</span>
```

### Validation
```php
use App\Helpers\UserHelper;

$isValid = UserHelper::validateCustomIdFormat('Adm001'); // Returns: true
$isValid = UserHelper::validateCustomIdFormat('Invalid'); // Returns: false
```

## Database Schema

### Users Table
```sql
ALTER TABLE users ADD COLUMN custom_id VARCHAR(255) UNIQUE NULL AFTER id;
```

### Index
```sql
CREATE UNIQUE INDEX idx_users_custom_id ON users(custom_id);
```

## Security Considerations

### 1. Uniqueness
- Custom ID harus unik di seluruh sistem
- Database constraint: `UNIQUE`
- Validation di application level

### 2. Permission Control
- Hanya admin yang bisa mengelola pengguna internal
- Permission: `kelola-pengguna-internal`
- Middleware protection di routes

### 3. Data Integrity
- Custom ID tidak bisa diubah manual
- Auto-generation saat create user baru
- Migration untuk data existing

## Testing

### Command Testing
```bash
# Generate custom IDs untuk user yang belum punya
php artisan users:generate-custom-ids

# Force regenerate semua custom IDs
php artisan users:generate-custom-ids --force
```

### Manual Testing
1. Create user baru dengan role Admin
2. Verify custom ID: `Adm001`
3. Create user baru dengan role Admin
4. Verify custom ID: `Adm002`
5. Check uniqueness constraint

## Migration Guide

### For Existing Data
1. Run migration: `php artisan migrate`
2. Run seeder: `php artisan db:seed --class=UserSeeder`
3. Verify data: `php artisan users:generate-custom-ids`

### For New Installation
1. Run all migrations
2. Run all seeders
3. Custom IDs akan otomatis dibuat

## Benefits

### 1. User Experience
- **Identifikasi Cepat**: ID langsung menunjukkan role
- **User-Friendly**: Lebih mudah diingat dan dikomunikasikan
- **Visual Appeal**: Badge styling untuk custom ID

### 2. Administrative
- **Sorting Natural**: Pengelompokan berdasarkan role
- **Reporting**: Laporan lebih informatif
- **Audit Trail**: Tracking aktivitas berdasarkan role

### 3. Technical
- **Maintainability**: Kode lebih terorganisir
- **Extensibility**: Mudah ditambah role baru
- **Consistency**: Format yang konsisten

## Future Enhancements

### 1. Role Management
- Dynamic role prefix mapping
- Custom prefix per role
- Role-based custom ID rules

### 2. Advanced Features
- Custom ID search functionality
- Bulk custom ID generation
- Custom ID import/export

### 3. Integration
- API endpoints untuk custom ID
- Third-party system integration
- Custom ID validation services

## Troubleshooting

### Common Issues

#### 1. Duplicate Custom ID
```bash
# Check for duplicates
php artisan tinker
>>> App\Models\User::select('custom_id')->groupBy('custom_id')->havingRaw('COUNT(*) > 1')->get();
```

#### 2. Missing Custom ID
```bash
# Generate missing custom IDs
php artisan users:generate-custom-ids
```

#### 3. Invalid Format
```bash
# Validate all custom IDs
php artisan tinker
>>> App\Models\User::all()->each(function($user) { 
    if (!App\Helpers\UserHelper::validateCustomIdFormat($user->custom_id)) {
        echo "Invalid: {$user->custom_id} for {$user->name}\n";
    }
});
```

## Conclusion
Implementasi Custom ID telah berhasil meningkatkan user experience dan administrative efficiency dalam sistem KMS KKN. Fitur ini memberikan identifikasi yang lebih jelas dan memudahkan pengelolaan pengguna internal.
