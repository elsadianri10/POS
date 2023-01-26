<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="row justify-content-center">
    <div class="col-lg-10">
<div class="card">
  <div class="card-header">
    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sn" data-toggle="modal" data-target="#addmodal">
  <i class="fas fa-plus"></i>
</button>
  </div>
  <div class="card-body">
    <table class="table table-hover datatable text-center">
        <thead>
            <th style="width: 40px;">#</th>
            <th>Nama</th>
            <th>Level</th>
            <th></th>
        </thead>
        <tbody>
        <?php $no = 1; ?>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= ucwords($user->nama); ?></td>
                        <td><?= $user->role; ?></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="addmodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addmodalLabel">Add Anggota</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/newUser" method="post"></form>
      <div class="modal-body">
        <?= $csrf_field(); ?>
             <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                <input type="text" class="form-control-sm" id="Nama" name="nama">
                </div>
            </div>
            <div class="form-group row">
                <label for="username" class="col-sm-2 col-form-label-sm">Username</label>
                <div class="col-sm-10">
                <input type="text" class="form-control-sm" id="Username" name="username">
                </div>
            </div>

            <div class="form-group row">
                        <label for="level" class="col-sm-2 col-form-label col-form-label-sm">Level</label>
                        <div class="col-sm-10">
                            <select id="level" class="form-control">
                                <option selected>Choose</option>
                                <?php foreach($levels as $level) : ?>
                                    <option value="<?= $level->id; ?>"> <?= $level->role; ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="Aktif" name="Aktif" value="1">
                        <label class="custom-control-label" for="aktif">Aktif</label>
                    </div>
                </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?= $this->endsection(); ?>