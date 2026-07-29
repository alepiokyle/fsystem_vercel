<?php

namespace App\Imports;

use App\Models\ImportedStudentId;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;

class StudentImport implements ToCollection, WithStartRow
{
    private $failures = [];

    public function startRow(): int
    {
        return 1;
    }

    public function collection(Collection $rows)
    {
        $this->failures = [];

        $firstRow = $rows->first();
        $isHeaderRow = false;
        $columnMap = [];

        if ($firstRow) {
            $possibleHeaders = ['student id', 'student_id'];
            $headerCount = 0;
            foreach ($firstRow as $cell) {
                $cellLower = strtolower(trim($cell ?? ''));
                if (in_array($cellLower, $possibleHeaders)) {
                    $headerCount++;
                }
            }
            if ($headerCount >= 1) {
                $isHeaderRow = true;
                foreach ($firstRow as $index => $header) {
                    $headerLower = strtolower(trim($header ?? ''));
                    switch ($headerLower) {
                        case 'student id':
                        case 'student_id':
                            $columnMap['student_id'] = $index;
                            break;
                    }
                }
            }
        }

        foreach ($rows as $rowIndex => $row) {
            if ($isHeaderRow && $rowIndex === 0) continue;

            $rowNumber = $rowIndex + 1;
            $data = [];
            if ($isHeaderRow && !empty($columnMap)) {
                $data['student_id'] = trim($row[$columnMap['student_id']] ?? '');
            } else {
                $data = [
                    'student_id' => trim($row[0] ?? ''),
                ];
            }

            if (empty($data['student_id'])) {
                continue;
            }

            $validator = \Illuminate\Support\Facades\Validator::make($data, [
                'student_id' => 'required|unique:imported_student_ids,student_id',
            ]);

            if ($validator->fails()) {
                $this->failures[] = [
                    'row' => $rowNumber,
                    'errors' => $validator->errors()->all()
                ];
                continue;
            }

            try {
                ImportedStudentId::create([
                    'student_id' => $data['student_id'],
                ]);
            } catch (\Exception $e) {
                $this->failures[] = [
                    'row' => $rowNumber,
                    'errors' => [$e->getMessage()]
                ];
            }
        }
    }

    public function getFailures()
    {
        return $this->failures;
    }


}
