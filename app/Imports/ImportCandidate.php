<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\tr_import_data;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportCandidate implements ToModel, WithHeadingRow
{
    // use Importable;

    public function model(array $row)
    {
      // dd($row);die;
            return new tr_import_data([
              'full_name' => $row['full_name'],
              'email' => $row['email'],
              'address' => $row['address'],
              'location' => $row['location'],
              'cell_phone' => $row['cellphone'],
              'gender' => $row['gender'],
              'birthdate' => $row['birthdate'],
              'current_sallary' => $row['current_salary'],
              'current_sallary2' => $row['current_salary2'],
              'expected_sallary' => $row['expected_salary'],
              'last_job' => $row['job_title_last_current_work_experience'],
              'last_company' => $row['last_current_company_name'],
              'last_education' => $row['last_education_level'],
              'last_major' => $row['last_major_name'],
              'last_school' => $row['last_school_name'],
              'efset' => $row['efset'],
              'communication_test' => $row['communication_test'],
              'interest_test' => $row['interest_test'],
              'tld_1' => $row['tld'],
              'orvi' => $row['orvi'],
              'apply_at' => $row['applied_at'],
              'matched' => $row['matched'],
              'shortlisted' => $row['shortlisted'],
              'not_matched' => $row['not_matched'],
              // 'orvi2' => $row['orvi2'],
              'interview1' => $row['interview_1'],
              'interview2' => $row['interview_2'],
              'interview3' => $row['interview_3'],
              'mcu' => $row['mcu'],
              // 'tld2' => $row['tld2'],
              'offered' => $row['offered'],
              'hired' => $row['hired'],
              'failed' => $row['failed'],
              'image' => $row['image'],
              'applied_position' => $row['applied_position'],
              'last_gpa' => $row['last_gpa'],
              // 'keterangan' => $row['keterangan'],
      ]);
    }
}
