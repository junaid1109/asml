<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\HomeSection;

// Get all sections (including deleted/inactive)
$allSections = HomeSection::orderBy('id')->get();

// Get only active sections (what the frontend shows)
$activeSections = HomeSection::where('is_active', true)->orderBy('display_order')->get();

echo "<!DOCTYPE html>
<html>
<head>
  <title>🔍 Verify HomeSection Data</title>
  <style>
    body { font-family: Arial; margin: 20px; background: #f5f5f5; }
    .box { background: white; padding: 20px; margin: 20px 0; border-radius: 5px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
    th { background: #667eea; color: white; }
    .active { background: #d4edda; color: #155724; }
    .deleted { background: #f8d7da; color: #721c24; }
    h2 { color: #333; border-bottom: 2px solid #667eea; }
  </style>
</head>
<body>

<div class='box'>
  <h2>📊 Database Check - All HomeSections</h2>
  <p>Total sections in database: <strong>" . count($allSections) . "</strong></p>
  
  <table>
    <tr>
      <th>ID</th>
      <th>Section Name</th>
      <th>Title</th>
      <th>Active</th>
      <th>Display Order</th>
      <th>Status</th>
    </tr>";

foreach ($allSections as $section) {
    $active = $section->is_active ? 'Yes' : 'No';
    $rowClass = $section->is_active ? 'active' : 'deleted';
    $status = $section->is_active ? '✓ ACTIVE' : '✗ INACTIVE';
    
    echo "<tr class='$rowClass'>
      <td>$section->id</td>
      <td>$section->section_name</td>
      <td>" . substr($section->title, 0, 30) . "...</td>
      <td>$active</td>
      <td>$section->display_order</td>
      <td>$status</td>
    </tr>";
}

echo "</table>
</div>

<div class='box'>
  <h2>🌐 Frontend Display - Only Active Sections</h2>
  <p>Sections shown on homepage: <strong>" . count($activeSections) . "</strong></p>
  
  <table>
    <tr>
      <th>ID</th>
      <th>Section Name</th>
      <th>Title</th>
      <th>Display Order</th>
    </tr>";

if (count($activeSections) > 0) {
    foreach ($activeSections as $section) {
        echo "<tr>
          <td>$section->id</td>
          <td>$section->section_name</td>
          <td>" . substr($section->title, 0, 30) . "...</td>
          <td>$section->display_order</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='4' style='text-align: center; color: #999;'>No active sections</td></tr>";
}

echo "</table>
</div>

<div class='box'>
  <h2>💡 What This Means</h2>
  <ul>
    <li><strong>All Sections:</strong> Shows everything in the database</li>
    <li><strong>Frontend Display:</strong> Shows only sections where is_active=true</li>
    <li><strong>If deleted section still appears:</strong> Either browser cache or Laravel config cache</li>
  </ul>
  
  <h3>How to fix:</h3>
  <ol>
    <li>Hard refresh browser: <strong>Ctrl+Shift+R</strong> (Windows) or <strong>Cmd+Shift+R</strong> (Mac)</li>
    <li>Clear Laravel cache: Run <code>php artisan cache:clear && php artisan view:clear && php artisan config:cache</code></li>
    <li>Check if deleted section is actually gone from the 'All Sections' table</li>
  </ol>
</div>

</body>
</html>";
?>
