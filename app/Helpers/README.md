# UniversityDataHelper Documentation

## Overview
`UniversityDataHelper` adalah helper class yang menyimpan data global untuk aplikasi KKN UIN Sunan Kalijaga. Helper ini dirancang untuk menghindari duplikasi data dan memudahkan maintenance.

## Methods

### 1. getFakultas()
Mengembalikan array semua fakultas dengan format `['value' => 'kode', 'label' => 'nama']`

```php
use App\Helpers\UniversityDataHelper;

$fakultas = UniversityDataHelper::getFakultas();
```

### 2. getProgramStudi()
Mengembalikan array semua program studi dengan format `['value' => 'kode', 'label' => 'nama']`

```php
$programStudi = UniversityDataHelper::getProgramStudi();
```

### 3. getFakultasLabel(string $value)
Mengembalikan label fakultas berdasarkan value

```php
$fakultasLabel = UniversityDataHelper::getFakultasLabel('FITK');
// Returns: "Ilmu Tarbiyah dan Keguruan (FITK)"
```

### 4. getProgramStudiLabel(string $value)
Mengembalikan label program studi berdasarkan value

```php
$programLabel = UniversityDataHelper::getProgramStudiLabel('pai');
// Returns: "Pendidikan Agama Islam"
```

### 5. getJenisKKN()
Mengembalikan array semua jenis KKN dengan format `['value' => 'kode', 'label' => 'nama']`

```php
$jenisKKN = UniversityDataHelper::getJenisKKN();
```

### 6. getAngkatan()
Mengembalikan array tahun angkatan dari 2025-2050

```php
$angkatan = UniversityDataHelper::getAngkatan();
// Returns: [2025, 2026, 2027, ..., 2050]
```

### 7. getNoKelompokKKN()
Mengembalikan array nomor kelompok KKN dari 1-300

```php
$noKelompok = UniversityDataHelper::getNoKelompokKKN();
// Returns: [1, 2, 3, ..., 300]
```

### 8. getTahunKKN()
Mengembalikan array tahun KKN dari 2022-2050

```php
$tahunKKN = UniversityDataHelper::getTahunKKN();
// Returns: [2022, 2023, 2024, ..., 2050]
```

### 9. getJenisKKNLabel(string $value)
Mengembalikan label jenis KKN berdasarkan value

```php
$jenisKKNLabel = UniversityDataHelper::getJenisKKNLabel('reguler');
// Returns: "KKN Reguler"
```

### 10. getJenisFile()
Mengembalikan array semua jenis file dengan format `['value' => 'kode', 'label' => 'nama']`

```php
$jenisFile = UniversityDataHelper::getJenisFile();
```

### 11. getKategoriBidang()
Mengembalikan array semua kategori bidang KKN dengan format `['value' => 'kode', 'label' => 'nama']`

```php
$kategoriBidang = UniversityDataHelper::getKategoriBidang();
```

### 12. getJenisFileLabel(string $value)
Mengembalikan label jenis file berdasarkan value

```php
$jenisFileLabel = UniversityDataHelper::getJenisFileLabel('dokumen');
// Returns: "Dokumen"
```

### 13. getKategoriBidangLabel(string $value)
Mengembalikan label kategori bidang berdasarkan value

```php
$kategoriLabel = UniversityDataHelper::getKategoriBidangLabel('pendidikan');
// Returns: "Pendidikan"
```

## Usage Examples

### Di Controller
```php
use App\Helpers\UniversityDataHelper;

class SomeController extends Controller
{
    public function index()
    {
        return view('some-view', [
            'fakultas' => UniversityDataHelper::getFakultas(),
            'program_studi' => UniversityDataHelper::getProgramStudi(),
            'jenis_kkn' => UniversityDataHelper::getJenisKKN(),
            'angkatan' => UniversityDataHelper::getAngkatan(),
            'no_kelompok_kkn' => UniversityDataHelper::getNoKelompokKKN(),
            'tahun_kkn' => UniversityDataHelper::getTahunKKN(),
            'jenis_file' => UniversityDataHelper::getJenisFile(),
            'kategori_bidang' => UniversityDataHelper::getKategoriBidang()
        ]);
    }
}
```

### Di View (Blade)
```php
@foreach(UniversityDataHelper::getFakultas() as $fakultas)
    <option value="{{ $fakultas['value'] }}">{{ $fakultas['label'] }}</option>
@endforeach

@foreach(UniversityDataHelper::getJenisKKN() as $jenis)
    <option value="{{ $jenis['value'] }}">{{ $jenis['label'] }}</option>
@endforeach

@foreach(UniversityDataHelper::getJenisFile() as $jenis)
    <option value="{{ $jenis['value'] }}">{{ $jenis['label'] }}</option>
@endforeach

@foreach(UniversityDataHelper::getKategoriBidang() as $kategori)
    <option value="{{ $kategori['value'] }}">{{ $kategori['label'] }}</option>
@endforeach
```

### Di Model atau Service
```php
// Get label for display
$fakultasLabel = UniversityDataHelper::getFakultasLabel($user->faculty);
$programLabel = UniversityDataHelper::getProgramStudiLabel($user->study_program);
$jenisKKNLabel = UniversityDataHelper::getJenisKKNLabel($user->kkn_type);
$jenisFileLabel = UniversityDataHelper::getJenisFileLabel($knowledge->jenis_file);
$kategoriLabel = UniversityDataHelper::getKategoriBidangLabel($knowledge->kategori_bidang);
```

## Data Structure

### Fakultas
- FITK - Ilmu Tarbiyah dan Keguruan
- FAH - Adab dan Humaniora
- USHULUDDIN - Ushuluddin
- FSH - Syariah dan Hukum
- FDIK - Ilmu Dakwah dan Ilmu Komunikasi
- FDI - Dirasat Islamiyah
- PSIKOLOGI - Psikologi
- FEB - Ekonomi dan Bisnis
- FST - Sains dan Teknologi
- FIKES - Ilmu Kesehatan
- FISIP - Ilmu Sosial dan Ilmu Politik
- FK - Kedokteran

### Jenis KKN
- reguler - KKN Reguler
- in_campus - KKN In Campus
- tematik - KKN Tematik
- kebangsaan - KKN Kebangsaan
- internasional - KKN Internasional

### Jenis File
- dokumen - Dokumen
- presentasi - Presentasi
- video - Video
- gambar - Gambar
- lainnya - Lainnya

### Kategori Bidang KKN
- pendidikan - Pendidikan
- kesehatan - Kesehatan
- ekonomi - Ekonomi
- lingkungan - Lingkungan
- teknologi - Teknologi
- sosial - Sosial

### Ranges
- Angkatan: 2025-2050
- No Kelompok KKN: 1-300
- Tahun KKN: 2022-2050

## Benefits

1. **Single Source of Truth**: Data hanya disimpan di satu tempat
2. **Reusability**: Bisa digunakan di seluruh aplikasi
3. **Maintainability**: Perubahan data hanya perlu dilakukan di helper
4. **Type Safety**: Menggunakan type hints dan return types
5. **Documentation**: Setiap method memiliki dokumentasi yang jelas
6. **Lookup**: Kemampuan mendapatkan label berdasarkan value
7. **Consistency**: Format data yang konsisten di seluruh aplikasi

## Maintenance

Untuk menambah atau mengubah data:
1. Edit method `getFakultas()` untuk menambah/mengubah fakultas
2. Edit method `getProgramStudi()` untuk menambah/mengubah program studi
3. Edit method `getJenisKKN()` untuk menambah/mengubah jenis KKN
4. Edit method `getJenisFile()` untuk menambah/mengubah jenis file
5. Edit method `getKategoriBidang()` untuk menambah/mengubah kategori bidang
6. Edit method `getAngkatan()`, `getNoKelompokKKN()`, `getTahunKKN()` untuk mengubah ranges 