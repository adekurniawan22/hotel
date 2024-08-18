<?php

namespace App\Controllers;

use App\Models\ReservasiModel;
use App\Models\DetailReservasiModel;
use App\Models\KamarModel;
use CodeIgniter\Controller;

class ReservasiController extends Controller
{
    protected $reservasiModel;
    protected $detailReservasiModel;
    protected $kamarModel;

    public function __construct()
    {
        $this->reservasiModel = new ReservasiModel();
        $this->detailReservasiModel = new DetailReservasiModel();
        $this->kamarModel = new KamarModel();
    }

    // Controller: Reservasi.php
    public function updateStatus()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        $data = [
            'status' => $status
        ];

        $success = $this->reservasiModel->update($id, $data);

        return $this->response->setJSON(['success' => $success]);
    }


    public function index()
    {
        $data = [
            'title' => 'Reservasi',
            'reservasi' => $this->reservasiModel->findAll(),
        ];
        return view('reservasi/list', $data);
    }

    public function create()
    {
        $kamarModel = new KamarModel();
        $kamar = $kamarModel->getAvailableKamar();

        $kamar = array_filter($kamar, function ($item) {
            return $item['jumlah_kamar'] != $item['jumlah_pesan'];
        });

        $data = [
            'title' => 'Tambah Reservasi',
            'kamar' => $kamar,
        ];
        return view('reservasi/tambah', $data);
    }

    public function store()
    {
        $reservasiData = [
            'nama_pemesan' => $this->request->getPost('nama_pemesan'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'tanggal_checkin' => $this->request->getPost('tanggal_checkin'),
            'tanggal_checkout' => $this->request->getPost('tanggal_checkout'),
            'status' => $this->request->getPost('status'),
        ];

        $this->reservasiModel->insert($reservasiData);
        $reservasiId = $this->reservasiModel->getInsertID();

        $kamarIds = $this->request->getPost('kamar_id');
        $jumlahPesans = $this->request->getPost('jumlah_pesan');

        foreach ($kamarIds as $index => $kamarId) {
            if (isset($jumlahPesans[$index]) && is_numeric($jumlahPesans[$index]) && $jumlahPesans[$index] > 0) {
                $detailData = [
                    'id_reservasi' => $reservasiId,
                    'id_kamar' => $kamarId,
                    'jumlah_kamar' => $jumlahPesans[$index]
                ];

                $this->detailReservasiModel->insert($detailData);
            }
        }

        session()->setFlashdata('success', 'Reservasi berhasil ditambahkan!');
        return redirect()->to('/reservasi');
    }

    public function edit($id)
    {
        $reservasi = $this->reservasiModel->find($id);
        $kamar = $this->kamarModel->getAvailableKamar();
        $detailReservasi = $this->detailReservasiModel->where('id_reservasi', $id)->findAll();

        $checkedItems = [];
        foreach ($detailReservasi as $detail) {
            $checkedItems[$detail['id_kamar']] = [
                'namaKamar' => $this->kamarModel->find($detail['id_kamar'])['nama_kamar'],
                'jumlahPesan' => $detail['jumlah_kamar']
            ];
        }

        $data = [
            'title' => 'Edit Reservasi',
            'kamar' => $kamar,
            'reservasi' => $reservasi,
            'checkedItems' => $checkedItems
        ];

        return view('reservasi/edit', $data);
    }


    public function update($id)
    {
        $status = $this->request->getPost('status');
        $userId = session()->get('user_id');

        // Mendapatkan data reservasi yang ada
        $reservasi = $this->reservasiModel->find($id);

        $this->reservasiModel->update($id, [
            'nama_pemesan' => $this->request->getPost('nama_pemesan'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'tanggal_checkin' => $this->request->getPost('tanggal_checkin'),
            'tanggal_checkout' => $this->request->getPost('tanggal_checkout'),
            'status' => $status
        ]);

        if ($status == 'gagal' || $status == 'pending') {
            $diKonfirmasi = null;
        } else {
            $diKonfirmasi = ($status == 'dikonfirmasi') ? $userId : $reservasi['dikonfirmasi'];
        }

        // Memperbarui data dalam model
        $this->reservasiModel->update($id, [
            'dikonfirmasi' => $diKonfirmasi,
        ]);

        $this->detailReservasiModel->where('id_reservasi', $id)->delete();

        $kamarIds = $this->request->getPost('kamar_id');
        $jumlahPesans = $this->request->getPost('jumlah_pesan');

        foreach ($kamarIds as $index => $kamarId) {
            if (isset($jumlahPesans[$index]) && is_numeric($jumlahPesans[$index]) && $jumlahPesans[$index] > 0) {
                $detailData = [
                    'id_reservasi' => $id,
                    'id_kamar' => $kamarId,
                    'jumlah_kamar' => $jumlahPesans[$index]
                ];

                $this->detailReservasiModel->insert($detailData);
            }
        }

        if ($status == 'dikonfirmasi') {
            $totalHargaKeseluruhan = 0; // Inisialisasi total harga keseluruhan

            $message = '<p>Terima kasih atas pemesanan Anda di Hotel kami. Pesanan anda sudah dikonfirmasi. Berikut adalah detail pemesanan Anda:</p>';
            $message .= '<p><strong>Nama Pemesan:</strong> ' . $this->request->getPost('nama_pemesan') . '</p>';
            $message .= '<p><strong>Email:</strong> ' . $this->request->getPost('email') . '</p>';
            $message .= '<p><strong>No. HP:</strong> ' . $this->request->getPost('no_hp') . '</p>';
            $message .= '<p><strong>Tanggal Check-in:</strong> ' . $this->request->getPost('tanggal_checkin') . '</p>';
            $message .= '<p><strong>Tanggal Check-out:</strong> ' . $this->request->getPost('tanggal_checkout') . '</p>';

            $message .= '<p><strong>Detail Pemesanan Kamar:</strong></p>';
            $message .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
            $message .= '<thead><tr><th>Nama Kamar</th><th>Harga per Kamar</th><th>Jumlah</th><th>Total Harga</th></tr></thead>';
            $message .= '<tbody>';

            foreach ($kamarIds as $index => $kamarId) {
                if (isset($jumlahPesans[$index]) && is_numeric($jumlahPesans[$index]) && $jumlahPesans[$index] > 0) {
                    $kamar = $this->kamarModel->find($kamarId);
                    $hargaKamar = $kamar['harga']; // Misalkan 'harga' adalah nama kolom harga di tabel kamar
                    $jumlahKamar = $jumlahPesans[$index];
                    $totalHarga = $hargaKamar * $jumlahKamar;

                    // Tambah total harga ke total keseluruhan
                    $totalHargaKeseluruhan += $totalHarga;

                    $message .= '<tr>';
                    $message .= '<td style="text-align: center;">' . $kamar['nama_kamar'] . '</td>'; // Misalkan 'nama_kamar' adalah nama kolom nama kamar di tabel kamar
                    $message .= '<td style="text-align: center;">Rp. ' . number_format($hargaKamar, 2, ',', '.') . '</td>'; // Format harga
                    $message .= '<td style="text-align: center;">x ' . $jumlahKamar . '</td>';
                    $message .= '<td style="text-align: center;">Rp. ' . number_format($totalHarga, 2, ',', '.') . '</td>'; // Format total harga
                    $message .= '</tr>';
                }
            }

            $message .= '<tr><td colspan="3" style="text-align: right;"><strong>Total Keseluruhan:</strong></td>';
            $message .= '<td style="text-align: center;">Rp. ' . number_format($totalHargaKeseluruhan, 2, ',', '.') . '</td></tr>';
            $message .= '</tbody>';
            $message .= '</table><br>';

            $message .= '<p>Silakan tunjukin bukti email ini ketika melakukan check-in di hotel pada waktu yang telah ditentukan. Jika Anda memiliki pertanyaan mengenai pembayaran atau prosedur check-in, Anda dapat menghubungi kami melalui email di hotelade@email.com.</p>';
            $message .= '<p>Terima kasih dan selamat berlibur!</p>';

            $email = \Config\Services::email();
            $email->setFrom('appcilogin@gmail.com', 'Tim Hotel');
            $email->setTo($this->request->getPost('email'));
            $email->setSubject('Pemesanan Kamar Telah Di Konfirmasi');
            $email->setMessage($message);
            $email->setMailType('html'); // Mengirim email dalam format HTML

            $email->send();
        }

        session()->setFlashdata('success', 'Reservasi berhasil diperbarui!');
        return redirect()->to('/reservasi');
    }

    public function delete($id)
    {
        // Hapus detail reservasi terkait
        $this->detailReservasiModel->where('id_reservasi', $id)->delete();

        // Hapus reservasi
        $this->reservasiModel->delete($id);

        session()->setFlashdata('success', 'Reservasi berhasil dihapus!');
        return redirect()->to('/reservasi');
    }

    public function detail()
    {
        $id = $this->request->getPost('id');

        if (!$id) {
            return $this->response->setStatusCode(400, 'Invalid ID');
        }

        $reservasi = $this->reservasiModel->find($id);
        if (!$reservasi) {
            return $this->response->setStatusCode(404, 'Reservasi not found');
        }

        $details = $this->detailReservasiModel->getDetailWithKamar($id);
        if (!$details) {
            return $this->response->setStatusCode(404, 'Details not found');
        }

        // Gabungkan data reservasi dan detail
        $result = [
            'nama_pemesan' => $reservasi['nama_pemesan'],
            'email' => $reservasi['email'],
            'no_hp' => $reservasi['no_hp'],
            'tanggal_checkin' => $reservasi['tanggal_checkin'],
            'tanggal_checkout' => $reservasi['tanggal_checkout'],
            'status' => $reservasi['status'],
            'details' => $details
        ];

        return $this->response->setJSON($result);
    }

    public function createKamar($id)
    {
        $data['kamar'] = $this->kamarModel->getOneKamar($id);
        $allRooms = $this->kamarModel->getAvailableKamar();
        $availableRooms = array_filter($allRooms, function ($item) use ($id) {
            return $item['jumlah_kamar'] > $item['jumlah_pesan'];
        });

        $data['kamar_lain'] = $availableRooms;
        $data['id_kamar'] = $id;

        return view('reservasi/pesan', $data);
    }

    public function storeKamar($id)
    {
        $reservasiData = [
            'nama_pemesan' => $this->request->getPost('nama_pemesan'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'tanggal_checkin' => $this->request->getPost('tanggal_checkin'),
            'tanggal_checkout' => $this->request->getPost('tanggal_checkout'),
            'status' => 'pending',
        ];

        $this->reservasiModel->insert($reservasiData);
        $reservasiId = $this->reservasiModel->getInsertID();

        if (isset($_POST['order_another_room'])) {
            $kamarIds = $this->request->getPost('kamar');
            $jumlahPesans = $this->request->getPost('jumlah');

            foreach ($kamarIds as $index => $kamarId) {
                if (isset($jumlahPesans[$index]) && is_numeric($jumlahPesans[$index]) && $jumlahPesans[$index] > 0) {
                    $detailData = [
                        'id_reservasi' => $reservasiId,
                        'id_kamar' => $kamarId,
                        'jumlah_kamar' => $jumlahPesans[$index]
                    ];

                    $this->detailReservasiModel->insert($detailData);
                }
            }
        } else {
            $detailData = [
                'id_reservasi' => $reservasiId,
                'id_kamar' => $this->request->getPost('id_kamar'),
                'jumlah_kamar' => $this->request->getPost('jumlah_pesan'),
            ];

            $this->detailReservasiModel->insert($detailData);
        }

        $totalHargaKeseluruhan = 0; // Inisialisasi total harga keseluruhan

        $message = '<p>Terima kasih atas pemesanan Anda di Hotel kami. Berikut adalah detail pemesanan Anda:</p>';
        $message .= '<p><strong>Nama Pemesan:</strong> ' . $this->request->getPost('nama_pemesan') . '</p>';
        $message .= '<p><strong>Email:</strong> ' . $this->request->getPost('email') . '</p>';
        $message .= '<p><strong>No. HP:</strong> ' . $this->request->getPost('no_hp') . '</p>';
        $message .= '<p><strong>Tanggal Check-in:</strong> ' . $this->request->getPost('tanggal_checkin') . '</p>';
        $message .= '<p><strong>Tanggal Check-out:</strong> ' . $this->request->getPost('tanggal_checkout') . '</p>';

        $message .= '<p><strong>Detail Pemesanan Kamar:</strong></p>';
        $message .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
        $message .= '<thead><tr><th>Nama Kamar</th><th>Harga per Kamar</th><th>Jumlah</th><th>Total Harga</th></tr></thead>';
        $message .= '<tbody>';

        if (isset($_POST['order_another_room'])) {
            $kamarIds = $this->request->getPost('kamar');
            $jumlahPesans = $this->request->getPost('jumlah');

            foreach ($kamarIds as $index => $kamarId) {
                if (isset($jumlahPesans[$index]) && is_numeric($jumlahPesans[$index]) && $jumlahPesans[$index] > 0) {
                    $kamar = $this->kamarModel->find($kamarId);
                    $hargaKamar = $kamar['harga']; // Misalkan 'harga' adalah nama kolom harga di tabel kamar
                    $jumlahKamar = $jumlahPesans[$index];
                    $totalHarga = $hargaKamar * $jumlahKamar;

                    // Tambah total harga ke total keseluruhan
                    $totalHargaKeseluruhan += $totalHarga;

                    $message .= '<tr>';
                    $message .= '<td style="text-align: center;">' . $kamar['nama_kamar'] . '</td>'; // Misalkan 'nama_kamar' adalah nama kolom nama kamar di tabel kamar
                    $message .= '<td style="text-align: center;">Rp. ' . number_format($hargaKamar, 2, ',', '.') . '</td>'; // Format harga
                    $message .= '<td style="text-align: center;">x ' . $jumlahKamar . '</td>';
                    $message .= '<td style="text-align: center;">Rp. ' . number_format($totalHarga, 2, ',', '.') . '</td>'; // Format total harga
                    $message .= '</tr>';
                }
            }
        } else {
            $kamarId = $this->request->getPost('id_kamar');
            $jumlahPesan = $this->request->getPost('jumlah_pesan');
            $kamar = $this->kamarModel->find($kamarId);
            $hargaKamar = $kamar['harga'];
            $totalHarga = $hargaKamar * $jumlahPesan;

            // Tambah total harga ke total keseluruhan
            $totalHargaKeseluruhan += $totalHarga;

            $message .= '<tr>';
            $message .= '<td style="text-align: center;">' . $kamar['nama_kamar'] . '</td>';
            $message .= '<td style="text-align: center;">Rp. ' . number_format($hargaKamar, 2, ',', '.') . '</td>';
            $message .= '<td style="text-align: center;">x ' . $jumlahPesan . '</td>';
            $message .= '<td style="text-align: center;">Rp. ' . number_format($totalHarga, 2, ',', '.') . '</td>';
            $message .= '</tr>';
        }

        $message .= '<tr><td colspan="3" style="text-align: right;"><strong>Total Keseluruhan:</strong></td>';
        $message .= '<td style="text-align: center;">Rp. ' . number_format($totalHargaKeseluruhan, 2, ',', '.') . '</td></tr>';
        $message .= '</tbody>';
        $message .= '</table><br>';

        $message .= '<p>Silakan melakukan check-in di hotel pada waktu yang telah ditentukan. Jika Anda memiliki pertanyaan mengenai pembayaran atau prosedur check-in, Anda dapat menghubungi kami melalui email di hotelade@email.com, datang langsung ke hotel, atau menunggu kami menghubungi Anda dalam waktu dekat.</p>';
        $message .= '<p>Terima kasih dan selamat berlibur!</p>';

        $email = \Config\Services::email();
        $email->setFrom('appcilogin@gmail.com', 'Tim Hotel');
        $email->setTo($this->request->getPost('email'));
        $email->setSubject('Konfirmasi Pemesanan Kamar');
        $email->setMessage($message);
        $email->setMailType('html'); // Mengirim email dalam format HTML

        if ($email->send()) {
            session()->setFlashdata('success', 'Pemesanan berhasil. <br>Silakan periksa email Anda untuk detail lebih lanjut.');
        } else {
            session()->setFlashdata('error', 'Pemesanan berhasil, tetapi kami mengalami kesulitan mengirim email konfirmasi.');
        }

        return redirect()->to('/');
    }

    public function createKamarMultiple()
    {
        $kamar = $this->kamarModel->getAvailableKamar();

        $kamar = array_filter($kamar, function ($item) {
            return $item['jumlah_kamar'] != $item['jumlah_pesan'];
        });

        $data['kamar'] = $kamar;

        return view('reservasi/pesan_multiple', $data);
    }

    public function storeKamarMultiple()
    {
        $reservasiData = [
            'nama_pemesan' => $this->request->getPost('nama_pemesan'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'tanggal_checkin' => $this->request->getPost('tanggal_checkin'),
            'tanggal_checkout' => $this->request->getPost('tanggal_checkout'),
            'status' => 'pending',
        ];

        $this->reservasiModel->insert($reservasiData);
        $reservasiId = $this->reservasiModel->getInsertID();

        $kamarIds = $this->request->getPost('kamar');
        $jumlahPesans = $this->request->getPost('jumlah');

        foreach ($kamarIds as $index => $kamarId) {
            if (isset($jumlahPesans[$index]) && is_numeric($jumlahPesans[$index]) && $jumlahPesans[$index] > 0) {
                $detailData = [
                    'id_reservasi' => $reservasiId,
                    'id_kamar' => $kamarId,
                    'jumlah_kamar' => $jumlahPesans[$index]
                ];

                $this->detailReservasiModel->insert($detailData);
            }
        }

        $totalHargaKeseluruhan = 0; // Inisialisasi total harga keseluruhan

        $message = '<p>Terima kasih atas pemesanan Anda di Hotel kami. Berikut adalah detail pemesanan Anda:</p>';
        $message .= '<p><strong>Nama Pemesan:</strong> ' . $this->request->getPost('nama_pemesan') . '</p>';
        $message .= '<p><strong>Email:</strong> ' . $this->request->getPost('email') . '</p>';
        $message .= '<p><strong>No. HP:</strong> ' . $this->request->getPost('no_hp') . '</p>';
        $message .= '<p><strong>Tanggal Check-in:</strong> ' . $this->request->getPost('tanggal_checkin') . '</p>';
        $message .= '<p><strong>Tanggal Check-out:</strong> ' . $this->request->getPost('tanggal_checkout') . '</p>';

        $message .= '<p><strong>Detail Pemesanan Kamar:</strong></p>';
        $message .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
        $message .= '<thead><tr><th>Nama Kamar</th><th>Harga per Kamar</th><th>Jumlah</th><th>Total Harga</th></tr></thead>';
        $message .= '<tbody>';
        $kamarIds = $this->request->getPost('kamar');
        $jumlahPesans = $this->request->getPost('jumlah');

        foreach ($kamarIds as $index => $kamarId) {
            if (isset($jumlahPesans[$index]) && is_numeric($jumlahPesans[$index]) && $jumlahPesans[$index] > 0) {
                $kamar = $this->kamarModel->find($kamarId);
                $hargaKamar = $kamar['harga']; // Misalkan 'harga' adalah nama kolom harga di tabel kamar
                $jumlahKamar = $jumlahPesans[$index];
                $totalHarga = $hargaKamar * $jumlahKamar;

                // Tambah total harga ke total keseluruhan
                $totalHargaKeseluruhan += $totalHarga;

                $message .= '<tr>';
                $message .= '<td style="text-align: center;">' . $kamar['nama_kamar'] . '</td>'; // Misalkan 'nama_kamar' adalah nama kolom nama kamar di tabel kamar
                $message .= '<td style="text-align: center;">Rp. ' . number_format($hargaKamar, 2, ',', '.') . '</td>'; // Format harga
                $message .= '<td style="text-align: center;">x ' . $jumlahKamar . '</td>';
                $message .= '<td style="text-align: center;">Rp. ' . number_format($totalHarga, 2, ',', '.') . '</td>'; // Format total harga
                $message .= '</tr>';
            }
        }

        $message .= '<tr><td colspan="3" style="text-align: right;"><strong>Total Keseluruhan:</strong></td>';
        $message .= '<td style="text-align: center;">Rp. ' . number_format($totalHargaKeseluruhan, 2, ',', '.') . '</td></tr>';
        $message .= '</tbody>';
        $message .= '</table><br>';

        $message .= '<p>Silakan melakukan check-in di hotel pada waktu yang telah ditentukan. Jika Anda memiliki pertanyaan mengenai pembayaran atau prosedur check-in, Anda dapat menghubungi kami melalui email di hotelade@email.com, datang langsung ke hotel, atau menunggu kami menghubungi Anda dalam waktu dekat.</p>';
        $message .= '<p>Terima kasih dan selamat berlibur!</p>';

        $email = \Config\Services::email();
        $email->setFrom('appcilogin@gmail.com', 'Tim Hotel');
        $email->setTo($this->request->getPost('email'));
        $email->setSubject('Konfirmasi Pemesanan Kamar');
        $email->setMessage($message);
        $email->setMailType('html'); // Mengirim email dalam format HTML

        if ($email->send()) {
            session()->setFlashdata('success', 'Pemesanan berhasil. <br>Silakan periksa email Anda untuk detail lebih lanjut.');
        } else {
            session()->setFlashdata('error', 'Pemesanan berhasil, tetapi kami mengalami kesulitan mengirim email konfirmasi.');
        }

        return redirect()->to('/');
    }
}
