<?php

namespace App\Helpers;

class UniversityDataHelper
{
    /**
     * ANCHOR: Get all faculty data
     * Returns array of faculty data with value and label
     */
    public static function getFakultas(): array
    {
        return [
            ['value' => 'FITK', 'label' => 'Ilmu Tarbiyah dan Keguruan (FITK)'],
            ['value' => 'FAH', 'label' => 'Adab dan Humaniora (FAH)'],
            ['value' => 'USHULUDDIN', 'label' => 'Ushuluddin'],
            ['value' => 'FSH', 'label' => 'Syariah dan Hukum (FSH)'],
            ['value' => 'FDIK', 'label' => 'Ilmu Dakwah dan Ilmu Komunikasi (FDIK)'],
            ['value' => 'FDI', 'label' => 'Dirasat Islamiyah (FDI)'],
            ['value' => 'PSIKOLOGI', 'label' => 'Psikologi'],
            ['value' => 'FEB', 'label' => 'Ekonomi dan Bisnis (FEB)'],
            ['value' => 'FST', 'label' => 'Sains dan Teknologi (FST)'],
            ['value' => 'FIKES', 'label' => 'Ilmu Kesehatan (FIKES)'],
            ['value' => 'FISIP', 'label' => 'Ilmu Sosial dan Ilmu Politik (FISIP)'],
            ['value' => 'FK', 'label' => 'Kedokteran (FK)'],
        ];
    }

    /**
     * ANCHOR: Get all study program data
     * Returns array of study program data with value and label
     */
    public static function getProgramStudi(): array
    {
        return [
            ['value' => 'pai', 'label' => 'Pendidikan Agama Islam'],
            ['value' => 'pba', 'label' => 'Pendidikan Bahasa Arab'],
            ['value' => 'pbi', 'label' => 'Pendidikan Bahasa Inggris'],
            ['value' => 'pmtk', 'label' => 'Pendidikan Matematika'],
            ['value' => 'pbio', 'label' => 'Pendidikan Biologi'],
            ['value' => 'pfis', 'label' => 'Pendidikan Fisika'],
            ['value' => 'pkim', 'label' => 'Pendidikan Kimia'],
            ['value' => 'mp', 'label' => 'Manajemen Pendidikan'],
            ['value' => 'pgmi', 'label' => 'Pendidikan Guru Madrasah Ibtidaiyah'],
            ['value' => 'pbsi', 'label' => 'Pendidikan Bahasa dan Sastra Indonesia'],
            ['value' => 'pips', 'label' => 'Pendidikan Ilmu Pengetahuan Sosial'],
            ['value' => 'piaud', 'label' => 'Pendidikan Islam Anak Usia Dini'],
            ['value' => 'bsa', 'label' => 'Bahasa dan Sastra Arab'],
            ['value' => 'si', 'label' => 'Sastra Inggris'],
            ['value' => 'ski', 'label' => 'Sejarah dan Kebudayaan Islam'],
            ['value' => 'tarjamah', 'label' => 'Tarjamah (Bahasa Arab)'],
            ['value' => 'perpus', 'label' => 'Ilmu Perpustakaan'],
            ['value' => 'saa', 'label' => 'Studi Agama Agama'],
            ['value' => 'iat', 'label' => 'Ilmu Al-Quran dan Tafsir'],
            ['value' => 'ih', 'label' => 'Ilmu Hadis'],
            ['value' => 'afi', 'label' => 'Aqidah dan Filsafat Islam'],
            ['value' => 'tasawuf', 'label' => 'Ilmu Tasawuf'],
            ['value' => 'pm', 'label' => 'Perbandingan Mazhab'],
            ['value' => 'hki', 'label' => 'Hukum Keluarga Islam (Akhwal Syakhsiyyah)'],
            ['value' => 'htn', 'label' => 'Hukum Tata Negara (Siyasah)'],
            ['value' => 'hpi', 'label' => 'Hukum Pidana Islam (Jinayah)'],
            ['value' => 'hes', 'label' => 'Hukum Ekonomi Syariah (Muamalat)'],
            ['value' => 'ihk', 'label' => 'Ilmu Hukum'],
            ['value' => 'kpi', 'label' => 'Komunikasi dan Penyiaran Islam'],
            ['value' => 'bpi', 'label' => 'Bimbingan Penyuluhan Islam'],
            ['value' => 'md', 'label' => 'Manajemen Dakwah'],
            ['value' => 'pmi', 'label' => 'Pengembangan Masyarakat Islam'],
            ['value' => 'kesos', 'label' => 'Kesejahteraan Sosial'],
            ['value' => 'jurnal', 'label' => 'Jurnalistik'],
            ['value' => 'manajemen', 'label' => 'Manajemen'],
            ['value' => 'akuntansi', 'label' => 'Akuntansi'],
            ['value' => 'ep', 'label' => 'Ekonomi Pembangunan'],
            ['value' => 'ps', 'label' => 'Perbankan Syariah'],
            ['value' => 'es', 'label' => 'Ekonomi Syariah'],
            ['value' => 'ti', 'label' => 'Teknik Informatika'],
            ['value' => 'agb', 'label' => 'Agribisnis'],
            ['value' => 'si_fst', 'label' => 'Sistem Informasi'],
            ['value' => 'mtk_fst', 'label' => 'Matematika'],
            ['value' => 'bio_fst', 'label' => 'Biologi'],
            ['value' => 'kim_fst', 'label' => 'Kimia'],
            ['value' => 'fis_fst', 'label' => 'Fisika'],
            ['value' => 'tambang', 'label' => 'Teknik Pertambangan'],
            ['value' => 'kesmas', 'label' => 'Kesehatan Masyarakat'],
            ['value' => 'farmasi', 'label' => 'Farmasi'],
            ['value' => 'keperawatan', 'label' => 'Ilmu Keperawatan'],
            ['value' => 'sosiologi', 'label' => 'Sosiologi'],
            ['value' => 'ip', 'label' => 'Ilmu Politik'],
            ['value' => 'hi', 'label' => 'Ilmu Hubungan Internasional'],
        ];
    }



    /**
     * ANCHOR: Get faculty label by value
     * Returns faculty label for given value
     */
    public static function getFakultasLabel(string $value): ?string
    {
        $fakultas = self::getFakultas();
        
        foreach ($fakultas as $fakultasItem) {
            if ($fakultasItem['value'] === $value) {
                return $fakultasItem['label'];
            }
        }
        
        return null;
    }

    /**
     * ANCHOR: Get study program label by value
     * Returns study program label for given value
     */
    public static function getProgramStudiLabel(string $value): ?string
    {
        $programStudi = self::getProgramStudi();
        
        foreach ($programStudi as $programItem) {
            if ($programItem['value'] === $value) {
                return $programItem['label'];
            }
        }
        
        return null;
    }

    /**
     * ANCHOR: Get all KKN types
     * Returns array of KKN types with value and label
     */
    public static function getJenisKKN(): array
    {
        return [
            ['value' => 'reguler', 'label' => 'KKN Reguler'],
            ['value' => 'in_campus', 'label' => 'KKN In Campus'],
            ['value' => 'tematik', 'label' => 'KKN Tematik'],
            ['value' => 'kebangsaan', 'label' => 'KKN Kebangsaan'],
            ['value' => 'internasional', 'label' => 'KKN Internasional'],
        ];
    }

    /**
     * ANCHOR: Get batch years range
     * Returns array of batch years from 2025 to 2050
     */
    public static function getAngkatan(): array
    {
        return range(2025, 2050);
    }

    /**
     * ANCHOR: Get KKN group numbers range
     * Returns array of KKN group numbers from 1 to 300
     */
    public static function getNoKelompokKKN(): array
    {
        return range(1, 300);
    }

    /**
     * ANCHOR: Get KKN years range
     * Returns array of KKN years from 2022 to 2050
     */
    public static function getTahunKKN(): array
    {
        return range(2025, 2050);
    }

    /**
     * ANCHOR: Get KKN type label by value
     * Returns KKN type label for given value
     */
    public static function getJenisKKNLabel(string $value): ?string
    {
        $jenisKKN = self::getJenisKKN();
        
        foreach ($jenisKKN as $jenisItem) {
            if ($jenisItem['value'] === $value) {
                return $jenisItem['label'];
            }
        }
        
        return null;
    }

    /**
     * ANCHOR: Get all file types
     * Returns array of file types with value and label
     */
    public static function getJenisFile(): array
    {
        return [
            ['value' => 'dokumen', 'label' => 'Dokumen'],
            ['value' => 'presentasi', 'label' => 'Presentasi'],
            ['value' => 'video', 'label' => 'Video'],
            ['value' => 'gambar', 'label' => 'Gambar'],
            ['value' => 'lainnya', 'label' => 'Lainnya'],
        ];
    }

    /**
     * ANCHOR: Get all KKN field categories (alias for getKnowledgeCategories)
     * Returns array of KKN field categories with value and label
     */
    public static function getKategoriBidang(): array
    {
        return self::getKnowledgeCategories();
    }

    /**
     * ANCHOR: Get file type label by value
     * Returns file type label for given value
     */
    public static function getJenisFileLabel(string $value): ?string
    {
        $jenisFile = self::getJenisFile();
        
        foreach ($jenisFile as $jenisItem) {
            if ($jenisItem['value'] === $value) {
                return $jenisItem['label'];
            }
        }
        
        return null;
    }

    /**
     * ANCHOR: Get all knowledge categories from database
     * Returns array of knowledge categories with value and label
     */
    public static function getKnowledgeCategories(): array
    {
        try {
            $categories = \App\Models\KnowledgeCategory::all();
            
            return $categories->map(function ($category) {
                return [
                    'value' => $category->id,
                    'label' => $category->name,
                ];
            })->toArray();
        } catch (\Exception $e) {
            // Fallback to hardcoded categories if database is not available
            return [
                ['value' => 1, 'label' => 'Pendidikan'],
                ['value' => 2, 'label' => 'Kesehatan'],
                ['value' => 3, 'label' => 'Ekonomi'],
                ['value' => 4, 'label' => 'Lingkungan'],
                ['value' => 5, 'label' => 'Teknologi'],
                ['value' => 6, 'label' => 'Sosial'],
            ];
        }
    }

    /**
     * ANCHOR: Get knowledge category by ID
     * Returns knowledge category for given ID
     */
    public static function getKnowledgeCategoryById(int $id): ?array
    {
        try {
            $category = \App\Models\KnowledgeCategory::find($id);
            
            if ($category) {
                return [
                    'value' => $category->id,
                    'label' => $category->name,
                ];
            }
            
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * ANCHOR: Get knowledge category label by ID
     * Returns knowledge category label for given ID
     */
    public static function getKnowledgeCategoryLabel(int $id): ?string
    {
        $category = self::getKnowledgeCategoryById($id);
        return $category ? $category['label'] : null;
    }
} 