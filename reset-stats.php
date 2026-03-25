<?php
require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\HomeSection;

// Reset hero
$hero = HomeSection::find(1);
$hero->update(['content' => [
    ['number' => '500+', 'label' => 'Successful Projects'],
    ['number' => '98%', 'label' => 'Client Satisfaction'],
    ['number' => '10+', 'label' => 'Years Experience'],
]]);

// Reset about
$about = HomeSection::find(2);
$about->update(['content' => [
    ['number' => '15', 'label' => 'Years Experience'],
    ['number' => '850', 'label' => 'Projects Completed'],
    ['number' => '240', 'label' => 'Happy Clients'],
]]);

echo "✓ Data reset to original values\n";
?>
