<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">LAPORAN PEMBELIAN</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Laporan Pembelian</li>
        </ol>

        <!-- Alert -->
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif ?>
        <?php if (session()->getFlashdata('warning')) : ?>
            <div class="alert alert-warning" role="alert">
                <?= session()->getFlashdata('warning') ?>`
            </div>
        <?php endif ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif ?>
        <!--  -->

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                <?= $title ?>
            </div>
            <div class="card-body">
                <!-- Filter -->
                <form action="/beli/laporan/filter" method="post">
                    <div class="container">
                        <div class="row">
                            <div class="col-4">
                                <input type="date" class="form-control" name="tgl_awal" value="<?= $tanggal['tgl_awal'] ?>" title="Tanggal Awal">
                            </div>
                            <div class="col-4">
                                <input type="date" class="form-control" name="tgl_akhir" value="<?= $tanggal['tgl_akhir'] ?>" title="Tanggal Akhir">
                            </div>
                            <div class="col-4">
                                <button class="btn-primary">Filter</button>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <!--  -->
                <!-- Isi Report -->
                <a target="_blank" class="btn btn-primary mb-3" type="button" href="<?= base_url('beli/exportpdf') ?>">Export PDF</a>
                <a class="btn btn-dark mb-3" type="button" href="<?= base_url('beli/exportexcel') ?>">Export Excel</a>
                <table id="datatablesSimple3" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nota</th>
                            <th>Tanggal Transaksi</th>
                            <th>User</th>
                            <th>Supplier</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($result as $value) : ?>
                            <tr>
                                <td width="5%"><?= $no++ ?></td>
                                <td width="15%"><?= $value['buy_id'] ?></td>
                                <td width="20%"><?= date("d/m/y H:i:s", strtotime($value['tgl_transaksi'])) ?></td>
                                <td width="20%"><?= $value['firstname'] ?> <?= $value['lastname'] ?></td>
                                <td width="25%"><?= $value['name_supp'] ?></td>
                                <td width="15%"><?= number_to_currency($value['total'], 'IDR', 'id_ID', 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!--  -->
            </div>
        </div>
    </div>
</main>
<?= $this->endsection() ?>