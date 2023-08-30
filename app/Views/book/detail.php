<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">DATA BUKU</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Pengelolaan Data Buku</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                <?= $title ?>
            </div>
            <div class="card-body">
                <!-- Isi Detail -->
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4 d-flex flex-column align-item-center justify-content-center">
                            <img src="https://cdn.pixabay.com/photo/2017/01/31/00/09/book-2022464_960_720.png" alt="" width="50%" class="mx-auto d-block p-1">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?= $hasil['title'] ?></h5>
                                <p class="card-text">Penulis:<br><?= $hasil['author'] ?></p>
                                <p class="card-text">Tahun Rilis: <?= $hasil['release_year'] ?></p>
                                <p class="card-text">Stok: <?= $hasil['stock'] ?></p>
                                <p class="card-text">Harga: <?= $hasil['price'] ?></p>
                                <p class="card-text">Diskon: <?= $hasil['discount'] ?></p>
                                <div class="d-grid gap-2 d-md-block">
                                    <a class="btn btn-dark" type="button" href="<?= base_url('book') ?>">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- -->
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>