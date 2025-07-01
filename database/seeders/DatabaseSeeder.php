<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Kelompok;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Mahasiswa;
use App\Models\MainSoal;
use App\Models\MasterMateri;
use App\Models\MasterSoal;
use App\Models\MenuNavbar;
use App\Models\MenuPertemuan;
use App\Models\Navbar;
use App\Models\Pembelajaran;
use App\Models\Pertemuan;
use App\Models\PilihanJawaban;
use App\Models\Soal;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $dosen = User::factory()->create([
            'name' => 'Dosen',
            'email' => 'dosen@example.com',
        ]);
        $mahasiswa1 = User::factory()->create([
            'name' => 'Mahasiswa1',
            'email' => 'mahasiswa1@example.com',
        ]);
        $mahasiswa2 = User::factory()->create([
            'name' => 'Mahasiswa2',
            'email' => 'mahasiswa2@example.com',
        ]);

        $kelas = Kelas::create([
            'nama' => 'Kelas 1',
            'code' => 'KLS1',
        ]);

        $kelompok = Kelompok::create([
            'nama' => 'Kelompok 1',
            'code' => 'KPL1',
            'kelas_id' => $kelas->id,
        ]);

        Mahasiswa::create([
            'nama' => 'mahasiswa1',
            'user_id' => $mahasiswa1->id,
            'nim' => '123',
            'angkatan' => '2024',
            'program_studi' => 'Komputer',
            'email' => $mahasiswa1->email,
            'kelas_id' => $kelas->id,
            'kelompok_id' => $kelompok->id,
            'no_wa' => '-',
        ]);
        Mahasiswa::create([
            'nama' => 'mahasiswa2',
            'user_id' => $mahasiswa2->id,
            'nim' => '124',
            'angkatan' => '2024',
            'program_studi' => 'Komputer',
            'email' => $mahasiswa2->email,
            'kelas_id' => $kelas->id,
            'kelompok_id' => $kelompok->id,
            'no_wa' => '-',
        ]);

        $dosen = Dosen::create([
            'nama' => 'dosen',
            'user_id' => $dosen->id,
            'code' => '2344',
            'email' => $dosen->email,
            'no_wa' => '-',
        ]);

        $pembelajaran = Pembelajaran::create([
            'nama' => 'FISIKA DASAR',
            'code' => 'fd-01',
            'dosen_id' => $dosen->id,
            'kelas_id' => $kelas->id,
        ]);

        $pertemuan1 = Pertemuan::create([
            'nama' => 'Pertemuan 1',
            'code' => 'p-1',
            'pembelajaran_id' => $pembelajaran->id,
        ]);

        $navbar1 = Navbar::create([
            'nama' => 'Navbar 1',
            'code' => 'n-1',
            'pembelajaran_id' => $pembelajaran->id,
        ]);

        $parentnav = MenuNavbar::create([
            'code' => 'mn-0',
            'navbar_id' => $navbar1->id,
            'nama' => 'Menu 1',
        ]);

        $menunav = MenuNavbar::create([
            'code' => 'Mn-0-1',
            'nama' => 'Sub Menu 1',
            'has_materi' => true,
            'parent_id' => $parentnav->id,
        ]);

        MasterMateri::create([
            'judul' => ' ini materi 1',
            'slug' => ' ini-materi-1',
            'konten' => 'ini konten masbmssnks kjsnbk ksnalksn ksanlskcnls kslnckslnclsk kslncslkncls',
            'menu_navbar_id' => $menunav->id,
        ]);

        MasterMateri::create([
            'judul' => ' ini materi 2',
            'slug' => ' ini-materi-2',
            'konten' => 'ini konten mas'
        ]);



        $pertemuan2 = Pertemuan::create([
            'nama' => 'Pertemuan 2',
            'code' => 'p-2',
            'pembelajaran_id' => $pembelajaran->id,
        ]);

        $parent = MenuPertemuan::create([
            'code' => 'M-0',
            'pertemuan_id' => $pertemuan2->id,
            'nama' => 'Menu 1',
        ]);
        $menu = MenuPertemuan::create([
            'code' => 'M-0-1',
            'nama' => 'Sub Menu 1',
            'parent_id' => $parent->id,
        ]);


        $parent1 = MenuPertemuan::create([
            'code' => 'M-1',
            'pertemuan_id' => $pertemuan1->id,
            'nama' => 'Menu 1',
        ]);
        $menu1 = MenuPertemuan::create([
            'code' => 'M-1-1',
            'pertemuan_id' => $pertemuan1->id,
            'nama' => 'Sub Menu 1',
            'parent_id' => $parent1->id,
        ]);
        $menu2 = MenuPertemuan::create([
            'code' => 'M-1-2',
            'pertemuan_id' => $pertemuan1->id,
            'nama' => 'Sub Menu 2',
            'parent_id' => $parent1->id,
        ]);
        $menu3 = MenuPertemuan::create([
            'code' => 'M-1-3',
            'pertemuan_id' => $pertemuan1->id,
            'nama' => 'SUb Menu 3',
            'parent_id' => $parent1->id,
        ]);


        $master_soal = MasterSoal::create([
            'menu_pertemuan_id' => $menu->id
        ]);
        $master_soal1 = MasterSoal::create([
            'menu_pertemuan_id' => $menu1->id
        ]);
        $master_soal2 = MasterSoal::create([
            'menu_pertemuan_id' => $menu2->id
        ]);
        $master_soal3 = MasterSoal::create([
            'menu_pertemuan_id' => $menu3->id
        ]);

        $main_soal1 = MainSoal::create([
            'code' => 'ms-1',
            'index' => 'A',
            'judul' => 'Membangkitkan Representasi (Generating Representation)',
            'master_soal_id' => $master_soal1->id
        ]);
        $main_soal = MainSoal::create([
            'code' => 'ms-0',
            'master_soal_id' => $master_soal->id
        ]);

        Soal::factory(2)->create([
            'index' => 1,
            'type_soal' => 'esai',
            'type_jawaban' => 'multi',
            'qty_jawaban' => '4',
            'main_soal_id' => $main_soal
        ]);
        Soal::factory()->create([
            'index' => 1,
            'type_soal' => 'esai',
            'main_soal_id' => $main_soal1
        ]);
        Soal::factory()->create([
            'index' => 2,
            'type_soal' => 'esai',
            'main_soal_id' => $main_soal1
        ]);
        $soal_ganda1 = Soal::factory()->create([
            'index' => 3,
            'type_soal' => 'ganda',
            'main_soal_id' => $main_soal1
        ]);

        Soal::factory()->create([
            'index' => 4,
            'type_soal' => 'esai',
            'main_soal_id' => $main_soal1
        ]);

        PilihanJawaban::create([
            'index' => 'A',
            'jawaban' => 'Pilihan 1',
            'soal_id' => $soal_ganda1->id
        ]);
        PilihanJawaban::create([
            'index' => 'B',
            'is_true' => true,
            'jawaban' => 'Pilihan 2',
            'soal_id' => $soal_ganda1->id
        ]);
        PilihanJawaban::create([
            'index' => 'C',
            'jawaban' => 'Pilihan 3',
            'soal_id' => $soal_ganda1->id
        ]);



        $main_soal2 = MainSoal::create([
            'code' => 'ms-2',
            'index' => 'B',
            'judul' => 'Mentranslasi Representasi (Translating Representation)',
            'master_soal_id' => $master_soal1->id
        ]);

        Soal::factory()->create([
            'index' => 1,
            'type_soal' => 'esai',
            'type_penyelesaian' => 'kelompok',
            'main_soal_id' => $main_soal2
        ]);
        Soal::factory()->create([
            'index' => 2,
            'type_soal' => 'esai',
            'type_penyelesaian' => 'kelompok',
            'main_soal_id' => $main_soal2
        ]);
        $soal_ganda2 = Soal::factory()->create([
            'index' => 3,
            'type_soal' => 'ganda',
            'main_soal_id' => $main_soal2
        ]);

        Soal::factory()->create([
            'index' => 4,
            'type_soal' => 'esai',
            'main_soal_id' => $main_soal2
        ]);

        PilihanJawaban::create([
            'index' => 'A',
            'is_true' => true,
            'jawaban' => 'Pilihan 1',
            'soal_id' => $soal_ganda2->id
        ]);
        PilihanJawaban::create([
            'index' => 'B',
            'jawaban' => 'Pilihan 2',
            'soal_id' => $soal_ganda2->id
        ]);
        PilihanJawaban::create([
            'index' => 'C',
            'jawaban' => 'Pilihan 3',
            'soal_id' => $soal_ganda2->id
        ]);

        $main_soal3 = MainSoal::create([
            'code' => 'ms-3',
            'index' => 'C',
            'judul' => 'Konsistensi Ilmiah (Scientific Consistency)',
            'master_soal_id' => $master_soal1->id
        ]);

        Soal::factory()->create([
            'index' => 1,
            'type_soal' => 'esai',
            'main_soal_id' => $main_soal3
        ]);
        Soal::factory()->create([
            'index' => 2,
            'type_soal' => 'esai',
            'main_soal_id' => $main_soal3
        ]);
        $soal_ganda3 = Soal::factory()->create([
            'index' => 3,
            'type_soal' => 'ganda',
            'main_soal_id' => $main_soal3
        ]);

        Soal::factory()->create([
            'index' => 4,
            'type_soal' => 'esai',
            'main_soal_id' => $main_soal3
        ]);

        PilihanJawaban::create([
            'index' => 'A',
            'jawaban' => 'Pilihan 1',
            'soal_id' => $soal_ganda3->id
        ]);
        PilihanJawaban::create([
            'index' => 'B',
            'jawaban' => 'Pilihan 2',
            'soal_id' => $soal_ganda3->id
        ]);
        PilihanJawaban::create([
            'index' => 'C',
            'is_true' => true,
            'jawaban' => 'Pilihan 3',
            'soal_id' => $soal_ganda3->id
        ]);


        $main_soal4 = MainSoal::create([
            'code' => 'ms-4',
            'master_soal_id' => $master_soal2->id
        ]);
        Soal::factory()->create([
            'index' => 1,
            'type_soal' => 'esai',
            'main_soal_id' => $main_soal4
        ]);
        Soal::factory()->create([
            'index' => 2,
            'type_soal' => 'esai',
            'main_soal_id' => $main_soal4
        ]);
        $soal_ganda4 = Soal::factory()->create([
            'index' => 3,
            'type_soal' => 'ganda',
            'main_soal_id' => $main_soal4
        ]);

        Soal::factory()->create([
            'index' => 4,
            'type_soal' => 'esai',
            'main_soal_id' => $main_soal4
        ]);

        PilihanJawaban::create([
            'index' => 'A',
            'jawaban' => 'Pilihan 1',
            'soal_id' => $soal_ganda4->id
        ]);
        PilihanJawaban::create([
            'index' => 'B',
            'jawaban' => 'Pilihan 2',
            'soal_id' => $soal_ganda4->id
        ]);
        PilihanJawaban::create([
            'index' => 'C',
            'is_true' => true,
            'jawaban' => 'Pilihan 3',
            'soal_id' => $soal_ganda4->id
        ]);


        $main_soal5 = MainSoal::create([
            'code' => 'ms-5',
            'master_soal_id' => $master_soal3->id
        ]);

        Soal::factory()->create([
            'index' => 1,
            'type_soal' => 'esai',
            'main_soal_id' => $main_soal5
        ]);
        Soal::factory()->create([
            'index' => 2,
            'type_soal' => 'esai',
            'main_soal_id' => $main_soal5
        ]);
        $soal_ganda5 = Soal::factory()->create([
            'index' => 3,
            'type_soal' => 'ganda',
            'main_soal_id' => $main_soal5
        ]);

        Soal::factory()->create([
            'index' => 4,
            'type_soal' => 'esai',
            'main_soal_id' => $main_soal5
        ]);

        PilihanJawaban::create([
            'index' => 'A',
            'jawaban' => 'Pilihan 1',
            'soal_id' => $soal_ganda5->id
        ]);
        PilihanJawaban::create([
            'index' => 'B',
            'is_true' => true,
            'jawaban' => 'Pilihan 2',
            'soal_id' => $soal_ganda5->id
        ]);
        PilihanJawaban::create([
            'index' => 'C',
            'jawaban' => 'Pilihan 3',
            'soal_id' => $soal_ganda5->id
        ]);
    }
}
