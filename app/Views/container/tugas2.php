<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1>Container</h1>
    <div class="row bg-warning" align="middle" style="height:5vh;">
        <p style=font-weight:bold>Countainer 1 - Gambar</p>
    </div>
    <div class="row " align="middle" style="height:50vh;">
        <div class="col-6 bg-primary">
            <img src="assets/img/rock.jpg" align="center" width="150" height="150" class="rounded" style="height: 80%; padding-top: 30px;">
            <p style=font-weight:bold>Gambar 1</p>

        </div>
        <div class="col-6 bg-success">
            <div class=" h-100 d-flex flex-column align-items-center justify-content-center">
                <img src="assets/img/akatsuki.jpg" width="250" height="250">
                <p style=font-weight:bold>Perang Mulu, Farming kaga</p>
            </div>
        </div>
    </div>
</div>
<br><br>
<div class="container">
    <div class="row bg-warning" align="middle">
        <p style=font-weight:bold>container 2 - Pesan dan Kesan</p>

        <div class="col-7 bg-primary d-flex flex-column align-items-center justify-content-center">

            <p style=font-weight:bold> Pesan :></p>
            <p style=font-weight>seru kog, nilai 100 ya</p>
        </div>
        <div class="col-5 bg-success d-flex flex-column align-items-center justify-content-center">


            <p style=font-weight:bold>Kesan :</p>
            <p style=font-weight>Bagus, keren, meledawg biji kepala</p>
        </div>

    </div>
</div>
<?= $this->endSection() ?>