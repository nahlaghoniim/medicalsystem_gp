<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medication;

class MedicationSeeder extends Seeder
{
    public function run()
    {
        $path = storage_path('app/medications.csv');
        $file = fopen($path, 'r');

        if (!$file) {
            throw new \Exception("Could not open the file at {$path}");
        }

        $header = fgetcsv($file);
        dd($header); // <- test if this is reached

        while ($row = fgetcsv($file)) {
            $data = array_combine($header, $row);

            Medication::create([
                'name' => $data['Drugname'],
                'generic_name' => $data['Category'] ?? null,
                'manufacturer' => $data['Company'] ?? null,
                'description' => null,
                'dosage_form' => $data['Form'] ?? null,
                'strength' => null,
            ]);
        }

        fclose($file);
    }
}
