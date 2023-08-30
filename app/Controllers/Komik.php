<?php

namespace App\Controllers;

use App\Models\CategoryKomik;
use \App\Models\KomikModel;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

define('_TITLE', 'Data Komik');

class Komik extends BaseController
{
    private $komikModel, $catModel;
    public function __construct()
    {
        $this->komikModel = new komikModel();
        $this->catModel = new CategoryKomik();
    }

    public function index()
    {
        $datakomik   = $this->komikModel->getBook();
        $data = [
            'title' => _TITLE,
            'data_komik' => $datakomik
        ];
        // dd($data_komik);
        return view('komik/index', $data);
    }

    public function detail($slug)
    {
        $data_komik = $this->komikModel->getBook($slug);
        $data = [
            'title' => _TITLE,
            'data_komik' => $data_komik
        ];
        // dd($data_komik);
        return view('komik/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Komik',
            'category' => $this->catModel->findAll(),
            'validation' => \Config\Services::validation(),
        ];
        // dd($data_komik);
        return view('komik/create', $data);
    }

    public function edit($slug)
    {
        $datakomik = $this->komikModel->getBook($slug);
        if (empty($datakomik)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Judul buku $slug tidak ditemukan!");
        }

        $data = [
            'title' => 'Ubah Buku',
            'category' => $this->catModel->findAll(),
            'validation' => \Config\Services::validation(),
            'result' => $datakomik
        ];
        // dd($data);
        return view('komik/edit', $data);
    }

    public function delete($id)
    {
        $datakomik = $this->komikModel->where(['komik_id' => $id])->first();
        $file_cover_lama = $datakomik['cover'];

        $this->komikModel->delete($id);
        if ($file_cover_lama != $this->defaultImage) {
            unlink('img/' . $file_cover_lama);
        }
        session()->setFlashdata("msg", "Data berhasil dihapus!");
        return redirect()->to('/komik');
    }

    public function update($id)
    {
        // CEK JUDUL
        $dataOld = $this->komikModel->getBook($this->request->getVar('slug'));
        if ($dataOld['title'] == $this->request->getVar('title')) {
            $rule_title = 'required';
        } else {
            $rule_title = 'required';
        }
        // VALIDASI INPUT
        if (!$this->validate([
            'title' => [
                'rules' => 'required',
                'label' => 'Judul',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            'author' => [
                'rules' => 'required',
                'label' => 'Penulis',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'release_year' => [
                'rules' => 'required|integer',
                'label' => 'Tahun Rilis',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'integer' => '{field} hanya boleh Angka!'
                ]
            ],
            'price' => [
                'rules' => 'required|numeric',
                'label' => 'Harga',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'numeric' => '{field} hanya boleh Angka!'
                ]
            ],
            'stock' =>  [
                'rules' => 'required|integer',
                'label' => 'Stok',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'integer' => '{field} hanya boleh Angka!'
                ]
            ],
            'cover' => [
                'rules' => 'max_size[cover,10240]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Gambar tidak boleh lebih dari 10MB',
                    'is_image' => 'Yang ada pilih bukan gambar!',
                    'mime_in' => 'Yang anda pilih bukan gambar!',
                ]
            ],
        ])) {
            return redirect()->to('komik/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $OldFileName = $this->request->getVar('OldCover');
        $fileCover = $this->request->getFile('cover');
        if ($fileCover->getError() == 4) {
            $fileName = $OldFileName;
        } else {
            $fileName = $fileCover->getRandomName();
            $fileCover->move('img/', $fileName);

            if ($OldFileName != $this->defaultImage && $OldFileName != "") {
                unlink('img/' . $OldFileName);
            }
        }

        $slug = url_title($this->request->getVar('title'), '-', true);
        $this->komikModel->save([
            'komik_id' => $id,
            'title' => $this->request->getVar('title'),
            'author' => $this->request->getVar('author'),
            'release_year' => $this->request->getVar('release_year'),
            'price' => $this->request->getVar('price'),
            'stock' => $this->request->getVar('stock'),
            'komik_category_id' => $this->request->getVar('komik_category_id'),
            'slug' => $slug,
            'cover' => $fileName,
        ]);
        session()->setFlashdata("msg", "Data Berhasil Diubah!");
        return redirect()->to('/komik');
    }

    public function importData()
    {
        $file = $this->request->getFile("file");
        $ext = $file->getExtension();
        if ($ext == "xls")
            $reader = new Xls();
        else
            $reader = new Xlsx();

        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        foreach ($sheet as $key => $value) {
            if ($key == 0) continue;

            $namaFile = $this->defaultImage;
            $slug = url_title($value[1], '-', true);

            //Cek judul
            $dataOld = $this->komikModel->getBook($slug);
            if (!$dataOld) {
                $this->komikModel->save([
                    'title' => $value[1],
                    'author' => $value[2],
                    'release_year' => $value[3],
                    'price' => $value[4],
                    'stock' => $value[5],
                    'komik_category_id' => $value[6],
                    'slug' => $slug,
                    'cover' => $namaFile
                ]);
            }
        }
        session()->setFlashdata("msg", "Data berhasil diimport!");

        return redirect()->to('/komik');
    }

    public function save()
    {
        // VALIDASI INPUT
        if (!$this->validate([
            'title' => [
                'rules' => 'required|is_unique[komik.title]',
                'label' => 'Judul',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} hanya sudah ada'
                ]
            ],
            'author' => [
                'rules' => 'required',
                'label' => 'Penulis',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'release_year' => [
                'rules' => 'required|integer',
                'label' => 'Tahun Rilis',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'integer' => '{field} hanya boleh Angka!'
                ]
            ],
            'price' => [
                'rules' => 'required|numeric',
                'label' => 'Harga',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'numeric' => '{field} hanya boleh Angka!'
                ]
            ],
            'stock' =>  [
                'rules' => 'required|integer',
                'label' => 'Stok',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'integer' => '{field} hanya boleh Angka!'
                ]
            ],
            'cover' => [
                'rules' => 'max_size[cover,10240]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Gambar tidak boleh lebih dari 10MB',
                    'is_image' => 'Yang ada pilih bukan gambar!',
                    'mime_in' => 'Yang anda pilih bukan gambar!',
                ]
            ],
        ])) {
            $data = [
                'title' => 'Tambah Komik',
                'category' => $this->catModel->findAll(),
                'validation' => \config\Services::validation()
            ];
            $data['validation'] = $this->validator;
            return view('/komik/create', $data);
        }

        $fileCover = $this->request->getFile('cover');
        if ($fileCover->getError() == 4) {
            $fileName = $this->defaultImage;
        } else {
            $fileName = $fileCover->getRandomName();
            $fileCover->move('img', $fileName);
        }

        $slug = url_title($this->request->getVar('title'), '-', true);
        $this->komikModel->save([
            'title' => $this->request->getVar('title'),
            'author' => $this->request->getVar('author'),
            'release_year' => $this->request->getVar('release_year'),
            'price' => $this->request->getVar('price'),
            'stock' => $this->request->getVar('stock'),
            'komik_category_id' => $this->request->getVar('komik_category_id'),
            'slug' => $slug,
            'cover' => $fileName,
        ]);
        session()->setFlashdata("msg", "Data Berhasil Ditambahkan!");
        return redirect()->to('/komik');
    }
}
