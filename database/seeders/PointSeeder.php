<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PointModel;

class PointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pointFaseA = [
            [
                'elemen_id' => 1,
                'point_name' => 'Mengenal sifat-sifat utama Tuhan Yang Maha Esa bahwa Dia adalah Sang
                Pencipta yang Maha Pengasih dan Maha Penyayang dan mengenali kebaikan dirinya sebagai cerminan sifat Tuhan.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 1,
                'point_name' => 'Mengenal unsur-unsur utama agama/kepercayaan (ajaran, ritual
                keagamaan, kitab suci, dan orang suci/utusan Tuhan YME).',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 1,
                'point_name' => 'Terbiasa melaksanakan ibadah sesuai ajaran agama/kepercayaannya.',
                'fase' => 'a'
            ],
            
            [
                'elemen_id' => 2,
                'point_name' => 'Membiasakan bersikap jujur terhadap diri sendiri dan orang lain dan berani
                menyampaikan kebenaran atau fakta.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 2,
                'point_name' => 'Memiliki rutinitas sederhana yang diatur secara mandiri dan dijalankan
                sehari-hari serta menjaga kesehatan dan keselamatan/keamanan diri dalam
                semua aktivitas kesehariannya.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 3,
                'point_name' => 'Mengenali hal-hal yang sama dan berbeda yang dimiliki diri dan temannya
                dalam berbagai hal, serta memberikan respons secara positif.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 3,
                'point_name' => 'Mengidentifikasi emosi, minat, dan kebutuhan orang-orang terdekat dan
                meresponsnya secara positif.',
                'fase' => 'a'
            ],

            [
                'elemen_id' => 4,
                'point_name' => 'Mengidentifikasi berbagai ciptaan Tuhan.                ',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 4,
                'point_name' => 'Membiasakan bersyukur atas lingkungan alam sekitar dan berlatih untuk
                menjaganya.',
                'fase' => 'a'
            ],

            [
                'elemen_id' => 5,
                'point_name' => 'Mengidentifikasi hak dan tanggung jawabnya di rumah, sekolah, dan
                lingkungan sekitar serta kaitannya dengan keimanan kepada Tuhan YME.',
                'fase' => 'a'
            ],

            [
                'elemen_id' => 6,
                'point_name' => 'Mengidentifikasi dan mendeskripsikan ide-ide tentang dirinya dan beberapa
                kelompok di lingkungan sekitarnya.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 6,
                'point_name' => 'Mengidentifikasi dan mendeskripsikan praktik keseharian diri dan
                budayanya.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 6,
                'point_name' => 'Mendeskripsikan pengalaman dan pemahaman hidup bersama-sama dalam
                kemajemukan.',
                'fase' => 'a'
            ],

            [
                'elemen_id' => 7,
                'point_name' => 'Mengenali bahwa diri dan orang lain menggunakan kata, gambar, dan
                bahasa tubuh yang dapat memiliki makna yang berbeda di lingkungan
                sekitarnya.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 7,
                'point_name' => 'Mengekspresikan pandangannya terhadap topik yang umum dan
                mendengarkan sudut pandang orang lain yang berbeda dari dirinya dalam
                lingkungan keluarga dan sekolah.',
                'fase' => 'a'
            ],

            [
                'elemen_id' => 8,
                'point_name' => 'Menyebutkan apa yang telah dipelajari tentang orang lain dari interaksinya
                dengan kemajemukan budaya di lingkungan sekolah dan rumah.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Mengenali perbedaan tiap orang atau kelompok dan menyikapinya sebagai
                kewajaran.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Mengidentifikasi perbedaan budaya yang konkret di lingkungan sekitar.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Menjalin pertemanan tanpa memandang perbedaan agama, suku, ras, jenis
                kelamin, dan perbedaan lainnya, dan mengenal masalah-masalah sosial,
                ekonomi, dan lingkungan di lingkungan sekitarnya.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Mengidentifikasi pilihan-pilihan berdasarkan kebutuhan dirinya dan orang
                lain ketika membuat keputusan.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Mengidentifikasi peran, hak dan kewajiban warga dalam masyarakat
                demokratis.',
                'fase' => 'a'
            ],

            [
                'elemen_id' => 9,
                'point_name' => 'Menerima dan melaksanakan tugas serta peran yang diberikan kelompok
                dalam sebuah kegiatan bersama.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 9,
                'point_name' => 'Memahami informasi sederhana dari orang lain dan menyampaikan
                informasi sederhana kepada orang lain menggunakan kata-katanya sendiri.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 9,
                'point_name' => 'Mengenali kebutuhan-kebutuhan diri sendiri yang memerlukan orang lain
                dalam pemenuhannya.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 9,
                'point_name' => 'Melaksanakan aktivitas kelompok sesuai dengan kesepakatan bersama
                dengan bimbingan, dan saling mengingatkan adanya kesepakatan tersebut.',
                'fase' => 'a'
            ],

            [
                'elemen_id' => 10,
                'point_name' => 'Peka dan mengapresiasi orang-orang di lingkungan sekitar, kemudian
                melakukan tindakan sederhana untuk mengungkapkannya.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 10,
                'point_name' => 'Mengenali berbagai reaksi orang lain di lingkungan sekitar dan
                penyebabnya.',
                'fase' => 'a'
            ],

            [
                'elemen_id' => 11,
                'point_name' => 'Memberi dan menerima hal yang dianggap berharga dan penting
                kepada/dari orang-orang di lingkungan sekitar.',
                'fase' => 'a'
            ],

            [
                'elemen_id' => 12,
                'point_name' => 'Mengidentifikasi dan menggambarkan kemampuan, prestasi, dan
                ketertarikannya secara subjektif.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 12,
                'point_name' => 'Melakukan refleksi untuk mengidentifikasi kekuatan dan kelemahan, serta
                prestasi dirinya.',
                'fase' => 'a'
            ],

            [
                'elemen_id' => 13,
                'point_name' => 'Mengidentifikasi perbedaan emosi yang dirasakannya dan situasi-situasi
                yang menyebabkannya; serta mengekspresikan secara wajar.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Menetapkan target belajar dan merencanakan waktu dan tindakan belajar
                yang akan dilakukannya.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Berinisiatif untuk mengerjakan tugas-tugas rutin secara mandiri di bawah
                pengawasan dan dukungan orang dewasa.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Melaksanakan kegiatan belajar di kelas dan menyelesaikan tugas-tugas
                dalam waktu yang telah disepakati.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Berani mencoba dan adaptif menghadapi situasi baru serta bertahan
                mengerjakan tugas-tugas yang disepakati hingga tuntas.',
                'fase' => 'a'
            ],

            [
                'elemen_id' => 14,
                'point_name' => 'Mengajukan pertanyaan untuk menjawab keingintahuannya dan untuk
                mengidentifikasi suatu permasalahan mengenai dirinya dan lingkungan
                sekitarnya.',
                'fase' => 'a'
            ],
            [
                'elemen_id' => 14,
                'point_name' => 'Mengidentifikasi dan mengolah informasi dan gagasan.',
                'fase' => 'a'
            ],

            [
                'elemen_id' => 15,
                'point_name' => 'Melakukan penalaran konkret dan memberikan alasan dalam menyelesaikan
                masalah dan mengambil keputusan.',
                'fase' => 'a'
            ],

            [
                'elemen_id' => 16,
                'point_name' => 'Menyampaikan apa yang sedang dipikirkan secara terperinci.',
                'fase' => 'a'
            ],

            [
                'elemen_id' => 17,
                'point_name' => 'Menggabungkan beberapa gagasan menjadi ide atau gagasan imajinatif
                yang bermakna untuk mengekspresikan pikiran dan/atau perasaannya.',
                'fase' => 'a'
            ],

            [
                'elemen_id' => 18,
                'point_name' => 'Mengeksplorasi dan mengekspresikan pikiran dan/atau perasaannya dalam
                bentuk karya dan/atau tindakan serta mengapresiasi karya dan tindakan
                yang dihasilkan.',
                'fase' => 'a'
            ],

            [
                'elemen_id' => 19,
                'point_name' => 'Mengidentifikasi gagasan-gagasan kreatif untuk menghadapi situasi dan
                permasalahan.',
                'fase' => 'a'
            ],
        ];

        $pointFaseB = [
            [
                'elemen_id' => 1,
                'point_name' => 'Memahami sifat-sifat Tuhan utama lainnya dan mengaitkan sifat-sifat
                tersebut dengan konsep dirinya dan ciptaan-Nya.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 1,
                'point_name' => 'Mengenal unsur-unsur utama agama/kepercayaan (simbol-simbol
                keagamaan dan sejarah agama/kepercayaan).',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 1,
                'point_name' => 'Terbiasa melaksanakan ibadah wajib sesuai tuntunan
                agama/kepercayaannya.',
                'fase' => 'b'
            ],

            [
                'elemen_id' => 2,
                'point_name' => 'Membiasakan melakukan refleksi tentang pentingnya bersikap jujur dan
                berani menyampaikan kebenaran atau fakta.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 2,
                'point_name' => 'Mulai membiasakan diri untuk disiplin, rapi, membersihkan dan merawat
                tubuh, menjaga tingkah laku dan perkataan dalam semua aktivitas
                kesehariannya.',
                'fase' => 'b'
            ],

            [
                'elemen_id' => 3,
                'point_name' => 'Terbiasa mengidentifikasi hal-hal yang sama dan berbeda yang dimiliki diri
                dan temannya dalam berbagai hal serta memberikan respons secara positif.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 3,
                'point_name' => 'Terbiasa memberikan apresiasi di lingkungan sekolah dan masyarakat.',
                'fase' => 'b'
            ],

            [
                'elemen_id' => 4,
                'point_name' => 'Memahami keterhubungan antara satu ciptaan dengan ciptaan Tuhan yang
                lainnya.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 4,
                'point_name' => 'Terbiasa memahami tindakan-tindakan yang ramah dan tidak ramah
                lingkungan serta membiasakan diri untuk berperilaku ramah lingkungan.',
                'fase' => 'b'
            ],

            [
                'elemen_id' => 5,
                'point_name' => 'Mengidentifikasi hak dan tanggung jawab orang-orang di sekitarnya serta
                kaitannya dengan keimanan kepada Tuhan YME.',
                'fase' => 'b'
            ],

            [
                'elemen_id' => 6,
                'point_name' => 'Mengidentifikasi dan mendeskripsikan ide-ide tentang dirinya dan berbagai
                kelompok di lingkungan sekitarnya, serta cara orang lain berperilaku dan
                berkomunikasi dengannya.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 6,
                'point_name' => 'Mengidentifikasi dan membandingkan praktik keseharian diri dan
                budayanya dengan orang lain di tempat dan waktu/era yang berbeda.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 6,
                'point_name' => 'Memahami bahwa kemajemukan dapat memberikan kesempatan untuk
                memperoleh pengalaman dan pemahaman yang baru.',
                'fase' => 'b'
            ],

            [
                'elemen_id' => 7,
                'point_name' => 'Mendeskripsikan penggunaan kata, tulisan dan bahasa tubuh yang memiliki
                makna yang berbeda di lingkungan sekitarnya dan dalam suatu budaya
                tertentu.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 7,
                'point_name' => 'Mengekspresikan pandangannya terhadap topik yang umum dan dapat
                mengenal sudut pandang orang lain. Mendengarkan dan memperkirakan
                sudut pandang orang lain yang berbeda dari dirinya pada situasi di ranah
                sekolah, keluarga, dan lingkungan sekitar.',
                'fase' => 'b'
            ],

            [
                'elemen_id' => 8,
                'point_name' => 'Menyebutkan apa yang telah dipelajari tentang orang lain dari interaksinya
                dengan kemajemukan budaya di lingkungan sekitar.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Mengkonfirmasi dan mengklarifikasi stereotip dan prasangka yang
                dimilikinya tentang orang atau kelompok di sekitarnya untuk mendapatkan
                pemahaman yang lebih baik.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Mengenali bahwa perbedaan budaya mempengaruhi pemahaman antar
                individu.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Mengidentifikasi cara berkontribusi terhadap lingkungan sekolah, rumah
                dan lingkungan sekitarnya yang inklusif, adil dan berkelanjutan.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Berpartisipasi menentukan beberapa pilihan untuk keperluan bersama
                berdasarkan kriteria sederhana.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Memahami konsep hak dan kewajiban, serta implikasinya terhadap
                perilakunya.',
                'fase' => 'b'
            ],

            [
                'elemen_id' => 9,
                'point_name' => 'Menampilkan tindakan yang sesuai dengan harapan dan tujuan kelompok.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 9,
                'point_name' => 'Memahami informasi yang disampaikan (ungkapan pikiran, perasaan, dan
                keprihatinan) orang lain dan menyampaikan informasi secara akurat
                menggunakan berbagai simbol dan media.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 9,
                'point_name' => 'Menyadari bahwa setiap orang membutuhkan orang lain dalam memenuhi
                kebutuhannya dan perlunya saling membantu.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 9,
                'point_name' => 'Menyadari bahwa dirinya memiliki peran yang berbeda dengan orang
                lain/temannya, serta mengetahui konsekuensi perannya terhadap
                ketercapaian tujuan.',
                'fase' => 'b'
            ],

            [
                'elemen_id' => 10,
                'point_name' => 'Peka dan mengapresiasi orang-orang di lingkungan sekitar, kemudian
                melakukan tindakan untuk menjaga keselarasan dalam berelasi dengan
                orang lain.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 10,
                'point_name' => 'Memahami berbagai alasan orang lain menampilkan respon tertentu.',
                'fase' => 'b'
            ],

            [
                'elemen_id' => 11,
                'point_name' => 'Memberi dan menerima hal yang dianggap penting dan berharga
                kepada/dari orang-orang di lingkungan sekitar baik yang dikenal maupun
                tidak dikenal.',
                'fase' => 'b'
            ],

            [
                'elemen_id' => 12,
                'point_name' => 'Mengidentifikasi kemampuan, prestasi, dan ketertarikannya serta tantangan
                yang dihadapi berdasarkan kejadian-kejadian yang dialaminya dalam
                kehidupan sehari-hari.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 12,
                'point_name' => 'Melakukan refleksi untuk mengidentifikasi kekuatan, kelemahan, dan
                prestasi dirinya, serta situasi yang dapat mendukung dan menghambat
                pembelajaran dan pengembangan dirinya.',
                'fase' => 'b'
            ],

            [
                'elemen_id' => 13,
                'point_name' => 'Mengetahui adanya pengaruh orang lain, situasi, dan peristiwa yang terjadi
                terhadap emosi yang dirasakannya; serta berupaya untuk mengekspresikan
                emosi secara tepat dengan mempertimbangkan perasaan dan kebutuhan
                orang lain disekitarnya.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Mengetahui adanya pengaruh orang lain, situasi, dan peristiwa yang terjadi
                terhadap emosi yang dirasakannya; serta berupaya untuk mengekspresikan
                emosi secara tepat dengan mempertimbangkan perasaan dan kebutuhan
                orang lain disekitarnya.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Mempertimbangkan, memilih dan mengadopsi berbagai strategi dan
                mengidentifikasi sumber bantuan yang diperlukan serta berinisiatif
                menjalankannya untuk mendapatkan hasil belajar yang diinginkan.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Menjelaskan pentingnya mengatur diri secara mandiri dan mulai
                menjalankan kegiatan dan tugas yang telah sepakati secara mandiri.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Tetap bertahan mengerjakan tugas ketika dihadapkan dengan tantangan
                dan berusaha menyesuaikan strateginya ketika upaya sebelumnya tidak
                berhasil.',
                'fase' => 'b'
            ],

            [
                'elemen_id' => 14,
                'point_name' => 'Mengajukan pertanyaan untuk mengidentifikasi suatu permasalahan dan
                mengkonfirmasi pemahaman terhadap suatu permasalahan mengenai
                dirinya dan lingkungan sekitarnya.',
                'fase' => 'b'
            ],
            [
                'elemen_id' => 14,
                'point_name' => 'Mengumpulkan, mengklasifikasikan, membandingkan dan memilih informasi
                dan gagasan dari berbagai sumber.',
                'fase' => 'b'
            ],

            [
                'elemen_id' => 15,
                'point_name' => 'Menjelaskan alasan yang relevan dalam penyelesaian masalah dan
                pengambilan keputusan.',
                'fase' => 'b'
            ],

            [
                'elemen_id' => 16,
                'point_name' => 'Menyampaikan apa yang sedang dipikirkan dan menjelaskan alasan dari hal
                yang dipikirkan.',
                'fase' => 'b'
            ],

            [
                'elemen_id' => 17,
                'point_name' => 'Memunculkan gagasan imajinatif baru yang bermakna dari beberapa
                gagasan yang berbeda sebagai ekspresi pikiran dan/atau perasaannya.',
                'fase' => 'b'
            ],

            [
                'elemen_id' => 18,
                'point_name' => 'Mengeksplorasi dan mengekspresikan pikiran dan/atau perasaannya sesuai
                dengan minat dan kesukaannya dalam bentuk karya dan/atau tindakan serta
                mengapresiasi karya dan tindakan yang dihasilkan.',
                'fase' => 'b'
            ],

            [
                'elemen_id' => 19,
                'point_name' => 'Membandingkan gagasan-gagasan kreatif untuk menghadapi situasi dan
                permasalahan.',
                'fase' => 'b'
            ],
        ];

        $pointFaseC = [
            [
                'elemen_id' => 1,
                'point_name' => 'Memahami berbagai kualitas atau sifat-sifat Tuhan Yang Maha Esa yang
                diutarakan dalam kitab suci agama masing-masing dan menghubungkan
                kualitas-kualitas positif Tuhan dengan sikap pribadinya, serta meyakini
                firman Tuhan sebagai kebenaran.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 1,
                'point_name' => 'Memahami unsur-unsur utama agama/kepercayaan, dan mengenali peran
                agama/kepercayaan dalam kehidupan serta memahami ajaran moral agama.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 1,
                'point_name' => 'Melaksanakan ibadah secara rutin sesuai dengan tuntunan
                agama/kepercayaan, berdoa mandiri, merayakan, dan memahami makna
                hari-hari besar.',
                'fase' => 'c'
            ],

            [
                'elemen_id' => 2,
                'point_name' => 'Berani dan konsisten menyampaikan kebenaran atau fakta serta memahami
                konsekuensi-konsekuensinya untuk diri sendiri.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 2,
                'point_name' => 'Memperhatikan kesehatan jasmani, mental, dan rohani dengan melakukan
                aktivitas fisik, sosial, dan ibadah.',
                'fase' => 'c'
            ],

            [
                'elemen_id' => 3,
                'point_name' => 'Mengidentifikasi kesamaan dengan orang lain sebagai perekat hubungan
                sosial dan mewujudkannya dalam aktivitas kelompok.
                Mulai mengenal berbagai kemungkinan interpretasi dan cara pandang yang
                berbeda ketika dihadapkan dengan dilema.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 3,
                'point_name' => 'Mulai memandang sesuatu dari perspektif orang lain serta mengidentifikasi
                kebaikan dan kelebihan orang sekitarnya.',
                'fase' => 'c'
            ],

            [
                'elemen_id' => 4,
                'point_name' => 'Memahami konsep harmoni dan mengidentifikasi adanya saling
                kebergantungan antara berbagai ciptaan Tuhan.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 4,
                'point_name' => 'Mewujudkan rasa syukur dengan terbiasa berperilaku ramah lingkungan dan
                memahami akibat perbuatan tidak ramah lingkungan dalam lingkup kecil
                maupun besar.',
                'fase' => 'c'
            ],

            [
                'elemen_id' => 5,
                'point_name' => 'Mengidentifikasi dan memahami peran, hak, dan kewajiban dasar sebagai
                warga negara serta kaitannya dengan keimanan kepada Tuhan YME dan
                secara sadar mempraktikkannya dalam kehidupan sehari-hari.',
                'fase' => 'c'
            ],

            [
                'elemen_id' => 6,
                'point_name' => 'Mengidentifikasi dan mendeskripsikan keragaman budaya di sekitarnya;
                serta menjelaskan peran budaya dan bahasa dalam membentuk identitas
                dirinya.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 6,
                'point_name' => 'Mendeskripsikan dan membandingkan pengetahuan, kepercayaan, dan
                praktik dari berbagai kelompok budaya.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 6,
                'point_name' => 'Mengidentifikasi peluang dan tantangan yang muncul dari keragaman
                budaya di Indonesia.',
                'fase' => 'c'
            ],

            [
                'elemen_id' => 7,
                'point_name' => 'Memahami persamaan dan perbedaan cara komunikasi baik di dalam
                maupun antar kelompok budaya.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 7,
                'point_name' => 'Membandingkan beragam perspektif untuk memahami permasalahan seharihari. Memperkirakan dan mendeskripsikan situasi komunitas yang berbeda
                dengan dirinya ke dalam situasi dirinya dalam konteks lokal dan regional.',
                'fase' => 'c'
            ],

            [
                'elemen_id' => 8,
                'point_name' => 'Menjelaskan apa yang telah dipelajari dari interaksi dan pengalaman dirinya
                dalam lingkungan yang beragam.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Mengkonfirmasi dan mengklarifikasi stereotip dan prasangka yang
                dimilikinya tentang orang atau kelompok di sekitarnya untuk mendapatkan
                pemahaman yang lebih baik serta mengidentifikasi pengaruhnya terhadap
                individu dan kelompok di lingkungan sekitarnya.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Mencari titik temu nilai budaya yang beragam untuk menyelesaikan
                permasalahan bersama.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Membandingkan beberapa tindakan dan praktik perbaikan lingkungan
                sekolah yang inklusif, adil, dan berkelanjutan, dengan mempertimbangkan
                dampaknya secara jangka panjang terhadap manusia, alam, dan masyarakat.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Berpartisipasi dalam menentukan kriteria yang disepakati bersama untuk
                menentukan pilihan dan keputusan untuk kepentingan bersama.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Memahami konsep hak dan kewajiban, serta implikasinya terhadap
                perilakunya. Menggunakan konsep ini untuk menjelaskan perilaku diri dan
                orang sekitarnya.',
                'fase' => 'c'
            ],

            [
                'elemen_id' => 9,
                'point_name' => 'Menunjukkan ekspektasi (harapan) positif kepada orang lain dalam rangka
                mencapai tujuan kelompok di lingkungan sekitar (sekolah dan rumah).',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 9,
                'point_name' => 'Memahami informasi dari berbagai sumber dan menyampaikan pesan
                menggunakan berbagai simbol dan media secara efektif kepada orang lain
                untuk mencapai tujuan bersama.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 9,
                'point_name' => 'Menyadari bahwa meskipun setiap orang memiliki otonominya masingmasing, setiap orang membutuhkan orang lain dalam memenuhi
                kebutuhannya.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 9,
                'point_name' => 'Menyelaraskan tindakannya sesuai dengan perannya dan
                mempertimbangkan peran orang lain untuk mencapai tujuan bersama.',
                'fase' => 'c'
            ],

            [
                'elemen_id' => 10,
                'point_name' => 'Tanggap terhadap lingkungan sosial sesuai dengan tuntutan peran sosialnya
                dan menjaga keselarasan dalam berelasi dengan orang lain.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 10,
                'point_name' => 'Menerapkan pengetahuan mengenai berbagai reaksi orang lain dan
                penyebabnya dalam konteks keluarga, sekolah, serta pertemanan dengan
                sebaya.',
                'fase' => 'c'
            ],

            [
                'elemen_id' => 11,
                'point_name' => 'Memberi dan menerima hal yang dianggap penting dan berharga
                kepada/dari orangorang di lingkungan luas/masyarakat baik yang dikenal
                maupun tidak dikenal.',
                'fase' => 'c'
            ],

            [
                'elemen_id' => 12,
                'point_name' => 'Menggambarkan pengaruh kualitas dirinya terhadap pelaksanaan dan hasil
                belajar; serta mengidentifikasi kemampuan yang ingin dikembangkan
                dengan mempertimbangkan tantangan yang dihadapinya dan umpan balik
                dari orang dewasa.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 12,
                'point_name' => 'Melakukan refleksi untuk mengidentifikasi faktor-faktor di dalam maupun di
                luar dirinya yang dapat mendukung/menghambatnya dalam belajar dan
                mengembangkan diri; serta mengidentifikasi cara-cara untuk mengatasi
                kekurangannya.',
                'fase' => 'c'
            ],

            [
                'elemen_id' => 13,
                'point_name' => 'Memahami perbedaan emosi yang dirasakan dan dampaknya terhadap
                proses belajar dan interaksinya dengan orang lain; serta mencoba cara-cara
                yang sesuai untuk mengelola emosi agar dapat menunjang aktivitas belajar
                dan interaksinya dengan orang lain.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Menilai faktor-faktor (kekuatan dan kelemahan) yang ada pada dirinya
                dalam upaya mencapai tujuan belajar, prestasi, dan pengembangan dirinya
                serta mencoba berbagai strategi untuk mencapainya.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Memahami arti penting bekerja secara mandiri serta inisiatif untuk
                melakukannya dalam menunjang pembelajaran dan pengembangan dirinya.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Mengidentifikasi faktor-faktor yang dapat mempengaruhi kemampuan
                dalam mengelola diri dalam pelaksanaan aktivitas belajar dan
                pengembangan dirinya.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Menyusun, menyesuaikan, dan mengujicobakan berbagai strategi dan cara
                kerjanya untuk membantu dirinya dalam penyelesaian tugas yang
                menantang.',
                'fase' => 'c'
            ],

            [
                'elemen_id' => 14,
                'point_name' => 'Mengajukan pertanyaan untuk membandingkan berbagai informasi dan
                untuk menambah pengetahuannya.',
                'fase' => 'c'
            ],
            [
                'elemen_id' => 14,
                'point_name' => 'Mengumpulkan, mengklasifikasikan, membandingkan, dan memilih
                informasi dari berbagai sumber, serta memperjelas informasi dengan
                bimbingan orang dewasa.',
                'fase' => 'c'
            ],

            [
                'elemen_id' => 15,
                'point_name' => 'Menjelaskan alasan yang relevan dan akurat dalam penyelesaian masalah
                dan pengambilan keputusan.',
                'fase' => 'c'
            ],

            [
                'elemen_id' => 16,
                'point_name' => 'Memberikan alasan dari hal yang dipikirkan, serta menyadari kemungkinan
                adanya bias pada pemikirannya sendiri.',
                'fase' => 'c'
            ],

            [
                'elemen_id' => 17,
                'point_name' => 'Mengembangkan gagasan yang ia miliki untuk membuat kombinasi hal yang
                baru dan imajinatif untuk mengekspresikan pikiran dan/atau perasaannya.',
                'fase' => 'c'
            ],

            [
                'elemen_id' => 18,
                'point_name' => 'Mengeksplorasi dan mengekspresikan pikiran dan/atau perasaannya sesuai
                dengan minat dan kesukaannya dalam bentuk karya dan/atau tindakan serta
                mengapresiasi dan mengkritisi karya dan tindakan yang dihasilkan.',
                'fase' => 'c'
            ],

            [
                'elemen_id' => 19,
                'point_name' => 'Berupaya mencari solusi alternatif saat pendekatan yang diambil tidak
                berhasil berdasarkan identifikasi terhadap situasi.',
                'fase' => 'c'
            ],
        ];

        $pointFaseD = [
            [
                'elemen_id' => 1,
                'point_name' => 'Memahami kehadiran Tuhan dalam kehidupan sehari-hari serta mengaitkan
                pemahamannya tentang kualitas atau sifat-sifat Tuhan dengan konsep peran
                manusia di bumi sebagai makhluk Tuhan yang bertanggung jawab.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 1,
                'point_name' => 'Memahami makna dan fungsi, unsur-unsur utama agama/kepercayaan
                dalam konteks Indonesia, membaca kitab suci, serta memahami ajaran
                agama/kepercayaan terkait hubungan sesama manusia dan alam semesta.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 1,
                'point_name' => 'Melaksanakan ibadah secara rutin dan mandiri sesuai dengan tuntunan
                agama/kepercayaan, serta berpartisipasi pada perayaan hari-hari besar.',
                'fase' => 'd'
            ],

            [
                'elemen_id' => 2,
                'point_name' => 'Berani dan konsisten menyampaikan kebenaran atau fakta serta memahami
                konsekuensi-konsekuensinya untuk diri sendiri dan orang lain.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 2,
                'point_name' => 'Mengidentifikasi pentingnya menjaga keseimbangan kesehatan jasmani,
                mental, dan rohani serta berupaya menyeimbangkan aktivitas fisik, sosial
                dan ibadah.',
                'fase' => 'd'
            ],

            [
                'elemen_id' => 3,
                'point_name' => 'Mengenal perspektif dan emosi/perasaan dari sudut pandang orang atau
                kelompok lain yang tidak pernah dijumpai atau dikenalnya. Mengutamakan
                persamaan dan menghargai perbedaan sebagai alat pemersatu dalam
                keadaan konflik atau perdebatan.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 3,
                'point_name' => 'Memahami perasaan dan sudut pandang orang dan/atau kelompok lain
                yang tidak pernah dikenalnya.',
                'fase' => 'd'
            ],

            [
                'elemen_id' => 4,
                'point_name' => 'Memahami konsep sebab akibat di antara berbagai ciptaan Tuhan dan
                mengidentifikasi berbagai sebab yang mempunyai dampak baik atau buruk,
                langsung maupun tidak langsung, terhadap alam semesta.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 4,
                'point_name' => 'Mewujudkan rasa syukur dengan berinisiatif untuk menyelesaikan
                permasalahan lingkungan alam sekitarnya dengan mengajukan alternatif
                solusi dan mulai menerapkan solusi tersebut.',
                'fase' => 'd'
            ],

            [
                'elemen_id' => 5,
                'point_name' => 'Menganalisis peran, hak, dan kewajiban sebagai warga negara, memahami
                perlunya mengutamakan kepentingan umum di atas kepentingan pribadi
                sebagai wujud dari keimanannya kepada Tuhan YME.',
                'fase' => 'd'
            ],

            [
                'elemen_id' => 6,
                'point_name' => 'Memahami perubahan budaya seiring waktu dan sesuai konteks, baik dalam
                skala lokal, regional, dan nasional. Menjelaskan identitas diri yang terbentuk
                dari budaya bangsa.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 6,
                'point_name' => 'Memahami dinamika budaya yang mencakup pemahaman, kepercayaan,
                dan praktik keseharian dalam konteks personal dan sosial.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 6,
                'point_name' => 'Memahami pentingnya melestarikan dan merayakan tradisi budaya untuk
                mengembangkan identitas pribadi, sosial, dan bangsa Indonesia serta mulai
                berupaya melestarikan budaya dalam kehidupan sehari-hari.',
                'fase' => 'd'
            ],

            [
                'elemen_id' => 7,
                'point_name' => 'Mengeksplorasi pengaruh budaya terhadap penggunaan bahasa serta dapat
                mengenali risiko dalam berkomunikasi antar budaya.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 7,
                'point_name' => 'Menjelaskan asumsi-asumsi yang mendasari perspektif tertentu.
                Memperkirakan dan mendeskripsikan perasaan serta motivasi komunitas
                yang berbeda dengan dirinya yang berada dalam situasi yang sulit.',
                'fase' => 'd'
            ],

            [
                'elemen_id' => 8,
                'point_name' => 'Merefleksikan secara kritis gambaran berbagai kelompok budaya yang
                ditemui dan cara meresponnya.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Mengkonfirmasi, mengklarifikasi dan menunjukkan sikap menolak stereotip
                serta prasangka tentang gambaran identitas kelompok dan suku bangsa.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Mengidentifikasi dan menyampaikan isu-isu tentang penghargaan terhadap
                keragaman dan kesetaraan budaya.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Mengidentifikasi masalah yang ada di sekitarnya sebagai akibat dari pilihan
                yang dilakukan oleh manusia, serta dampak masalah tersebut terhadap
                sistem ekonomi, sosial dan lingkungan, serta mencari solusi yang
                memperhatikan prinsip-prinsip keadilan terhadap manusia, alam dan
                masyarakat.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Berpartisipasi dalam menentukan kriteria dan metode yang disepakati
                bersama untuk menentukan pilihan dan keputusan untuk kepentingan
                bersama melalui proses bertukar pikiran secara cermat dan terbuka dengan
                panduan pendidik.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Memahami konsep hak dan kewajiban serta implikasinya terhadap ekspresi
                dan perilakunya. Mulai aktif mengambil sikap dan langkah untuk melindungi
                hak orang/kelompok lain.',
                'fase' => 'd'
            ],

            [
                'elemen_id' => 9,
                'point_name' => 'Menyelaraskan tindakan sendiri dengan tindakan orang lain untuk
                melaksanakan kegiatan dan mencapai tujuan kelompok di lingkungan
                sekitar, serta memberi semangat kepada orang lain untuk bekerja efektif
                dan mencapai tujuan bersama.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 9,
                'point_name' => 'Memahami informasi, gagasan, emosi, keterampilan dan keprihatinan yang
                diungkapkan oleh orang lain menggunakan berbagai simbol dan media
                secara efektif, serta memanfaatkannya untuk meningkatkan kualitas
                hubungan interpersonal guna mencapai tujuan bersama.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 9,
                'point_name' => 'Mendemonstrasikan kegiatan kelompok yang menunjukkan bahwa anggota
                kelompok dengan kelebihan dan kekurangannya masing-masing perlu dan
                dapat saling membantu memenuhi kebutuhan.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 9,
                'point_name' => 'Membagi peran dan menyelaraskan tindakan dalam kelompok serta
                menjaga tindakan agar selaras untuk mencapai tujuan bersama.',
                'fase' => 'd'
            ],

            [
                'elemen_id' => 10,
                'point_name' => 'Tanggap terhadap lingkungan sosial sesuai dengan tuntutan peran sosialnya
                dan berkontribusi sesuai dengan kebutuhan masyarakat.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 10,
                'point_name' => 'Menggunakan pengetahuan tentang sebab dan alasan orang lain
                menampilkan reaksi tertentu untuk menentukan tindakan yang tepat agar
                orang lain menampilkan respon yang diharapkan.',
                'fase' => 'd'
            ],

            [
                'elemen_id' => 11,
                'point_name' => 'Mengupayakan memberi hal yang dianggap penting dan berharga kepada
                masyarakat yang membutuhkan bantuan di sekitar tempat tinggal.',
                'fase' => 'd'
            ],

            [
                'elemen_id' => 12,
                'point_name' => 'Membuat penilaian yang realistis terhadap kemampuan dan minat, serta
                prioritas pengembangan diri berdasarkan pengalaman belajar dan aktivitas
                lain yang dilakukannya.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 12,
                'point_name' => 'Memonitor kemajuan belajar yang dicapai serta memprediksi tantangan
                pribadi dan akademik yang akan muncul berlandaskan pada pengalamannya
                untuk mempertimbangkan strategi belajar yang sesuai.',
                'fase' => 'd'
            ],

            [
                'elemen_id' => 13,
                'point_name' => 'Memahami dan memprediksi konsekuensi dari emosi dan
                pengekspresiannya dan menyusun langkah-langkah untuk mengelola
                emosinya dalam pelaksanaan belajar dan berinteraksi dengan orang lain.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Merancang strategi yang sesuai untuk menunjang pencapaian tujuan
                belajar, prestasi, dan pengembangan diri dengan mempertimbangkan
                kekuatan dan kelemahan dirinya, serta situasi yang dihadapi.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Mengkritisi efektivitas dirinya dalam bekerja secara mandiri dengan
                mengidentifikasi hal-hal yang menunjang maupun menghambat dalam
                mencapai tujuan.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Berkomitmen dan menjaga konsistensi pencapaian tujuan yang telah
                direncanakannya untuk mencapai tujuan belajar dan pengembangan diri
                yang diharapkannya.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Membuat rencana baru dengan mengadaptasi, dan memodifikasi strategi
                yang sudah dibuat ketika upaya sebelumnya tidak berhasil, serta
                menjalankan kembali tugasnya dengan keyakinan baru.',
                'fase' => 'd'
            ],

            [
                'elemen_id' => 14,
                'point_name' => 'Mengajukan pertanyaan untuk klarifikasi dan interpretasi informasi, serta
                mencari tahu penyebab dan konsekuensi dari informasi tersebut.',
                'fase' => 'd'
            ],
            [
                'elemen_id' => 14,
                'point_name' => 'Mengidentifikasi, mengklarifikasi, dan menganalisis informasi yang relevan
                serta memprioritaskan beberapa gagasan tertentu.',
                'fase' => 'd'
            ],

            [
                'elemen_id' => 15,
                'point_name' => 'Menalar dengan berbagai argumen dalam mengambil suatu simpulan atau
                keputusan.',
                'fase' => 'd'
            ],

            [
                'elemen_id' => 16,
                'point_name' => 'Menjelaskan asumsi yang digunakan, menyadari kecenderungan dan
                konsekuensi bias pada pemikirannya, serta berusaha mempertimbangkan
                perspektif yang berbeda.',
                'fase' => 'd'
            ],

            [
                'elemen_id' => 17,
                'point_name' => 'Menghubungkan gagasan yang ia miliki dengan informasi atau gagasan baru
                untuk menghasilkan kombinasi gagasan baru dan imajinatif untuk
                mengekspresikan pikiran dan/atau perasaannya.',
                'fase' => 'd'
            ],

            [
                'elemen_id' => 18,
                'point_name' => 'Mengeksplorasi dan mengekspresikan pikiran dan/atau perasaannya dalam
                bentuk karya dan/atau tindakan, serta mengevaluasinya dan
                mempertimbangkan dampaknya bagi orang lain.',
                'fase' => 'd'
            ],

            [
                'elemen_id' => 19,
                'point_name' => 'Menghasilkan solusi alternatif dengan mengadaptasi berbagai gagasan dan
                umpan balik untuk menghadapi situasi dan permasalahan.',
                'fase' => 'd'
            ],
        ];

        $pointFaseE = [
            [
                'elemen_id' => 1,
                'point_name' => 'Menerapkan pemahamannya tentang kualitas atau sifat-sifat Tuhan dalam
                ritual ibadahnya baik ibadah yang bersifat personal maupun sosial.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 1,
                'point_name' => 'Memahami struktur organisasi, unsur-unsur utama agama/kepercayaan
                dalam konteks Indonesia, memahami kontribusi agama/kepercayaan
                terhadap peradaban dunia.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 1,
                'point_name' => 'Melaksanakan ibadah secara rutin dan mandiri serta menyadari arti penting
                ibadah tersebut dan berpartisipasi aktif pada kegiatan keagamaan atau
                kepercayaan.',
                'fase' => 'e'
            ],

            [
                'elemen_id' => 2,
                'point_name' => 'Menyadari bahwa aturan agama dan sosial merupakan aturan yang baik dan
                menjadi bagian dari diri sehingga bisa menerapkannya secara bijak dan
                kontekstual.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 2,
                'point_name' => 'Melakukan aktivitas fisik, sosial, dan ibadah secara seimbang.',
                'fase' => 'e'
            ],

            [
                'elemen_id' => 3,
                'point_name' => 'Mengidentifikasi hal yang menjadi permasalahan bersama, memberikan
                alternatif solusi untuk menjembatani perbedaan dengan mengutamakan
                kemanusiaan.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 3,
                'point_name' => 'Memahami dan menghargai perasaan dan sudut pandang orang dan/atau
                kelompok lain.',
                'fase' => 'e'
            ],

            [
                'elemen_id' => 4,
                'point_name' => 'Mengidentifikasi masalah lingkungan hidup di tempat ia tinggal dan
                melakukan langkah-langkah konkret yang bisa dilakukan untuk menghindari
                kerusakan dan menjaga keharmonisan ekosistem yang ada di lingkungannya.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 4,
                'point_name' => 'Mewujudkan rasa syukur dengan membangun kesadaran peduli lingkungan
                alam dengan menciptakan dan mengimplementasikan solusi dari
                permasalahan lingkungan yang ada.',
                'fase' => 'e'
            ],

            [
                'elemen_id' => 5,
                'point_name' => 'Menggunakan hak dan melaksanakan kewajiban kewarganegaraan dan
                terbiasa mendahulukan kepentingan umum di atas kepentingan pribadi
                sebagai wujud dari keimanannya kepada
                Tuhan YME.',
                'fase' => 'e'
            ],

            [
                'elemen_id' => 6,
                'point_name' => 'Menganalisis pengaruh keanggotaan kelompok lokal, regional, nasional, dan
                global terhadap pembentukan identitas, termasuk identitas dirinya. Mulai
                menginternalisasi identitas diri sebagai bagian dari budaya bangsa.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 6,
                'point_name' => 'Menganalisis dinamika budaya yang mencakup pemahaman, kepercayaan,
                dan praktik keseharian dalam rentang waktu yang panjang dan konteks yang
                luas.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 6,
                'point_name' => 'Mempromosikan pertukaran budaya dan kolaborasi dalam dunia yang saling
                terhubung serta menunjukkannya dalam perilaku.',
                'fase' => 'e'
            ],

            [
                'elemen_id' => 7,
                'point_name' => 'Menganalisis hubungan antara bahasa, pikiran, dan konteks untuk
                memahami dan meningkatkan komunikasi antarbudaya yang berbeda-beda.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 7,
                'point_name' => 'Menyajikan pandangan yang seimbang mengenai permasalahan yang dapat
                menimbulkan pertentangan pendapat. Memosisikan orang lain dan budaya
                yang berbeda darinya secara setara, serta bersedia memberikan
                pertolongan ketika orang lain berada dalam situasi sulit.',
                'fase' => 'e'
            ],

            [
                'elemen_id' => 8,
                'point_name' => 'Merefleksikan secara kritis dampak dari pengalaman hidup di lingkungan
                yang beragam terkait dengan perilaku, kepercayaan serta tindakannya
                terhadap orang lain.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Mengkritik dan menolak stereotip serta prasangka tentang gambaran
                identitas kelompok dan suku bangsa serta berinisiatif mengajak orang lain
                untuk menolak stereotip dan prasangka.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Mengetahui tantangan dan keuntungan hidup dalam lingkungan dengan
                budaya yang beragam, serta memahami pentingnya kerukunan antar
                budaya dalam kehidupan bersama yang harmonis.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Berinisiatif melakukan suatu tindakan berdasarkan identifikasi masalah
                untuk mempromosikan keadilan, keamanan ekonomi, menopang ekologi
                dan demokrasi sambil menghindari kerugian jangka panjang terhadap
                manusia, alam ataupun masyarakat.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Berpartisipasi menentukan pilihan dan keputusan untuk kepentingan
                bersama melalui proses bertukar pikiran secara cermat dan terbuka secara
                mandiri.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 8,
                'point_name' => 'Memahami konsep hak dan kewajiban, serta implikasinya terhadap ekspresi
                dan perilakunya. Mulai mencari solusi untuk dilema terkait konsep hak dan
                kewajibannya.',
                'fase' => 'e'
            ],

            [
                'elemen_id' => 9,
                'point_name' => 'Membangun tim dan mengelola kerjasama untuk mencapai tujuan bersama
                sesuai dengan target yang sudah ditentukan.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 9,
                'point_name' => 'Aktif menyimak untuk memahami dan menganalisis informasi, gagasan,
                emosi, keterampilan dan keprihatinan yang disampaikan oleh orang lain dan
                kelompok menggunakan berbagai simbol dan media secara efektif, serta
                menggunakan berbagai strategi komunikasi untuk menyelesaikan masalah
                guna mencapai berbagai tujuan bersama.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 9,
                'point_name' => 'Menyelaraskan kapasitas kelompok agar para anggota kelompok dapat
                saling membantu satu sama lain memenuhi kebutuhan mereka baik secara
                individual maupun kolektif.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 9,
                'point_name' => 'Menyelaraskan dan menjaga tindakan diri dan anggota kelompok agar
                sesuai antara satu dengan lainnya serta menerima konsekuensi tindakannya
                dalam rangka mencapai tujuan bersama.',
                'fase' => 'e'
            ],

            [
                'elemen_id' => 10,
                'point_name' => 'Tanggap terhadap lingkungan sosial sesuai dengan tuntutan peran sosialnya
                dan berkontribusi sesuai dengan kebutuhan masyarakat untuk menghasilkan
                keadaan yang lebih baik.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 10,
                'point_name' => 'Melakukan tindakan yang tepat agar orang lain merespon sesuai dengan
                yang diharapkan dalam rangka penyelesaian pekerjaan dan pencapaian
                tujuan.',
                'fase' => 'e'
            ],

            [
                'elemen_id' => 11,
                'point_name' => 'Mengupayakan memberi hal yang dianggap penting dan berharga kepada
                orang-orang yang membutuhkan di masyarakat yang lebih luas (negara,
                dunia).',
                'fase' => 'e'
            ],

            [
                'elemen_id' => 12,
                'point_name' => 'Mengidentifikasi kekuatan dan tantangan-tantangan yang akan dihadapi
                pada konteks pembelajaran, sosial dan pekerjaan yang akan dipilihnya di
                masa depan.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 12,
                'point_name' => 'Melakukan refleksi terhadap umpan balik dari teman, guru, dan orang
                dewasa lainnya, serta informasi-informasi karir yang akan dipilihnya untuk
                menganalisis karakteristik dan keterampilan yang dibutuhkan dalam
                menunjang atau menghambat karirnya di masa depan.',
                'fase' => 'e'
            ],

            [
                'elemen_id' => 13,
                'point_name' => 'Mengendalikan dan menyesuaikan emosi yang dirasakannya secara tepat
                ketika menghadapi situasi yang menantang dan menekan pada konteks
                belajar, relasi, dan pekerjaan.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Mengevaluasi efektivitas strategi pembelajaran digunakannya, serta
                menetapkan tujuan belajar, prestasi, dan pengembangan diri secara spesifik
                dan merancang strategi yang sesuai untuk menghadapi tantangantantangan yang akan dihadapi pada konteks pembelajaran, sosial dan
                pekerjaan yang akan dipilihnya di masa depan.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Menentukan prioritas pribadi, berinisiatif mencari dan mengembangkan
                pengetahuan dan keterampilan yang spesifik sesuai tujuan di masa depan.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Melakukan tindakan-tindakan secara konsisten guna mencapai tujuan karir
                dan pengembangan dirinya di masa depan, serta berusaha mencari dan
                melakukan alternatif tindakan lain yang dapat dilakukan ketika menemui
                hambatan.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 13,
                'point_name' => 'Menyesuaikan dan mulai menjalankan rencana dan strategi pengembangan
                dirinya dengan mempertimbangkan minat dan tuntutan pada konteks
                belajar maupun pekerjaan yang akan dijalaninya di masa depan, serta
                berusaha untuk mengatasi tantangan-tantangan yang ditemui.',
                'fase' => 'e'
            ],

            [
                'elemen_id' => 14,
                'point_name' => 'Mengajukan pertanyaan untuk menganalisis secara kritis permasalahan yang
                kompleks dan abstrak.',
                'fase' => 'e'
            ],
            [
                'elemen_id' => 14,
                'point_name' => 'Secara kritis mengklarifikasi serta menganalisis gagasan dan informasi yang
                kompleks dan abstrak dari berbagai sumber. Memprioritaskan suatu
                gagasan yang paling relevan dari hasil klarifikasi dan analisis.',
                'fase' => 'e'
            ],

            [
                'elemen_id' => 15,
                'point_name' => 'Menganalisis dan mengevaluasi penalaran yang digunakannya dalam
                menemukan dan mencari solusi serta mengambil keputusan.',
                'fase' => 'e'
            ],

            [
                'elemen_id' => 16,
                'point_name' => 'Menjelaskan alasan untuk mendukung pemikirannya dan memikirkan
                pandangan yang mungkin berlawanan dengan pemikirannya dan mengubah
                pemikirannya jika diperlukan.',
                'fase' => 'e'
            ],

            [
                'elemen_id' => 17,
                'point_name' => 'Menghasilkan gagasan yang beragam untuk mengekspresikan pikiran
                dan/atau perasaannya, menilai gagasannya, serta memikirkan segala
                risikonya dengan mempertimbangkan banyak perspektif seperti etika dan
                nilai kemanusiaan ketika gagasannya direalisasikan.',
                'fase' => 'e'
            ],

            [
                'elemen_id' => 18,
                'point_name' => 'Mengeksplorasi dan mengekspresikan pikiran dan/atau perasaannya dalam
                bentuk karya dan/atau tindakan, serta mengevaluasinya dan
                mempertimbangkan dampak dan risikonya bagi diri dan lingkungannya
                dengan menggunakan berbagai perspektif.',
                'fase' => 'e'
            ],

            [
                'elemen_id' => 19,
                'point_name' => 'Bereksperimen dengan berbagai pilihan secara kreatif untuk memodifikasi
                gagasan sesuai dengan perubahan situasi.',
                'fase' => 'e'
            ],
        ];

        foreach ($pointFaseA as $key => $value) {
            PointModel::create($value);
        }

        foreach ($pointFaseB as $key => $value) {
            PointModel::create($value);
        }

        foreach ($pointFaseC as $key => $value) {
            PointModel::create($value);
        }

        foreach ($pointFaseD as $key => $value) {
            PointModel::create($value);
        }

        foreach ($pointFaseE as $key => $value) {
            PointModel::create($value);
        }
    }
}
