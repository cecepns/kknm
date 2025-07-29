<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\KnowledgeCategory;

echo "Checking knowledge categories...\n";

$categories = KnowledgeCategory::all();
foreach($categories as $cat) {
    echo "Category: {$cat->name} (ID: {$cat->id}) - Knowledge count: " . $cat->knowledgeItems()->count() . "\n";
}

// Try to delete a category that has no knowledge items
$testCategory = KnowledgeCategory::where('name', 'Test Category for Delete')->first();
if ($testCategory) {
    echo "\nTrying to delete category: {$testCategory->name} (ID: {$testCategory->id})\n";
    echo "Knowledge count: " . $testCategory->knowledgeItems()->count() . "\n";
    
    if ($testCategory->knowledgeItems()->count() == 0) {
        $deleted = $testCategory->delete();
        echo "Delete result: " . ($deleted ? 'SUCCESS' : 'FAILED') . "\n";
    } else {
        echo "Cannot delete - has knowledge items\n";
    }
} else {
    echo "Test category not found\n";
} 