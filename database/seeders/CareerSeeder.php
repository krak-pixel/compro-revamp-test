<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Job;
use App\Models\Location;
use App\Models\Position;
use Illuminate\Database\Seeder;

class CareerSeeder extends Seeder
{
    public function run(): void
    {
        $locations = collect(['Jakarta / Tangerang', 'Jakarta', 'Tangerang'])
            ->mapWithKeys(function (string $name): array {
                $slug = str($name)->slug()->toString();

                return [$slug => Location::updateOrCreate(
                    ['slug' => $slug],
                    ['name' => $name, 'is_active' => true],
                )];
            });

        $jobs = [
            [
                'title' => 'Preseller GT-Retail AFH',
                'department' => 'Sales',
                'level' => 'Staff',
                'location' => 'jakarta',
                'poster' => 'images/tvip/career/preseller-gt-retail-afh.png',
                'description' => 'Menjalankan aktivitas penjualan dan distribusi produk TVIP secara konsisten pada area yang ditentukan.',
                'qualifications' => ['Usia minimal 18 tahun', 'Fresh graduate dipersilakan melamar', 'Diutamakan memiliki pengalaman minimal 1 tahun', 'Pendidikan minimal SMA/SMK sederajat', 'Memiliki sepeda motor dan SIM C aktif', 'Terbiasa bekerja dengan target', 'Bersedia ditugaskan di lapangan'],
            ],
            [
                'title' => 'Sales Operation Support Staff',
                'department' => 'Sales',
                'level' => 'Staff',
                'location' => 'jakarta-tangerang',
                'poster' => 'images/tvip/career/sales-operation-support-staff.png',
                'description' => 'Mendukung operasional tim sales, administrasi penjualan, dan koordinasi kebutuhan lapangan.',
                'qualifications' => ['Pendidikan minimal D3/Sederajat', 'Menguasai Microsoft Excel', 'Memiliki kemampuan administrasi yang baik', 'Mampu bekerja secara teliti dan terorganisasi', 'Bersedia ditempatkan di Jakarta/Tangerang'],
            ],
            [
                'title' => 'Admin Depo',
                'department' => 'Operations',
                'level' => 'Staff',
                'location' => 'jakarta-tangerang',
                'poster' => 'images/tvip/career/admin-depo.png',
                'description' => 'Mengelola administrasi depo dan memastikan pencatatan operasional distribusi berjalan akurat.',
                'qualifications' => ['Pendidikan minimal D3/Sederajat', 'Menguasai administrasi dan pengarsipan', 'Mampu mengoperasikan Microsoft Office', 'Teliti, disiplin, dan bertanggung jawab', 'Bersedia ditempatkan di Jakarta/Tangerang'],
            ],
            [
                'title' => 'Kepala Depo',
                'department' => 'Operations',
                'level' => 'Manager',
                'location' => 'jakarta-tangerang',
                'poster' => 'images/tvip/career/kepala-depo.png',
                'description' => 'Memimpin seluruh operasional depo distribusi TVIP dengan tanggung jawab atas pencapaian target, manajemen tim lebih dari 100 orang, serta penjaminan efisiensi rantai distribusi.',
                'qualifications' => ['Pendidikan minimal D3 semua jurusan', 'Berpengalaman minimal 3 tahun di bidang Kepala Depo pada perusahaan Distribution/Consumer Good/FMCG/Retail', 'Menguasai Sales Management', 'Terbiasa dengan pencapaian target', 'Memiliki kemampuan analisa, evaluasi, inisiatif, dan leadership yang baik', 'Mampu memimpin tim lebih dari 100 orang', 'Siap bekerja mobile', 'Bersedia ditempatkan Jakarta/Tangerang'],
            ],
            [
                'title' => 'Sales Supervisor',
                'department' => 'Sales',
                'level' => 'Supervisor',
                'location' => 'jakarta-tangerang',
                'poster' => 'images/tvip/career/sales-supervisor.png',
                'description' => 'Bertanggung jawab atas supervisi tim penjualan, pencapaian target area, dan pengembangan strategi penjualan di wilayah Jakarta dan Tangerang.',
                'qualifications' => ['Pendidikan minimal D3/Sederajat', 'Pengalaman sebagai Sales Supervisor Retail, SO/W, dan HOD/HCO minimal 1 tahun', 'Berpengalaman di perusahaan Fast Moving Consumer Good/Distribusi/Retail', 'Memiliki kemampuan berorientasi pencapaian target dan mampu mensupervisi team di area yang berbeda', 'Mampu menganalisa penjualan dan program promosi', 'Menguasai area Jakarta/Tangerang', 'Mempunyai SIM C', 'Siap bekerja mobile'],
            ],
            [
                'title' => 'Driver Distribusi',
                'department' => 'Logistik',
                'level' => 'Staff',
                'location' => 'tangerang',
                'poster' => 'images/tvip/career/driver-distribusi.png',
                'description' => 'Mengantarkan produk secara aman dan tepat waktu sesuai rute distribusi serta standar operasional TVIP.',
                'qualifications' => ['Memiliki SIM B1 aktif', 'Memahami area Jakarta dan Tangerang', 'Sehat jasmani dan rohani', 'Disiplin dan bertanggung jawab', 'Bersedia bekerja dengan jadwal operasional distribusi'],
            ],
            [
                'title' => 'Finance Administration Staff',
                'department' => 'Finance',
                'level' => 'Staff',
                'location' => 'jakarta',
                'poster' => 'images/tvip/career/admin-depo.png',
                'description' => 'Mendukung pencatatan transaksi, rekonsiliasi data, dan administrasi keuangan operasional TVIP.',
                'qualifications' => ['Pendidikan minimal D3 Akuntansi/Keuangan', 'Menguasai Microsoft Excel', 'Teliti dan terbiasa mengolah data', 'Mampu bekerja sesuai tenggat', 'Bersedia ditempatkan di Jakarta'],
            ],
            [
                'title' => 'Recruitment Staff',
                'department' => 'Human Resources',
                'level' => 'Staff',
                'location' => 'tangerang',
                'poster' => 'images/tvip/career/sales-operation-support-staff.png',
                'description' => 'Menjalankan proses rekrutmen, penjadwalan kandidat, dan administrasi kebutuhan tenaga kerja.',
                'qualifications' => ['Pendidikan minimal S1 Psikologi/Manajemen SDM', 'Memahami proses rekrutmen end-to-end', 'Komunikatif dan terorganisasi', 'Terbiasa mengelola data kandidat', 'Bersedia ditempatkan di Tangerang'],
            ],
            [
                'title' => 'IT Support Staff',
                'department' => 'Information Technology',
                'level' => 'Staff',
                'location' => 'jakarta-tangerang',
                'poster' => 'images/tvip/career/driver-distribusi.png',
                'description' => 'Memberikan dukungan teknis perangkat, jaringan, dan aplikasi untuk kelancaran kegiatan operasional.',
                'qualifications' => ['Pendidikan minimal D3 Teknik Informatika/Sistem Informasi', 'Memahami troubleshooting hardware dan jaringan', 'Mampu berkomunikasi dengan pengguna', 'Bersedia bekerja mobile', 'Bersedia ditempatkan di Jakarta/Tangerang'],
            ],
            [
                'title' => 'Warehouse Checker',
                'department' => 'Operations',
                'level' => 'Staff',
                'location' => 'tangerang',
                'poster' => 'images/tvip/career/kepala-depo.png',
                'description' => 'Memeriksa kesesuaian barang masuk dan keluar serta menjaga akurasi pencatatan stok gudang.',
                'qualifications' => ['Pendidikan minimal SMA/SMK sederajat', 'Teliti dan bertanggung jawab', 'Bersedia bekerja dalam sistem shift', 'Mampu bekerja dalam tim', 'Bersedia ditempatkan di Tangerang'],
            ],
            [
                'title' => 'Sales Taking Order',
                'department' => 'Sales',
                'level' => 'Staff',
                'location' => 'jakarta',
                'poster' => 'images/tvip/career/preseller-gt-retail-afh.png',
                'description' => 'Mengelola pesanan pelanggan dan menjaga hubungan dengan outlet pada area penjualan yang ditetapkan.',
                'qualifications' => ['Pendidikan minimal SMA/SMK sederajat', 'Memiliki sepeda motor dan SIM C aktif', 'Terbiasa bekerja dengan target', 'Komunikatif dan berorientasi layanan', 'Menguasai area Jakarta'],
            ],
            [
                'title' => 'Delivery Helper',
                'department' => 'Logistik',
                'level' => 'Staff',
                'location' => 'tangerang',
                'poster' => 'images/tvip/career/driver-distribusi.png',
                'description' => 'Mendukung proses bongkar muat dan pengantaran produk agar pesanan diterima dengan aman dan tepat waktu.',
                'qualifications' => ['Pendidikan minimal SMA/SMK sederajat', 'Sehat jasmani dan rohani', 'Disiplin dan bertanggung jawab', 'Mampu bekerja dalam tim distribusi', 'Bersedia ditempatkan di Tangerang'],
            ],
        ];

        foreach ($jobs as $index => $data) {
            $departmentSlug = str($data['department'])->slug()->toString();
            $department = Department::updateOrCreate(
                ['slug' => $departmentSlug],
                ['name' => $data['department'], 'is_active' => true],
            );
            $slug = str($data['title'])->slug()->toString();
            $position = Position::updateOrCreate(
                ['slug' => $slug],
                [
                    'department_id' => $department->id,
                    'name' => $data['title'],
                    'level' => $data['level'],
                    'is_active' => true,
                ],
            );

            Job::updateOrCreate(
                ['slug' => $slug],
                [
                    'department_id' => $department->id,
                    'position_id' => $position->id,
                    'location_id' => $locations[$data['location']]->id,
                    'title' => $data['title'],
                    'employment_type' => 'full_time',
                    'description' => $data['description'],
                    'qualifications' => $data['qualifications'],
                    'poster_path' => $data['poster'],
                    'opens_at' => today()->subDays(10 + $index),
                    'closes_at' => today()->addDays(25 + $index),
                    'status' => 'published',
                    'published_at' => now()->subDays(12 + $index),
                ],
            );
        }
    }
}
