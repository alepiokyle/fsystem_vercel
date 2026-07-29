<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$teachers = App\Models\TeacherAccount::whereNotNull('created_by')->where('is_active', true)->with('profile')->get();

echo "Teachers created by admin:\n";

foreach($teachers as $t) {
    echo $t->name . ' - Department ID: ' . ($t->profile ? $t->profile->department_id : 'no profile') . "\n";
}

echo "Total: " . $teachers->count() . "\n";
